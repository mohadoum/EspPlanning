<?php

namespace ESP\SchoolStructureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESP\SchoolStructureBundle\Entity\Department;
use ESP\SchoolStructureBundle\Form\DepartmentType;
use ESP\SchoolStructureBundle\Form\DepartmentDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DepartmentController extends Controller
{
    public function createAction(Request $request)
    {
        $department = new Department();

         
        $form = $this->get('form.factory')->create(DepartmentType::class, $department);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $departmentOptions = $department->getDepartmentOptions();
                foreach($departmentOptions as $departmentOption)
                {
                    $department->addDepartmentOption($departmentOption);
                }
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($department);
                $em->flush();

                $request->getSession()->getFlashBag()->add('infoSuccess', "Le département ". $department->getName() . " a été crée avec succés!");
                $this->redirectToRoute('esp_schoolstructure_admin_department_create');
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "La création du département ". $department->getName() . " a échouée!");
                $this->redirectToRoute('esp_schoolstructure_admin_department_create');
            }
        }


        return $this->render('ESPSchoolStructureBundle:Department:create.html.twig', array('form'=>$form->createView()));
    }

   

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ESPSchoolStructureBundle:Department");
        $department = $repository->find($id); 
         
        if($department == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide!");                
        }
        /* On recupère l'ancien nom */
        $previousName = $department->getName();

        $form = $this->get('form.factory')->create(DepartmentType::class, $department);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $departmentOptions = $department->getDepartmentOptions();
                foreach($departmentOptions as $departmentOption)
                {
                    $department->addDepartmentOption($departmentOption);
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add('infoSuccess', "Le département ". $department->getName() . " a été modifié avec succés!");
                $this->redirectToRoute('esp_schoolstructure_admin_department_update', array('id'=>$id));  
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "Désolé la modification du département ". $previousName . " a échoué!");        
                return $this->redirectToRoute('esp_schoolstructure_admin_department_update', array("id"=>$id));
            }
        }


        return $this->render('ESPSchoolStructureBundle:Department:update.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère le department d'id $id
        $department = $em->getRepository('ESPSchoolStructureBundle:Department')->find($id);

        if (null === $department) {
        throw new NotFoundHttpException("Ce lien est invalide.");
        }

        $form = $this->get('form.factory')->create(DepartmentDeleteType::class, $department);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {

                $departmentOptions = $department->getDepartmentOptions();
                /*On supprime les options du departement de l'objet $department*/
                foreach($departmentOptions as $departmentOption)
                {
                    $department->removeDepartmentOption($departmentOption);
                }
                /*On supprime les options du departement de la base de données*/
                $em->getRepository('ESPSchoolStructureBundle:DepartmentOption')->removeAllDepartmentOptions($department->getId());
                
                /*On supprime le departement de la base de données*/
                $em->remove($department);
                $em->flush();

                $request->getSession()->getFlashBag()->add('infoSuccess','Le département '.$department->getName().' a été supprimé!');
                return $this->redirectToRoute('esp_schoolstructure_admin_department_viewAll');
            }else
            {   
                $request->getSession()->getFlashBag()->add('infoError','Le département '.$department->getName().' n\'a pas pu être supprimé!');
                return $this->render('ESPSchoolStructureBundle:Department:delete.html.twig', array('department'=>$department, 'form'=>$form->createView()));
            }
        }

        // Ici, on gérera la suppression de l'etudiant en question

        return $this->render('ESPSchoolStructureBundle:Department:delete.html.twig', array('department'=>$department, 'form'=>$form->createView()));

    }
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère le departement $id
        $department = $em->getRepository('ESPSchoolStructureBundle:Department')->getDepartmentWithOptions($id);
        if (null === $department) {
        throw new NotFoundHttpException("Ce lien n'est pas valide!");
        }                

        return $this->render('ESPSchoolStructureBundle:Department:view.html.twig', array('department' => $department));
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère tous les departements 
        $departments = $em->getRepository('ESPSchoolStructureBundle:Department')->findAll();

        return $this->render('ESPSchoolStructureBundle:Department:viewAll.html.twig', array('departments' => $departments));
    }
}
