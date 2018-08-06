<?php

namespace NAO\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxref
 *
 * @ORM\Table(name="taxref")
 * @ORM\Entity(repositoryClass="NAO\MapBundle\Repository\TaxrefRepository")
 */
class Taxref
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="regnum", type="string", length=20)
     */
    private $regnum;
    /**
     * @var string
     *
     * @ORM\Column(name="phylum", type="string", length=20)
     *
     */
    private $phylum;
    /**
     * @var string
     *
     * @ORM\Column(name="classis", type="string", length=20)
     */
    private $classis;
    /**
     * @var string
     *
     * @ORM\Column(name="ordo", type="string", length=100)
     */
    private $ordo;
    /**
     * @var string
     *
     * @ORM\Column(name="familia", type="string", length=100)
     */
    private $familia;
    /**
     * @var integer
     *
     * @ORM\Column(name="scientific_id", type="integer")
     */
    private $scientific_id;
    /**
     * @var integer
     *
     * @ORM\Column(name="taxon_id", type="integer")
     */
    private $taxon_id;
    /**
     * @var string
     *
     * @ORM\Column(name="taxon_ref_id", type="integer")
     */
    private $taxon_ref_id;
    /**
     * @var string
     *
     * @ORM\Column(name="taxon_rank", type="string", length=5)
     */
    private $taxon_rank;
    /**
     * @var string
     *
     * @ORM\Column(name="taxon_sc", type="string")
     */
    private $taxon_sc;
    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string")
     */
    private $author;
    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string")
     */
    private $fullname;
    /**
     * @var string
     *
     * @ORM\Column(name="valid_name", type="string")
     */
    private $valid_name;
    /**
     * @var string
     *
     * @ORM\Column(name="common_name", type="string")
     */
    private $common_name;
    /**
     * @var string
     *
     * @ORM\Column(name="common_name_en", type="string")
     */
    private $common_name_en;
    /**
     * @var smallint
     *
     * @ORM\Column(name="habitat", type="smallint")
     */
    private $habitat;
    /**
     * @var smallint
     *
     * @ORM\Column(name="france", type="string", nullable=true)
     */
    private $france;
    /**
     * @var smallint
     *
     * @ORM\Column(name="guyane_francaise", type="string", nullable=true)
     */
    private $guyane_francaise;
    /**
     * @var smallint
     *
     * @ORM\Column(name="martique", type="string", nullable=true)
     */
    private $martique;
    /**
     * @var smallint
     *
     * @ORM\Column(name="guadeloupe", type="string", nullable=true)
     */
    private $guadeloupe;
    /**
     * @var smallint
     *
     * @ORM\Column(name="saint_martin", type="string", nullable=true)
     */
    private $saint_martin;
    /**
     * @var smallint
     *
     * @ORM\Column(name="saint_barthelemy", type="string", nullable=true)
     */
    private $saint_barthelemy;
    /**
     * @var smallint
     *
     * @ORM\Column(name="saint_pierre_et_miquelon", type="string", nullable=true)
     */
    private $saint_pierre_et_miquelon;
    /**
     * @var smallint
     *
     * @ORM\Column(name="mayotte", type="string", nullable=true)
     */
    private $mayotte;
    /**
     * @var smallint
     *
     * @ORM\Column(name="iles_eparses", type="string", nullable=true)
     */
    private $iles_eparses;
    /**
     * @var smallint
     *
     * @ORM\Column(name="reunion", type="string", nullable=true)
     */
    private $reunion;
    /**
     * @var smallint
     *
     * @ORM\Column(name="saint_paul", type="string", nullable=true)
     */
    private $saint_paul;
    /**
     * @var smallint
     *
     * @ORM\Column(name="terre_adelie", type="string", nullable=true)
     */
    private $terre_adelie;
    /**
     * @var smallint
     *
     * @ORM\Column(name="iles_sub_antartique", type="string", nullable=true)
     */
    private $iles_sub_antartique;
    /**
     * @var smallint
     *
     * @ORM\Column(name="nouvelle_caledonie", type="string", nullable=true)
     */
    private $nouvelle_caledonie;
    /**
     * @var smallint
     *
     * @ORM\Column(name="wallis_et_futuna", type="string", nullable=true)
     */
    private $wallis_et_futuna;
    /**
     * @var smallint
     *
     * @ORM\Column(name="polynesie_francaise", type="string", nullable=true)
     */
    private $polynesie_francaise;
    /**
     * @var smallint
     *
     * @ORM\Column(name="clipperton", type="string", nullable=true)
     */
    private $clipperton;
    /**
     * Set regnum
     *
     * @param string $regnum
     *
     * @return Taxref
     */
    public function setRegnum($regnum)
    {
        $this->regnum = $regnum;
        return $this;
    }
    /**
     * Get regnum
     *
     * @return string
     */
    public function getRegnum()
    {
        return $this->regnum;
    }
    /**
     * Set phylum
     *
     * @param string $phylum
     *
     * @return Taxref
     */
    public function setPhylum($phylum)
    {
        $this->phylum = $phylum;
        return $this;
    }
    /**
     * Get phylum
     *
     * @return string
     */
    public function getPhylum()
    {
        return $this->phylum;
    }
    /**
     * Set classis
     *
     * @param string $classis
     *
     * @return Taxref
     */
    public function setClassis($classis)
    {
        $this->classis = $classis;
        return $this;
    }
    /**
     * Get classis
     *
     * @return string
     */
    public function getClassis()
    {
        return $this->classis;
    }
    /**
     * Set ordo
     *
     * @param string $ordo
     *
     * @return Taxref
     */
    public function setOrdo($ordo)
    {
        $this->ordo = $ordo;
        return $this;
    }
    /**
     * Get ordo
     *
     * @return string
     */
    public function getOrdo()
    {
        return $this->ordo;
    }
    /**
     * Set familia
     *
     * @param string $familia
     *
     * @return Taxref
     */
    public function setFamilia($familia)
    {
        $this->familia = $familia;
        return $this;
    }
    /**
     * Get familia
     *
     * @return string
     */
    public function getFamilia()
    {
        return $this->familia;
    }
    /**
     * Set scientificId
     *
     * @param integer $scientificId
     *
     * @return Taxref
     */
    public function setScientificId($scientificId)
    {
        $this->scientific_id = $scientificId;
        return $this;
    }
    /**
     * Get scientificId
     *
     * @return integer
     */
    public function getScientificId()
    {
        return $this->scientific_id;
    }
    /**
     * Set taxonId
     *
     * @param integer $taxonId
     *
     * @return Taxref
     */
    public function setTaxonId($taxonId)
    {
        $this->taxon_id = $taxonId;
        return $this;
    }
    /**
     * Get taxonId
     *
     * @return integer
     */
    public function getTaxonId()
    {
        return $this->taxon_id;
    }
    /**
     * Set taxonRefId
     *
     * @param integer $taxonRefId
     *
     * @return Taxref
     */
    public function setTaxonRefId($taxonRefId)
    {
        $this->taxon_ref_id = $taxonRefId;
        return $this;
    }
    /**
     * Get taxonRefId
     *
     * @return integer
     */
    public function getTaxonRefId()
    {
        return $this->taxon_ref_id;
    }
    /**
     * Set taxonRank
     *
     * @param string $taxonRank
     *
     * @return Taxref
     */
    public function setTaxonRank($taxonRank)
    {
        $this->taxon_rank = $taxonRank;
        return $this;
    }
    /**
     * Get taxonRank
     *
     * @return string
     */
    public function getTaxonRank()
    {
        return $this->taxon_rank;
    }
    /**
     * Set taxonSc
     *
     * @param string $taxonSc
     *
     * @return Taxref
     */
    public function setTaxonSc($taxonSc)
    {
        $this->taxon_sc = $taxonSc;
        return $this;
    }
    /**
     * Get taxonSc
     *
     * @return string
     */
    public function getTaxonSc()
    {
        return $this->taxon_sc;
    }
    /**
     * Set custom name
     *
     * @return string
     */
    public function setCustomName($customName){
        $this->custom_name = $customName;
        return $this;
    }
    /**
     * Get custom name
     *
     * @return string
     */
    public function getCustomName(){
        return $this->getCommonName() . '('.$this->getTaxonSc().')';
    }
    /**
     * Set author
     *
     * @param string $author
     *
     * @return Taxref
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }
    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Taxref
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }
    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }
    /**
     * Set validName
     *
     * @param string $validName
     *
     * @return Taxref
     */
    public function setValidName($validName)
    {
        $this->valid_name = $validName;
        return $this;
    }
    /**
     * Get validName
     *
     * @return string
     */
    public function getValidName()
    {
        return $this->valid_name;
    }
    /**
     * Set commonName
     *
     * @param string $commonName
     *
     * @return Taxref
     */
    public function setCommonName($commonName)
    {
        $this->common_name = $commonName;
        return $this;
    }
    /**
     * Get commonName
     *
     * @return string
     */
    public function getCommonName()
    {
        return $this->common_name;
    }
    /**
     * Set commonNameEn
     *
     * @param string $commonNameEn
     *
     * @return Taxref
     */
    public function setCommonNameEn($commonNameEn)
    {
        $this->common_name_en = $commonNameEn;
        return $this;
    }
    /**
     * Get commonNameEn
     *
     * @return string
     */
    public function getCommonNameEn()
    {
        return $this->common_name_en;
    }
    /**
     * Set habitat
     *
     * @param integer $habitat
     *
     * @return Taxref
     */
    public function setHabitat($habitat)
    {
        $this->habitat = $habitat;
        return $this;
    }
    /**
     * Get habitat
     *
     * @return integer
     */
    public function getHabitat()
    {
        return $this->habitat;
    }
    /**
     * Set france
     *
     * @param string $france
     *
     * @return Taxref
     */
    public function setFrance($france)
    {
        $this->france = $france;
        return $this;
    }
    /**
     * Get france
     *
     * @return string
     */
    public function getFrance()
    {
        return $this->france;
    }
    /**
     * Set guyaneFrancaise
     *
     * @param string $guyaneFrancaise
     *
     * @return Taxref
     */
    public function setGuyaneFrancaise($guyaneFrancaise)
    {
        $this->guyane_francaise = $guyaneFrancaise;
        return $this;
    }
    /**
     * Get guyaneFrancaise
     *
     * @return string
     */
    public function getGuyaneFrancaise()
    {
        return $this->guyane_francaise;
    }
    /**
     * Set martique
     *
     * @param string $martique
     *
     * @return Taxref
     */
    public function setMartique($martique)
    {
        $this->martique = $martique;
        return $this;
    }
    /**
     * Get martique
     *
     * @return string
     */
    public function getMartique()
    {
        return $this->martique;
    }
    /**
     * Set guadeloupe
     *
     * @param string $guadeloupe
     *
     * @return Taxref
     */
    public function setGuadeloupe($guadeloupe)
    {
        $this->guadeloupe = $guadeloupe;
        return $this;
    }
    /**
     * Get guadeloupe
     *
     * @return string
     */
    public function getGuadeloupe()
    {
        return $this->guadeloupe;
    }
    /**
     * Set saintMartin
     *
     * @param string $saintMartin
     *
     * @return Taxref
     */
    public function setSaintMartin($saintMartin)
    {
        $this->saint_martin = $saintMartin;
        return $this;
    }
    /**
     * Get saintMartin
     *
     * @return string
     */
    public function getSaintMartin()
    {
        return $this->saint_martin;
    }
    /**
     * Set saintBarthelemy
     *
     * @param string $saintBarthelemy
     *
     * @return Taxref
     */
    public function setSaintBarthelemy($saintBarthelemy)
    {
        $this->saint_barthelemy = $saintBarthelemy;
        return $this;
    }
    /**
     * Get saintBarthelemy
     *
     * @return string
     */
    public function getSaintBarthelemy()
    {
        return $this->saint_barthelemy;
    }
    /**
     * Set saintPierreEtMiquelon
     *
     * @param string $saintPierreEtMiquelon
     *
     * @return Taxref
     */
    public function setSaintPierreEtMiquelon($saintPierreEtMiquelon)
    {
        $this->saint_pierre_et_miquelon = $saintPierreEtMiquelon;
        return $this;
    }
    /**
     * Get saintPierreEtMiquelon
     *
     * @return string
     */
    public function getSaintPierreEtMiquelon()
    {
        return $this->saint_pierre_et_miquelon;
    }
    /**
     * Set mayotte
     *
     * @param string $mayotte
     *
     * @return Taxref
     */
    public function setMayotte($mayotte)
    {
        $this->mayotte = $mayotte;
        return $this;
    }
    /**
     * Get mayotte
     *
     * @return string
     */
    public function getMayotte()
    {
        return $this->mayotte;
    }
    /**
     * Set ilesEparses
     *
     * @param string $ilesEparses
     *
     * @return Taxref
     */
    public function setIlesEparses($ilesEparses)
    {
        $this->iles_eparses = $ilesEparses;
        return $this;
    }
    /**
     * Get ilesEparses
     *
     * @return string
     */
    public function getIlesEparses()
    {
        return $this->iles_eparses;
    }
    /**
     * Set reunion
     *
     * @param string $reunion
     *
     * @return Taxref
     */
    public function setReunion($reunion)
    {
        $this->reunion = $reunion;
        return $this;
    }
    /**
     * Get reunion
     *
     * @return string
     */
    public function getReunion()
    {
        return $this->reunion;
    }
    /**
     * Set saintPaul
     *
     * @param string $saintPaul
     *
     * @return Taxref
     */
    public function setSaintPaul($saintPaul)
    {
        $this->saint_paul = $saintPaul;
        return $this;
    }
    /**
     * Get saintPaul
     *
     * @return string
     */
    public function getSaintPaul()
    {
        return $this->saint_paul;
    }
    /**
     * Set terreAdelie
     *
     * @param string $terreAdelie
     *
     * @return Taxref
     */
    public function setTerreAdelie($terreAdelie)
    {
        $this->terre_adelie = $terreAdelie;
        return $this;
    }
    /**
     * Get terreAdelie
     *
     * @return string
     */
    public function getTerreAdelie()
    {
        return $this->terre_adelie;
    }
    /**
     * Set ilesSubAntartique
     *
     * @param string $ilesSubAntartique
     *
     * @return Taxref
     */
    public function setIlesSubAntartique($ilesSubAntartique)
    {
        $this->iles_sub_antartique = $ilesSubAntartique;
        return $this;
    }
    /**
     * Get ilesSubAntartique
     *
     * @return string
     */
    public function getIlesSubAntartique()
    {
        return $this->iles_sub_antartique;
    }
    /**
     * Set nouvelleCaledonie
     *
     * @param string $nouvelleCaledonie
     *
     * @return Taxref
     */
    public function setNouvelleCaledonie($nouvelleCaledonie)
    {
        $this->nouvelle_caledonie = $nouvelleCaledonie;
        return $this;
    }
    /**
     * Get nouvelleCaledonie
     *
     * @return string
     */
    public function getNouvelleCaledonie()
    {
        return $this->nouvelle_caledonie;
    }
    /**
     * Set wallisEtFutuna
     *
     * @param string $wallisEtFutuna
     *
     * @return Taxref
     */
    public function setWallisEtFutuna($wallisEtFutuna)
    {
        $this->wallis_et_futuna = $wallisEtFutuna;
        return $this;
    }
    /**
     * Get wallisEtFutuna
     *
     * @return string
     */
    public function getWallisEtFutuna()
    {
        return $this->wallis_et_futuna;
    }
    /**
     * Set polynesieFrancaise
     *
     * @param string $polynesieFrancaise
     *
     * @return Taxref
     */
    public function setPolynesieFrancaise($polynesieFrancaise)
    {
        $this->polynesie_francaise = $polynesieFrancaise;
        return $this;
    }
    /**
     * Get polynesieFrancaise
     *
     * @return string
     */
    public function getPolynesieFrancaise()
    {
        return $this->polynesie_francaise;
    }
    /**
     * Set clipperton
     *
     * @param string $clipperton
     *
     * @return Taxref
     */
    public function setClipperton($clipperton)
    {
        $this->clipperton = $clipperton;
        return $this;
    }
    /**
     * Get clipperton
     *
     * @return string
     */
    public function getClipperton()
    {
        return $this->clipperton;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

