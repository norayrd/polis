<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Polis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PolisRepository")
 *
 */
class Polis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $tr_make;

    /**
     * @ORM\Column(type="string")
     */
    private $tr_model;

    /**
     * @ORM\Column(type="integer")
     */
    private $tr_true_year;

    /**
     * @ORM\Column(type="integer")
     */
    private $tr_year;

    /**
     * @ORM\Column(type="integer")
     */
    private $tr_power;

    /**
     * @ORM\Column(type="integer")
     */
    private $tr_ts;

    /**
     * @ORM\Column(type="string")
     */
    private $tr_doc_serya;

    /**
     * @ORM\Column(type="string")
     */
    private $tr_doc_number;

    /**
     * @ORM\Column(type="date")
     */
    private $tr_doc_date;

    /**
     * @ORM\Column(type="date")
     */
    private $tr_doc_true_date;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('N/A', 'Vin', 'Body', 'Chassis')")
     */
    private $tr_vin_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $tr_vin_number;

    /**
     * @ORM\Column(type="string" )
     */
    private $tr_car_number;

    /**
     * @ORM\Column(type="string" )
     */
    private $owner_name;

    /**
     * @ORM\Column(type="string" )
     */
    private $owner_surname;

    /**
     * @ORM\Column(type="string" )
     */
    private $owner_middlename;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('0', '1')" )
     */
    private $owner_no_middlename;

    /**
     * @ORM\Column(type="date")
     */
    private $owner_true_birthday;

    /**
     * @ORM\Column(type="date")
     */
    private $owner_birthday;

    /**
     * @ORM\Column(type="string")
     */
    private $owner_pasp_serya;

    /**
     * @ORM\Column(type="string")
     */
    private $owner_pasp_number;

    /**
     * @ORM\Column(type="date")
     */
    private $owner_pasp_date;

    /**
     * @ORM\Column(type="date")
     */
    private $owner_pasp_true_date;

    /**
     * @ORM\Column(type="string")
     */
    private $reg_city;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('Край', 'Область', 'Район' )", nullable=true )
     */
    private $reg_state_type;

    /**
     * @ORM\Column(type="string")
     */
    private $reg_state;

    /**
     * @ORM\Column(type="string")
     */
    private $reg_street;

    /**
     * @ORM\Column(type="string")
     */
    private $reg_nhome;

    /**
     * @ORM\Column(type="string")
     */
    private $reg_nflat;

    /**
     * @ORM\Column(type="float")
     */
    private $reg_territory_ratio;

    /**
     * @ORM\Column(type="date")
     */
    private $polis_start_date;

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
     * Set tr_make
     *
     * @param string $trMake
     * @return Polis
     */
    public function setTrMake($trMake)
    {
        $this->tr_make = $trMake;

        return $this;
    }

    /**
     * Get tr_make
     *
     * @return string 
     */
    public function getTrMake()
    {
        return $this->tr_make;
    }

    /**
     * Set tr_model
     *
     * @param string $trModel
     * @return Polis
     */
    public function setTrModel($trModel)
    {
        $this->tr_model = $trModel;

        return $this;
    }

    /**
     * Get tr_model
     *
     * @return string 
     */
    public function getTrModel()
    {
        return $this->tr_model;
    }

    /**
     * Set tr_true_year
     *
     * @param integer $trTrueYear
     * @return Polis
     */
    public function setTrTrueYear($trTrueYear)
    {
        $this->tr_true_year = $trTrueYear;

        return $this;
    }

    /**
     * Get tr_true_year
     *
     * @return integer 
     */
    public function getTrTrueYear()
    {
        return $this->tr_true_year;
    }

    /**
     * Set tr_year
     *
     * @param integer $trYear
     * @return Polis
     */
    public function setTrYear($trYear)
    {
        $this->tr_year = $trYear;

        return $this;
    }

    /**
     * Get tr_year
     *
     * @return integer 
     */
    public function getTrYear()
    {
        return $this->tr_year;
    }

    /**
     * Set tr_power
     *
     * @param integer $trPower
     * @return Polis
     */
    public function setTrPower($trPower)
    {
        $this->tr_power = $trPower;

        return $this;
    }

    /**
     * Get tr_power
     *
     * @return integer 
     */
    public function getTrPower()
    {
        return $this->tr_power;
    }

    /**
     * Set tr_ts
     *
     * @param integer $trTs
     * @return Polis
     */
    public function setTrTs($trTs)
    {
        $this->tr_ts = $trTs;

        return $this;
    }

    /**
     * Get tr_ts
     *
     * @return integer 
     */
    public function getTrTs()
    {
        return $this->tr_ts;
    }

    /**
     * Set tr_doc_serya
     *
     * @param string $trDocSerya
     * @return Polis
     */
    public function setTrDocSerya($trDocSerya)
    {
        $this->tr_doc_serya = $trDocSerya;

        return $this;
    }

    /**
     * Get tr_doc_serya
     *
     * @return string 
     */
    public function getTrDocSerya()
    {
        return $this->tr_doc_serya;
    }

    /**
     * Set tr_doc_number
     *
     * @param string $trDocNumber
     * @return Polis
     */
    public function setTrDocNumber($trDocNumber)
    {
        $this->tr_doc_number = $trDocNumber;

        return $this;
    }

    /**
     * Get tr_doc_number
     *
     * @return string 
     */
    public function getTrDocNumber()
    {
        return $this->tr_doc_number;
    }

    /**
     * Set tr_doc_date
     *
     * @param \DateTime $trDocDate
     * @return Polis
     */
    public function setTrDocDate($trDocDate)
    {
        $this->tr_doc_date = $trDocDate;

        return $this;
    }

    /**
     * Get tr_doc_date
     *
     * @return \DateTime 
     */
    public function getTrDocDate()
    {
        return $this->tr_doc_date;
    }

    /**
     * Set tr_doc_true_date
     *
     * @param \DateTime $trDocTrueDate
     * @return Polis
     */
    public function setTrDocTrueDate($trDocTrueDate)
    {
        $this->tr_doc_true_date = $trDocTrueDate;

        return $this;
    }

    /**
     * Get tr_doc_true_date
     *
     * @return \DateTime 
     */
    public function getTrDocTrueDate()
    {
        return $this->tr_doc_true_date;
    }

    /**
     * Set tr_vin_type
     *
     * @param string $trVinType
     * @return Polis
     */
    public function setTrVinType($trVinType)
    {
        $this->tr_vin_type = $trVinType;

        return $this;
    }

    /**
     * Get tr_vin_type
     *
     * @return string 
     */
    public function getTrVinType()
    {
        return $this->tr_vin_type;
    }

    /**
     * Set tr_vin_number
     *
     * @param integer $trVinNumber
     * @return Polis
     */
    public function setTrVinNumber($trVinNumber)
    {
        $this->tr_vin_number = $trVinNumber;

        return $this;
    }

    /**
     * Get tr_vin_number
     *
     * @return integer 
     */
    public function getTrVinNumber()
    {
        return $this->tr_vin_number;
    }

    /**
     * Set tr_car_number
     *
     * @param string $trCarNumber
     * @return Polis
     */
    public function setTrCarNumber($trCarNumber)
    {
        $this->tr_car_number = $trCarNumber;

        return $this;
    }

    /**
     * Get tr_car_number
     *
     * @return string 
     */
    public function getTrCarNumber()
    {
        return $this->tr_car_number;
    }

    /**
     * Set owner_name
     *
     * @param string $ownerName
     * @return Polis
     */
    public function setOwnerName($ownerName)
    {
        $this->owner_name = $ownerName;

        return $this;
    }

    /**
     * Get owner_name
     *
     * @return string 
     */
    public function getOwnerName()
    {
        return $this->owner_name;
    }

    /**
     * Set owner_surname
     *
     * @param string $ownerSurname
     * @return Polis
     */
    public function setOwnerSurname($ownerSurname)
    {
        $this->owner_surname = $ownerSurname;

        return $this;
    }

    /**
     * Get owner_surname
     *
     * @return string 
     */
    public function getOwnerSurname()
    {
        return $this->owner_surname;
    }

    /**
     * Set owner_middlename
     *
     * @param string $ownerMiddlename
     * @return Polis
     */
    public function setOwnerMiddlename($ownerMiddlename)
    {
        $this->owner_middlename = $ownerMiddlename;

        return $this;
    }

    /**
     * Get owner_middlename
     *
     * @return string 
     */
    public function getOwnerMiddlename()
    {
        return $this->owner_middlename;
    }

    /**
     * Set owner_no_middlename
     *
     * @param string $ownerNoMiddlename
     * @return Polis
     */
    public function setOwnerNoMiddlename($ownerNoMiddlename)
    {
        $this->owner_no_middlename = $ownerNoMiddlename;

        return $this;
    }

    /**
     * Get owner_no_middlename
     *
     * @return string 
     */
    public function getOwnerNoMiddlename()
    {
        return $this->owner_no_middlename;
    }

    /**
     * Set owner_true_birthday
     *
     * @param \DateTime $ownerTrueBirthday
     * @return Polis
     */
    public function setOwnerTrueBirthday($ownerTrueBirthday)
    {
        $this->owner_true_birthday = $ownerTrueBirthday;

        return $this;
    }

    /**
     * Get owner_true_birthday
     *
     * @return \DateTime 
     */
    public function getOwnerTrueBirthday()
    {
        return $this->owner_true_birthday;
    }

    /**
     * Set owner_birthday
     *
     * @param \DateTime $ownerBirthday
     * @return Polis
     */
    public function setOwnerBirthday($ownerBirthday)
    {
        $this->owner_birthday = $ownerBirthday;

        return $this;
    }

    /**
     * Get owner_birthday
     *
     * @return \DateTime 
     */
    public function getOwnerBirthday()
    {
        return $this->owner_birthday;
    }

    /**
     * Set owner_pasp_serya
     *
     * @param string $ownerPaspSerya
     * @return Polis
     */
    public function setOwnerPaspSerya($ownerPaspSerya)
    {
        $this->owner_pasp_serya = $ownerPaspSerya;

        return $this;
    }

    /**
     * Get owner_pasp_serya
     *
     * @return string 
     */
    public function getOwnerPaspSerya()
    {
        return $this->owner_pasp_serya;
    }

    /**
     * Set owner_pasp_number
     *
     * @param string $ownerPaspNumber
     * @return Polis
     */
    public function setOwnerPaspNumber($ownerPaspNumber)
    {
        $this->owner_pasp_number = $ownerPaspNumber;

        return $this;
    }

    /**
     * Get owner_pasp_number
     *
     * @return string 
     */
    public function getOwnerPaspNumber()
    {
        return $this->owner_pasp_number;
    }

    /**
     * Set owner_pasp_date
     *
     * @param \DateTime $ownerPaspDate
     * @return Polis
     */
    public function setOwnerPaspDate($ownerPaspDate)
    {
        $this->owner_pasp_date = $ownerPaspDate;

        return $this;
    }

    /**
     * Get owner_pasp_date
     *
     * @return \DateTime 
     */
    public function getOwnerPaspDate()
    {
        return $this->owner_pasp_date;
    }

    /**
     * Set owner_pasp_true_date
     *
     * @param \DateTime $ownerPaspTrueDate
     * @return Polis
     */
    public function setOwnerPaspTrueDate($ownerPaspTrueDate)
    {
        $this->owner_pasp_true_date = $ownerPaspTrueDate;

        return $this;
    }

    /**
     * Get owner_pasp_true_date
     *
     * @return \DateTime 
     */
    public function getOwnerPaspTrueDate()
    {
        return $this->owner_pasp_true_date;
    }

    /**
     * Set reg_city
     *
     * @param string $regCity
     * @return Polis
     */
    public function setRegCity($regCity)
    {
        $this->reg_city = $regCity;

        return $this;
    }

    /**
     * Get reg_city
     *
     * @return string 
     */
    public function getRegCity()
    {
        return $this->reg_city;
    }

    /**
     * Set reg_state_type
     *
     * @param string $regStateType
     * @return Polis
     */
    public function setRegStateType($regStateType)
    {
        $this->reg_state_type = $regStateType;

        return $this;
    }

    /**
     * Get reg_state_type
     *
     * @return string 
     */
    public function getRegStateType()
    {
        return $this->reg_state_type;
    }

    /**
     * Set reg_state
     *
     * @param string $regState
     * @return Polis
     */
    public function setRegState($regState)
    {
        $this->reg_state = $regState;

        return $this;
    }

    /**
     * Get reg_state
     *
     * @return string 
     */
    public function getRegState()
    {
        return $this->reg_state;
    }

    /**
     * Set reg_street
     *
     * @param string $regStreet
     * @return Polis
     */
    public function setRegStreet($regStreet)
    {
        $this->reg_street = $regStreet;

        return $this;
    }

    /**
     * Get reg_street
     *
     * @return string 
     */
    public function getRegStreet()
    {
        return $this->reg_street;
    }

    /**
     * Set reg_nhome
     *
     * @param string $regNhome
     * @return Polis
     */
    public function setRegNhome($regNhome)
    {
        $this->reg_nhome = $regNhome;

        return $this;
    }

    /**
     * Get reg_nhome
     *
     * @return string 
     */
    public function getRegNhome()
    {
        return $this->reg_nhome;
    }

    /**
     * Set reg_nflat
     *
     * @param string $regNflat
     * @return Polis
     */
    public function setRegNflat($regNflat)
    {
        $this->reg_nflat = $regNflat;

        return $this;
    }

    /**
     * Get reg_nflat
     *
     * @return string 
     */
    public function getRegNflat()
    {
        return $this->reg_nflat;
    }

    /**
     * Set reg_territory_ratio
     *
     * @param float $regTerritoryRatio
     * @return Polis
     */
    public function setRegTerritoryRatio($regTerritoryRatio)
    {
        $this->reg_territory_ratio = $regTerritoryRatio;

        return $this;
    }

    /**
     * Get reg_territory_ratio
     *
     * @return float 
     */
    public function getRegTerritoryRatio()
    {
        return $this->reg_territory_ratio;
    }

    /**
     * Set polis_start_date
     *
     * @param \DateTime $polisStartDate
     * @return Polis
     */
    public function setPolisStartDate($polisStartDate)
    {
        $this->polis_start_date = $polisStartDate;

        return $this;
    }

    /**
     * Get polis_start_date
     *
     * @return \DateTime 
     */
    public function getPolisStartDate()
    {
        return $this->polis_start_date;
    }
}
