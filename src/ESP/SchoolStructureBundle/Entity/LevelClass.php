<?php

namespace ESP\SchoolStructureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LevelClass
 *
 * @ORM\Table(name="esp_level_class")
 * @ORM\Entity(repositoryClass="ESP\SchoolStructureBundle\Repository\LevelClassRepository")
 */
class LevelClass
{
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
     * @ORM\ManyToOne(targetEntity="ESP\SchoolStructureBundle\Entity\Level", cascade={"persist"}, inversedBy="classes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    
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
     * @return LevelClass
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
     * Set level
     *
     * @param \ESP\SchoolStructureBundle\Entity\Level $level
     *
     * @return LevelClass
     */
    public function setLevel(\ESP\SchoolStructureBundle\Entity\Level $level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \ESP\SchoolStructureBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }
}
