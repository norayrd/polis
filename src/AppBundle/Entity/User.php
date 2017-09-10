<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * Defines the properties of the User entity to represent the application users.
 * See http://symfony.com/doc/current/book/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See http://symfony.com/doc/current/cookbook/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $forgot_password_hash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $forgot_password_expire_datetime;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isDefault = 0;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastAccessedDefault;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="User", cascade={"persist"})
     * @ORM\JoinColumn(name="company", referencedColumnName="company_id")
     */
    private $company;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $polis_limit;

    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles()
    {
        $roles = $this->roles;

        //guarantees that a user always has at least one role for security
        if (count($roles)==0) {
            $roles = array("ROLE_GUEST");
            $roles = array_unique($roles);
        }

        return $roles;
    }

    public function setRoles(array $roles)
    {
        if (count($roles)==0) {
            $this->roles = array("ROLE_GUEST");
        } else {
            $this->roles = $roles;
        }
    }

    /**
     * Returns the salt that was originally used to encode the password.
     */
    public function getSalt()
    {
        // See "Do you need to use a Salt?" at http://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }
    
    public function isPasswordLegal() {
        return ($this->password != $this->firstname);
    } 

    public function isUsernameIsUsed() {
        //return count($user)>0;
    } 

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        //$metadata->addPropertyConstraint('firstname', new NotBlank());
        //$metadata->addPropertyConstraint('lastname',  new NotBlank());
        
        $metadata->addPropertyConstraint('username',  new NotBlank());
        $metadata->addPropertyConstraint('username',  new Length(array( 'min'  => 4, )));
        $metadata->addGetterConstraint('userNameIsUsed', new True(array(
            'message' => 'The Username is used',
        )));

        $metadata->addPropertyConstraint('email',     new Email(array( 'groups' => array('registration') )));
        $metadata->addPropertyConstraint('email',     new NotBlank());

        $metadata->addPropertyConstraint('password',  new NotBlank());
        $metadata->addPropertyConstraint('password', new NotBlank(array(
            'groups' => array('registration')
        )));
        $metadata->addPropertyConstraint('password', new Length(array(
            'min'  => 7,
        )));
        $metadata->addGetterConstraint('passwordLegal', new True(array(
            'message' => 'The password cannot match your First name',
        )));

    }


    /**
     * Set forgotPasswordHash
     *
     * @param string $forgotPasswordHash
     *
     * @return User
     */
    public function setForgotPasswordHash($forgotPasswordHash)
    {
        $this->forgot_password_hash = $forgotPasswordHash;
    
        return $this;
    }

    /**
     * Get forgotPasswordHash
     *
     * @return string
     */
    public function getForgotPasswordHash()
    {
        return $this->forgot_password_hash;
    }

    /**
     * Set forgotPasswordExpireDatetime
     *
     * @param \DateTime $forgotPasswordExpireDatetime
     *
     * @return User
     */
    public function setForgotPasswordExpireDatetime($forgotPasswordExpireDatetime)
    {
        $this->forgot_password_expire_datetime = $forgotPasswordExpireDatetime;
    
        return $this;
    }

    /**
     * Get forgotPasswordExpireDatetime
     *
     * @return \DateTime
     */
    public function getForgotPasswordExpireDatetime()
    {
        return $this->forgot_password_expire_datetime;
    }

    /**
     * Set isDefault
     *
     * @param integer $isDefault
     *
     * @return User
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return integer
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set lastAccessedDefault
     *
     * @param \DateTime $lastAccessedDefault
     *
     * @return User
     */
    public function setLastAccessedDefault($lastAccessedDefault)
    {
        $this->lastAccessedDefault = $lastAccessedDefault;

        return $this;
    }

    /**
     * Get lastAccessedDefault
     *
     * @return \DateTime
     */
    public function getLastAccessedDefault()
    {
        return $this->lastAccessedDefault;
    }

    /**
     * Set patronymic
     *
     * @param string $patronymic
     * @return User
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;
    
        return $this;
    }

    /**
     * Get patronymic
     *
     * @return string 
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set polis_limit
     *
     * @param integer $polisLimit
     * @return User
     */
    public function setPolisLimit($polisLimit)
    {
        $this->polis_limit = $polisLimit;
    
        return $this;
    }

    /**
     * Get polis_limit
     *
     * @return integer 
     */
    public function getPolisLimit()
    {
        return $this->polis_limit;
    }
    
    public function hasRole($role) {
        
        return (count(array_intersect($role, $this->roles)) > 0);
    }


    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     * @return User
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }
}
