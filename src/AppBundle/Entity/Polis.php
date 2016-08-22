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
}
