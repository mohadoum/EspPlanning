<?php

namespace ESP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Administrator
 *
 * @ORM\Table(name="esp_administrator")
 * @ORM\Entity(repositoryClass="ESP\UserBundle\Repository\AdministratorRepository")
 */
class Administrator extends \ESP\UserBundle\Entity\User
{

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
     * @return Users
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
     * @return Administrator
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

}
