<?php

namespace ESP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planner
 *
 * @ORM\Table(name="esp_planner")
 * @ORM\Entity(repositoryClass="ESP\UserBundle\Repository\PlannerRepository")
 */
class Planner extends \ESP\UserBundle\Entity\Professor
{
  
}
