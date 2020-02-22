<?php

namespace ESP\SchoolStructureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cycle
 *
 * @ORM\Table(name="esp_cycle", uniqueConstraints={@ORM\UniqueConstraint(name="uniqueCombinationCycleDepartmentOption", columns={"name", "department", "departmentOption"})})
 * @ORM\Entity(repositoryClass="ESP\SchoolStructureBundle\Repository\CycleRepository")
 */
class Cycle
{


    /**
     * @ORM\OneToMany(targetEntity="ESP\SchoolStructureBundle\Entity\Level", cascade={"persist"}, mappedBy="cycle")
     */
    private $levels;


    /**
     * @ORM\ManyToOne(targetEntity="ESP\SchoolStructureBundle\Entity\DepartmentOption", inversedBy="cycles")
     */
    private $departmentOption;

    /**
     * @ORM\ManyToOne(targetEntity="ESP\SchoolStructureBundle\Entity\Department", inversedBy="cycles")
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
     * @return Cycle
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
     * @return Cycle
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
     * Constructor
     */
    public function __construct()
    {
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add level
     *
     * @param \ESP\SchoolStructureBundle\Entity\Level $level
     *
     * @return Cycle
     */
    public function addLevel(\ESP\SchoolStructureBundle\Entity\Level $level)
    {
        $this->levels[] = $level;

        $level->setCycle($this);

        return $this;
    }

    /**
     * Remove level
     *
     * @param \ESP\SchoolStructureBundle\Entity\Level $level
     */
    public function removeLevel(\ESP\SchoolStructureBundle\Entity\Level $level)
    {
        $this->levels->removeElement($level);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set departmentOption
     *
     * @param \ESP\SchoolStructureBundle\Entity\DepartmentOption $departmentOption
     *
     * @return Cycle
     */
    public function setDepartmentOption(\ESP\SchoolStructureBundle\Entity\DepartmentOption $departmentOption = null)
    {
        $this->departmentOption = $departmentOption;

        return $this;
    }

    /**
     * Get departmentOption
     *
     * @return \ESP\SchoolStructureBundle\Entity\DepartmentOption
     */
    public function getDepartmentOption()
    {
        return $this->departmentOption;
    }

    /**
     * Set department
     *
     * @param \ESP\SchoolStructureBundle\Entity\Department $department
     *
     * @return Cycle
     */
    public function setDepartment(\ESP\SchoolStructureBundle\Entity\Department $department = null)
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
}
