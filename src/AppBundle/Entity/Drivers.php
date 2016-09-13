<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Drivers
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriversRepository")
 *
 */
class Drivers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string" )
     */
    private $name;

    /**
     * @ORM\Column(type="string" )
     */
    private $surname;

    /**
     * @ORM\Column(type="string" )
     */
    private $middlename;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('0', '1')" )
     */
    private $no_middlename;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string")
     */
    private $doc_serya;

    /**
     * @ORM\Column(type="string")
     */
    private $doc_number;

    /**
     * @ORM\Column(type="date")
     */
    private $doc_date;

    /**
     * @ORM\ManyToOne(targetEntity="Polis", inversedBy="drivers", cascade={"persist"})
     * @ORM\JoinColumn(name="polis_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $polis;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Drivers
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Drivers
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set middlename
     *
     * @param string $middlename
     * @return Drivers
     */
    public function setMiddlename($middlename)
    {
        $this->middlename = $middlename;

        return $this;
    }

    /**
     * Get middlename
     *
     * @return string 
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * Set no_middlename
     *
     * @param string $noMiddlename
     * @return Drivers
     */
    public function setNoMiddlename($noMiddlename)
    {
        $this->no_middlename = $noMiddlename;

        return $this;
    }

    /**
     * Get no_middlename
     *
     * @return string 
     */
    public function getNoMiddlename()
    {
        return $this->no_middlename;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Drivers
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set doc_serya
     *
     * @param string $docSerya
     * @return Drivers
     */
    public function setDocSerya($docSerya)
    {
        $this->doc_serya = $docSerya;

        return $this;
    }

    /**
     * Get doc_serya
     *
     * @return string 
     */
    public function getDocSerya()
    {
        return $this->doc_serya;
    }

    /**
     * Set doc_number
     *
     * @param string $docNumber
     * @return Drivers
     */
    public function setDocNumber($docNumber)
    {
        $this->doc_number = $docNumber;

        return $this;
    }

    /**
     * Get doc_number
     *
     * @return string 
     */
    public function getDocNumber()
    {
        return $this->doc_number;
    }

    /**
     * Set doc_date
     *
     * @param \DateTime $docDate
     * @return Drivers
     */
    public function setDocDate($docDate)
    {
        $this->doc_date = $docDate;

        return $this;
    }

    /**
     * Get doc_date
     *
     * @return \DateTime 
     */
    public function getDocDate()
    {
        return $this->doc_date;
    }

    /**
     * Set polis
     *
     * @param \AppBundle\Entity\Polis $polis
     * @return Drivers
     */
    public function setPolis(\AppBundle\Entity\Polis $polis = null)
    {
        $this->polis = $polis;

        return $this;
    }

    /**
     * Get polis
     *
     * @return \AppBundle\Entity\Polis 
     */
    public function getPolis()
    {
        return $this->polis;
    }
}
