<?php
// src/ESP/SchoolStructureBundle/DataFixtures/ORM/LoadLevelClass.php

namespace ESP\SchoolStructureBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESP\SchoolStructureBundle\Entity\LevelClass;
use ESP\SchoolStructureBundle\Entity\Department;
use ESP\SchoolStructureBundle\Entity\DepartmentOption;
use ESP\SchoolStructureBundle\Entity\Cycle;
use ESP\SchoolStructureBundle\Entity\Level;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoadLevelClass implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {


    /* department */
    $deptInf = $manager->getRepository("ESPSchoolStructureBundle:Department")->findOneByName("DGI");


    /* option*/
    $opt1 = $manager->getRepository("ESPSchoolStructureBundle:DepartmentOption")->findOneBy(array('department'=>$deptInf, 'id'=>1));
    $opt2 = $manager->getRepository("ESPSchoolStructureBundle:DepartmentOption")->findOneBy(array('department'=>$deptInf, 'id'=>2));

    /* cycles */

    $cycleDICInf = $manager->getRepository("ESPSchoolStructureBundle:Cycle")->findOneBy(array('departmentOption'=>$opt1, 'name'=>'DIC'));
    $cycleDICTr = $manager->getRepository("ESPSchoolStructureBundle:Cycle")->findOneBy(array('departmentOption'=>$opt2, 'name'=>'DIC'));
    $cycleDUTInf = $manager->getRepository("ESPSchoolStructureBundle:Cycle")->findOneBy(array('departmentOption'=>$opt1, 'name'=>'DUT'));

    /* levels */
    $level1 = $manager->getRepository("ESPSchoolStructureBundle:Level")->findOneBy(array('cycle'=>$cycleDUTInf, 'name'=>'DUT1'));
    $level2 = $manager->getRepository("ESPSchoolStructureBundle:Level")->findOneBy(array('cycle'=>$cycleDUTInf, 'name'=>'DUT2'));
    $level3 = $manager->getRepository("ESPSchoolStructureBundle:Level")->findOneBy(array('cycle'=>$cycleDICInf, 'name'=>'DIC1'));
    $level4 = $manager->getRepository("ESPSchoolStructureBundle:Level")->findOneBy(array('cycle'=>$cycleDICTr, 'name'=>'DIC1'));


    /* classes*/
    $class1 = new LevelClass();
    $class2 = new LevelClass();
    $class3 = new LevelClass();
    $class4 = new LevelClass();


    /* set names*/
    $class1->setName('DUT1_INFO');
    $class2->setName('DUT2_INFO');
    $class3->setName('DIC1_INFO');
    $class4->setName('DIC1_TR');
    /* set levels*/
    $class1->setLevel($level1);
    $class2->setLevel($level2);
    $class3->setLevel($level3);
    $class4->setLevel($level4);


    $manager->persist($class1);
    $manager->persist($class2);
    $manager->persist($class3);
    $manager->persist($class4);
    // On déclenche l'enregistrement de toutes les classes
    $manager->flush();
  }
}