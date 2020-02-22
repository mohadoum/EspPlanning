<?php

namespace ESP\SchoolStructureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DepartmentOption
 *
 * @ORM\Table(name="esp_department_option", uniqueConstraints={@ORM\UniqueConstraint(name="uniqueCombinationOptionDepartment", columns={"name", "department"})})
 * @ORM\Entity(repositoryClass="ESP\SchoolStructureBundle\Repository\DepartmentOptionRepository")
 */
class DepartmentOption
{
    

    /**
     * @ORM\OneToMany(targetEntity="ESP\SchoolStructureBundle\Entity\Cycle", cascade={"persist"}, mappedBy="departmentOption")
     */
    private $cycles;

    /**
     * @ORM\ManyToOne(targetEntity="ESP\SchoolStructureBundle\Entity\Department", inversedBy="departmentOptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;


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
     * @ORM\Column(name="name", type="string", length=255)
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
     * @return DepartmentOption
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
     * @return DepartmentOption
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
     * Set department
     *
     * @param \ESP\SchoolStructureBundle\Entity\Department $department
     *
     * @return DepartmentOption
     */
    public function setDepartment(\ESP\SchoolStructureBundle\Entity\Department $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \ESP\SchoolStructureBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cycles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cycle
     *
     * @param \ESP\SchoolStructureBundle\Entity\Cycle $cycle
     *
     * @return DepartmentOption
     */
    public function addCycle(\ESP\SchoolStructureBundle\Entity\Cycle $cycle)
    {
        $this->cycles[] = $cycle;

        return $this;
    }

    /**
     * Remove cycle
     *
     * @param \ESP\SchoolStructureBundle\Entity\Cycle $cycle
     */
    public function removeCycle(\ESP\SchoolStructureBundle\Entity\Cycle $cycle)
    {
        $this->cycles->removeElement($cycle);
    }

    /**
     * Get cycles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCycles()
    {
        return $this->cycles;
    }
}
