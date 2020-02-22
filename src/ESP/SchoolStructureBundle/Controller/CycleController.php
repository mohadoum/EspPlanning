<?php

namespace ESP\SchoolStructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESP\SchoolStructureBundle\Entity\Cycle;
use ESP\SchoolStructureBundle\Entity\Level;
use ESP\SchoolStructureBundle\Form\CycleType;
use ESP\SchoolStructureBundle\Form\CycleDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class CycleController extends Controller
{
    public function createAction(Request $request)
    {
        $cycle = new Cycle();

         
        $form = $this->get('form.factory')->create(CycleType::class, $cycle);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $levels = $cycle->getLevels();
                foreach($levels as $level)
                {
                    $cycle->addLevel($level);
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($cycle);
                $em->flush();

                $request->getSession()->getFlashBag()->add('infoSuccess', "Le cycle ". $cycle->getName() . " a été crée avec succés!");
                $this->redirectToRoute('esp_schoolstructure_admin_cycle_create');
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "La création du cycle ". $cycle->getName() . " a échouée!");
                $this->redirectToRoute('esp_schoolstructure_admin_cycle_create');
            }
        }


        return $this->render('ESPSchoolStructureBundle:Cycle:create.html.twig', array('form'=>$form->createView()));
    }

   

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ESPSchoolStructureBundle:Cycle");
        $cycle = $repository->getCycleWithTheRest($id); 
         
        if($cycle == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide!");                
        }
        /* On recupère l'ancien nom */
        $previousName = $cycle->getName();

        $form = $this->get('form.factory')->create(CycleType::class, $cycle);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $levels = $cycle->getLevels();
                foreach($levels as $level)
                {
                    $cycle->addLevel($level);
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add('infoSuccess', "Le cycle ". $cycle->getName() . " a été modifié avec succés!");
                $this->redirectToRoute('esp_schoolstructure_admin_cycle_update', array('id'=>$id));  
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "Désolé la modification du cycle ". $previousName . " a échoué!");        
                return $this->redirectToRoute('esp_schoolstructure_admin_cycle_update', array("id"=>$id));
            }
        }


        return $this->render('ESPSchoolStructureBundle:Cycle:update.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère le Cycle d'id $id
        $cycle = $em->getRepository('ESPSchoolStructureBundle:Cycle')->getCycleWithTheRest($id);;

        if (null === $cycle) {
        throw new NotFoundHttpException("Ce lien est invalide.");
        }

        $form = $this->get('form.factory')->create(CycleDeleteType::class, $cycle);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {

                $levels = $cycle->getLevels();
                /*On supprime les niveaux du cycle de l'objet $cycle*/
                foreach($levels as $level)
                {
                    $cycle->removeLevel($level);
                }
                /*On supprime les niveaux du cycle de la base de données*/
                $em->getRepository('ESPSchoolStructureBundle:Level')->removeAllLevels($cycle->getId());
                
                /*On supprime le cycle de la base de données*/
                $em->remove($cycle);
                $em->flush();

                $request->getSession()->getFlashBag()->add('infoSuccess','Le cycle '.$cycle->getName().' a été supprimé!');
                return $this->redirectToRoute('esp_schoolstructure_admin_cycle_viewAll');
            }else
            {   
                $request->getSession()->getFlashBag()->add('infoError','Le cycle '.$cycle->getName().' n\'a pas pu être supprimé!');
                return $this->render('ESPSchoolStructureBundle:Cycle:delete.html.twig', array('cycle'=>$cycle, 'form'=>$form->createView()));
            }
        }

        // Ici, on gérera la suppression du cycle en question

        return $this->render('ESPSchoolStructureBundle:Cycle:delete.html.twig', array('cycle'=>$cycle, 'form'=>$form->createView()));

    }
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère le cycle $id
        $cycle = $em->getRepository('ESPSchoolStructureBundle:Cycle')->getCycleWithTheRest($id);
        if (null === $cycle) {
        throw new NotFoundHttpException("Ce lien n'est pas valide!");
        }                

        return $this->render('ESPSchoolStructureBundle:Cycle:view.html.twig', array('cycle' => $cycle));
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère tous les cycles 

        $cycles = $em->getRepository('ESPSchoolStructureBundle:Cycle')->getAllCyclesWithoutLevelsOrderBy("asc");

        return $this->render('ESPSchoolStructureBundle:Cycle:viewAll.html.twig', array('cycles' => $cycles));
    }
}
