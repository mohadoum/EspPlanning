<?php

namespace ESP\SchoolStructureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Department
 *
 * @ORM\Table(name="esp_department")
 * @ORM\Entity(repositoryClass="ESP\SchoolStructureBundle\Repository\DepartmentRepository")
 */
class Department
{
   

    
    /**
     * @ORM\OneToMany(targetEntity="ESP\SchoolStructureBundle\Entity\Cycle", cascade={"persist"}, mappedBy="department")
     */
    private $cycles;

    /**
     * @ORM\OneToMany(targetEntity="ESP\SchoolStructureBundle\Entity\DepartmentOption", cascade={"persist"}, mappedBy="department")
     */
    private $departmentOptions;

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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


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
     * Set name
     *
     * @param string $name
     *
     * @return Department
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
     * Set description
     *
     * @param string $description
     *
     * @return Department
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param DepartmentOption $departmentOption
     */
    public function addDepartmentOption(DepartmentOption $departmentOption)
    {
        $this->departmentOptions[] = $departmentOption;

        // On lie l'option du departement au departement
        $departmentOption->setDepartment($this);
    }

    /**
     * @param DepartmentOption $departmentOption
     */
    public function removeDepartmentOption(DepartmentOption $departmentOption)
    {
        $this->departmentOptions->removeElement($departmentOption);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartmentOptions()
    {
        return $this->departmentOptions;
    }

    /**
     * @param Cycle $cycle
     */
    public function addCycle(Cycle $cycle)
    {
        $this->cycles[] = $cycle;

        // On lie departement au cycle
        $cycle->setDepartment($this);
    }

    /**
     * @param Cycle $cycle
     */
    public function removeCycle(Cycle $cycle)
    {
        $this->cycles->removeElement($cycle);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCycles()
    {
        return $this->cycles;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->departmentOptions = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
