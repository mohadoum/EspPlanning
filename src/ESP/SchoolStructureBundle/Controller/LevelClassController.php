<?php

namespace ESP\SchoolStructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESP\SchoolStructureBundle\Entity\LevelClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class LevelClassController extends Controller
{
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère le LevelClass $id
        $levelClass = $em->getRepository('ESPSchoolStructureBundle:LevelClass')->getLevelClassWithTheRest($id);
        if (null === $levelClass) {
        throw new NotFoundHttpException("Ce lien n'est pas valide!");
        }                

        return $this->render('ESPSchoolStructureBundle:LevelClass:view.html.twig', array('LevelClass' => $levelClass));
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère tous les LevelClasss 

        $levelClasss = $em->getRepository('ESPSchoolStructureBundle:LevelClass')->getAllLevelClasssWithoutLevelsOrderBy("asc");

        return $this->render('ESPSchoolStructureBundle:LevelClass:viewAll.html.twig', array('LevelClasss' => $levelClasss));
    }
}
