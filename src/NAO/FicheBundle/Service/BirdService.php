<?php

namespace NAO\FicheBundle\Service;

use NAO\MapBundle\Entity\Taxref;
use NAO\MapBundle\Entity\User;
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
    private $bird_directory;
    private $translator = null;

    /**
     * FicheService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, TokenStorage $ts, $list_limit, $bird_directory, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->ts = $ts;
        $this->list_limit = $list_limit;
        $this->bird_directory = $bird_directory;
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
        $obs = $this->em->getRepository('NAOFicheBundle:Bird')->findBy(
            [
                'status' => Bird::VALIDATED
            ],
            [
                'id' => 'DESC'
            ],
            $max
        );
        return $obs;
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
        $obs = $this->em->getRepository('NAOFicheBundle:Bird')->findByUser($user);
        if (!$obs) {
            return [];
        }
        $response = [];
        foreach ($obs as $ob) {
            $response[] = $this->obsArray($ob, $url);
        }
        return $response;
    }

    /**
     * Get fiche validate for user
     *
     * @param User $user
     * @return array
     */
    public function getBirdValidate(User $user)
    {
        $obs = $this->em->getRepository('NAOFicheBundle:Bird')->findBy(array(
            'status' => Bird::VALIDATED,
            'user' => $user->getId()
        ));
        return $obs;
    }

    /**
     * @param Paginator $obs
     * @param $page
     * @return array
     */
    public function getPagination(Paginator $obs, $page)
    {
        $totalObs = $obs->count();
        $totalDisplayed = $obs->getIterator()->count();
        $maxPages = ceil($obs->count() / $this->list_limit);
        return ['totalObs' => $totalObs,
            'totalDisplayed' => $totalDisplayed,
            'current' => $page,
            'maxPages' => $maxPages,
            'totalItems' => count($obs)
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
        $fch = new Bird();
        $fch->setUser($user);
        if (isset($bird['size'])) {
            $fch->setSize($bird['size']);
        }
        if (isset($bird['weight'])) {
            $fch->setWeight($bird['weight']);
        }
        if (isset($bird['color'])) {
            $fch->setColor($bird['color']);
        }
        if (isset($bird['feature'])) {
            $fch->setFeature($bird['feature']);
        }
        $fch->setStatus(Bird::WAITING);
        // TAXREF
        if (isset($bird['TAXREF_id'])) {
            $taxref = $this->em->getRepository('NAOMapBundle:Taxref')->findOneById($bird['TAXREF_id']);
            if ($taxref) {
                $fch->setTaxref($taxref);
            }
        }
        $this->em->persist($fch);
        $this->em->flush();
        // Process image after save, because we need to use the observation id as filename
        $filename = $fch->getId() . '_' . $user->getId() . '.jpg';
        if (isset($observation['image']) && !empty($observation['image'])) {
            $data = base64_decode($observation['image']);
            file_put_contents('./img/oiseaux/observation/' . $filename, $data);
        } else {
            copy('img/oiseaux/default-image_observation.png', 'img/oiseaux/observation/' . $filename);
        }
        $fch->setImagePath($filename);
        $this->em->persist($fch);
        $this->em->flush();
        return $this->obsArray($fch);
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
                $old_file = $this->bird_directory.'/'. $bird->getImagePath();
                if ($old_file) {
                    unlink($old_file);
                }
            }
            $file = $file_upload['imagepath'];
            if ($file_upload['imagepath'] !== null) {
                $fileName = md5(uniqid()) . '.' . $file->getExtension();
                $file->move($this->bird_directory, $fileName);
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