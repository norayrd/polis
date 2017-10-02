<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * UserSign
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserSignRepository")
 *
 */
class UserSign
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $user_sign_id;

    /**
     * @ORM\Column(type="string" )
     */
    private $name;

    /**
     * @ORM\Column(type="string" )
     */
    private $short_name;

    /**
     * @ORM\Column(type="string" )
     */
    private $icon;

    /**
     * @ORM\Column(type="string" )
     */
    private $color;

    /**
     * @ORM\Column(type="string" )
     */
    private $btn_name;

    /**
     * Get user_sign_id
     *
     * @return integer 
     */
    public function getUserSignId()
    {
        return $this->user_sign_id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return UserSign
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
     * Set short_name
     *
     * @param string $shortName
     * @return UserSign
     */
    public function setShortName($shortName)
    {
        $this->short_name = $shortName;
    
        return $this;
    }

    /**
     * Get short_name
     *
     * @return string 
     */
    public function getShortName()
    {
        return $this->short_name;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return UserSign
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    
        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return UserSign
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set btn_name
     *
     * @param string $btnName
     * @return UserSign
     */
    public function setBtnName($btnName)
    {
        $this->btn_name = $btnName;
    
        return $this;
    }

    /**
     * Get btn_name
     *
     * @return string 
     */
    public function getBtnName()
    {
        return $this->btn_name;
    }
}
