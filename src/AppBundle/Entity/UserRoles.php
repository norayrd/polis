<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * UserRoles
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRolesRepository")
 *
 */
class UserRoles
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $role;

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
     * @ORM\Column(type="json_array")
     */
    private $details = array();


    /**
     * Set role
     *
     * @param string $role
     * @return UserRoles
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return UserRoles
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
     * @return UserRoles
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
     * @return UserRoles
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
     * @return UserRoles
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
     * Set details
     *
     * @param array $details
     * @return UserRoles
     */
    public function setDetails($details)
    {
        $this->details = $details;
    
        return $this;
    }

    /**
     * Get details
     *
     * @return array 
     */
    public function getDetails()
    {
        return $this->details;
    }
}
