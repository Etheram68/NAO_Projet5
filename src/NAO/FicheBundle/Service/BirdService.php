<?php

namespace NAO\FicheBundle\Service;

use NAO\MapBundle\Entity\Taxref;
use NAO\UserBundle\Entity\User;
use NAO\FicheBundle\Entity\Bird;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class BirdService
 * @package NAO\FicheBundle\Service
 */
Class BirdService
{
    private $em;
    private $ts;
    private $list_limit;
    private $obseravtions_directory;
    private $translator = null;

    /**
     * FicheService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, TokenStorage $ts, $list_limit, $obseravtions_directory, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->ts = $ts;
        $this->list_limit = $list_limit;
        $this->obseravtions_directory = $obseravtions_directory;
        $this->translator = $translator;
    }

    /**
     * Return X last Bird
     *
     * @param  int $max Number of Bird
     *
     * @return Array      Array of Bird
     */
    public function getLastBird($max)
    {
        $bird = $this->em->getRepository('NAOFicheBundle:Bird')->findBy(
            [
                'status' => Bird::VALIDATED
            ],
            [
                'id' => 'DESC'
            ],
            $max
        );
        return $bird;
    }

    /**
     * Get Fiche list
     *
     * @param string $url
     * @return array
     */
    public function getlist($url = '')
    {
        $user = $this->ts->getToken()->getUser();
        if (!$user) {
            return [];
        }
        $bird = $this->em->getRepository('NAOFicheBundle:Bird')->findByUser($user);
        if (!$bird) {
            return [];
        }
        $response = [];
        foreach ($bird as $bird) {
            $response[] = $this->birdArray($bird, $url);
        }
        return $response;
    }

    /**
     * Convert an observation entity to an array (not all fields)
     *
     * @param Bird $ob
     * @param string $url
     *
     * @return array
     */
    private function birdArray(Bird $ob, $url = '')
    {
        $naturalist = '';
        $n = $ob->getNaturalist();
        if ($n) {
            $naturalist = $n->getName();
        }
        $image = $ob->getImagePath();
        if ($image) {
            $image = $url . '/img/oiseaux/observation/' . $image;
        }
        $bird = [
            'size' => $ob->getSize(),
            'validated' => $ob->getValidated(),
            'weight' => $ob->getWeight(),
            'color' => $ob->getColor(),
            'feature' => $ob->getFeature(),
            'imagePath' => $image,
            'naturalist' => $naturalist,
            'status' => $ob->getStatus(),
            'statusText' => $ob->getStatusString(),
            'TAXREF' => [
                'regnum' => $ob->getTaxref()->getRegnum(),
                'phylum' => $ob->getTaxref()->getPhylum(),
                'classis' => $ob->getTaxref()->getClassis(),
                'ordo' => $ob->getTaxref()->getOrdo(),
                'familia' => $ob->getTaxref()->getFamilia(),
                'scientificId' => $ob->getTaxref()->getScientificId(),
                'taxonId' => $ob->getTaxref()->getTaxonId(),
                'taxonRefId' => $ob->getTaxref()->getTaxonRefId(),
                'taxonRank' => $ob->getTaxref()->getTaxonRank(),
                'taxonSc' => $ob->getTaxref()->getTaxonSc(),
                'author' => $ob->getTaxref()->getAuthor(),
                'fullname' => $ob->getTaxref()->getFullname(),
                'validName' => $ob->getTaxref()->getValidName(),
                'commonName' => $ob->getTaxref()->getCommonName()
            ]
        ];
        return $bird;
    }

    /**
     * Get fiche validate for user
     *
     * @param User $user
     * @return array
     */
    public function getBirdValidate(User $user)
    {
        $bird = $this->em->getRepository('NAOFicheBundle:Bird')->findBy(array(
            'status' => Bird::VALIDATED,
            'user' => $user->getId()
        ));
        return $bird;
    }

    /**
     * @param Paginator $bird
     * @param $page
     * @return array
     */
    public function getPagination(Paginator $bird, $page)
    {
        $totalbird = $bird->count();
        $totalDisplayed = $bird->getIterator()->count();
        $maxPages = ceil($bird->count() / $this->list_limit);
        return ['totalbird' => $totalbird,
            'totalDisplayed' => $totalDisplayed,
            'current' => $page,
            'maxPages' => $maxPages,
            'totalItems' => count($bird)
        ];
    }

    /**
     * Add an fiche
     *
     * @param $bird
     * @return array
     */
    public function add($bird)
    {
        $user = $this->ts->getToken()->getUser();
        if (!$user) {
            return [];
        }
        $bird = new Bird();
        $bird->setUser($user);
        if (isset($bird['size'])) {
            $bird->setSize($bird['size']);
        }
        if (isset($bird['weight'])) {
            $bird->setWeight($bird['weight']);
        }
        if (isset($bird['color'])) {
            $bird->setColor($bird['color']);
        }
        if (isset($bird['feature'])) {
            $bird->setFeature($bird['feature']);
        }
        $bird->setStatus(Bird::WAITING);
        // TAXREF
        if (isset($bird['TAXREF_id'])) {
            $taxref = $this->em->getRepository('NAOMapBundle:Taxref')->findOneById($bird['TAXREF_id']);
            if ($taxref) {
                $bird->setTaxref($taxref);
            }
        }
        $this->em->persist($bird);
        $this->em->flush();
        // Process image after save, because we need to use the birdervation id as filename
        $filename = $bird->getId() . '_' . $user->getId() . '.jpg';
        if (isset($bird['image']) && !empty($bird['image'])) {
            $data = base64_decode($bird['image']);
            file_put_contents('./img/oiseaux/observation/' . $filename, $data);
        } else {
            copy('img/oiseaux/default-image_observation.png', 'img/oiseaux/observation/' . $filename);
        }
        $bird->setImagePath($filename);
        $this->em->persist($bird);
        $this->em->flush();
        return $this->birdArray($bird);
    }

    /**
     * Save Fiche
     *
     * @param Bird $bird
     * @param Form $form
     * @param Request $request
     * @return string
     */
    public function saveBird(Bird $bird, Form $form, Request $request){
        // Get user informations
        $user = $this->ts->getToken()->getUser();
        $bird->setUser($user);
        // User want to save Bird as draft
        if ($form->get('save_draft')->isClicked()) {
            $bird->setStatus(Bird::DRAFT);
            $redirect = 'DRAFT';
        }
        // User want published Bird,
        // only simple user need to have validation
        if ($form->get('save_published')->isClicked()) {
            if ($user->hasRole('ROLE_USER')){
                $bird->setStatus(Bird::WAITING);
                $redirect = 'WAITING';
            }else{
                $bird->setStatus(Bird::VALIDATED);
                $bird->setNaturalist($user);
                $redirect = 'PUBLISHED';
            }
        }
        // Get taxref informations
        $taxref_name    = $request->request->get('bird')['taxref']['customname'];
        $latin_name     = substr($taxref_name, ($p = strpos($taxref_name, '(')+1), strrpos($taxref_name, ')')-$p);
        $taxref         = $this->em->getRepository('NAOMapBundle:Taxref')->findOneBy(array('taxon_sc' => $latin_name));
        $bird->setTaxref($taxref);
        // finaly we need to keep information about Bird image
        $file_upload = $request->files->get('bird');
        if(array_key_exists('imagepath', $file_upload)){
            // Before upload delete existing old Bird image
            if( $bird->getImagePath() !== 'default-image_observation.png'){
                $old_file = $this->obseravtions_directory.'/'. $bird->getImagePath();
            }
            $file = $file_upload['imagepath'];
            if ($file_upload['imagepath'] !== null) {
                $fileName = md5(uniqid()) . '.' . $file->getExtension();
                $file->move($this->obseravtions_directory, $fileName);
                $bird->setImagePath($fileName);
            }
            else{
                $bird->getImagePath() == 'default-image_observation.png';
            }
        }
        $this->em->persist($bird);
        $this->em->flush();
        return $redirect;
    }
}