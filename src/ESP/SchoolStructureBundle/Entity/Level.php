<?php

namespace ESP\SchoolStructureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Level
 *
 * @ORM\Table(name="esp_level", uniqueConstraints={@ORM\UniqueConstraint(name="uniqueCombinationLevelCycle", columns={"name", "cycle"})})
 * @ORM\Entity(repositoryClass="ESP\SchoolStructureBundle\Repository\LevelRepository")
 */
class Level
{
    /**
     * @ORM\OneToMany(targetEntity="ESP\SchoolStructureBundle\Entity\LevelClass", mappedBy="level")
     */
    private $classes;


    /**
     * @ORM\ManyToOne(targetEntity="ESP\SchoolStructureBundle\Entity\Cycle", inversedBy="levels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cycle;

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
     * @return Level
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
     * @return Level
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
     * Set cycle
     *
     * @param \ESP\SchoolStructureBundle\Entity\Cycle $cycle
     *
     * @return Level
     */
    public function setCycle(\ESP\SchoolStructureBundle\Entity\Cycle $cycle)
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * Get cycle
     *
     * @return \ESP\SchoolStructureBundle\Entity\Cycle
     */
    public function getCycle()
    {
        return $this->cycle;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add class
     *
     * @param \ESP\SchoolStructureBundle\Entity\LevelClass $class
     *
     * @return Level
     */
    public function addClass(\ESP\SchoolStructureBundle\Entity\LevelClass $class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * Remove class
     *
     * @param \ESP\SchoolStructureBundle\Entity\LevelClass $class
     */
    public function removeClass(\ESP\SchoolStructureBundle\Entity\LevelClass $class)
    {
        $this->classes->removeElement($class);
    }

    /**
     * Get classes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }
}
