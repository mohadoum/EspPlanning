<?php

namespace ESP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Professor
 *
 * @ORM\Table(name="esp_professor")
 * @ORM\Entity(repositoryClass="ESP\UserBundle\Repository\ProfessorRepository")
 */
class Professor
{
    /**
     * @ORM\OneToOne(targetEntity="ESP\UserBundle\Entity\DepartmentChief", mappedBy="professor")
     */
    protected $departmentChief;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
   

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    protected $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="expired", type="boolean", nullable=true)
     */
    protected $expired;


    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    protected $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="registrationNumber", type="string", length=255, unique=true)
     */
    protected $registrationNumber;

    /**
     * @var string
     * @Gedmo\Slug(fields={"email","registrationNumber"})
     * @ORM\Column(name="confirmation_token", type="string", length=255, nullable=true)
     */
    protected $confirmationToken;

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     *
     * @return Professor
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set registrationNumber
     *
     * @param string $registrationNumber
     *
     * @return Professor
     */
    public function setRegistrationNumber($registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * Get registrationNumber
     *
     * @return string
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Professor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Professor
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Professor
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Professor
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return Professor
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    
    /**
     * Set passwordRequestedAt
     *
     * @param \DateTime $passwordRequestedAt
     *
     * @return Professor
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return \DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return Professor
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Professor
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Professor
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Professor
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     *
     * @return Professor
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getFirstName(). " " . $this->getLastName();
    } 

    public function __construct()
    {
        $this->setExpired(false);
        $this->setEnabled(false);
        $this->setRoles(array('ROLE_PROFESSOR'));
        $this->setPassword('5555');
    }

    

    /**
     * Set departmentChief
     *
     * @param \ESP\UserBundle\Entity\DepartmentChief $departmentChief
     *
     * @return Professor
     */
    public function setDepartmentChief(\ESP\UserBundle\Entity\DepartmentChief $departmentChief = null)
    {
        $this->departmentChief = $departmentChief;

        return $this;
    }

    /**
     * Get departmentChief
     *
     * @return \ESP\UserBundle\Entity\DepartmentChief
     */
    public function getDepartmentChief()
    {
        return $this->departmentChief;
    }
}
