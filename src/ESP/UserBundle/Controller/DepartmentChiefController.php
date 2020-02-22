<?php

namespace ESP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESP\UserBundle\Entity\DepartmentChief;
use ESP\UserBundle\Entity\Professor;
use ESP\UserBundle\Form\DepartmentChiefType;
use ESP\UserBundle\Form\DepartmentChiefDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DepartmentChiefController extends Controller
{
    public function createAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        /* si on veut avoir access à liste des profs pour ensuite choisir parmi ces derniers un chef de departement */
        if($id == null)
        {
            $professors =  $em->getRepository("ESPUserBundle:Professor")->getProfessorsWithDepartmentChief();

            return $this->render("ESPUserBundle:DepartmentChief:create.html.twig", array("id"=> $id, "professors" =>$professors));
        }
        /* si on a deja choisi notre professeur */ 
        else
        {
            $professor = $em->getRepository("ESPUserBundle:Professor")->find($id);

            $departmentChief = new DepartmentChief();
            
            $form = $this->get('form.factory')->create(DepartmentChiefType::class, $departmentChief);

            /* lors de la soumission de formulaire */
            if($request->isMethod('POST'))
            {
                $form->handleRequest($request);
                if($form->isValid())
                {
                    $departmentChief->setProfessor($professor);
                    $em->persist($departmentChief);
                    $em->flush();

                    $this->get('esp_user.email.mailer')->sendDepartmentChiefNotification($departmentChief);

                    $request->getSession()->getFlashBag()->add('infoSuccess', "Le professeur ". $professor->getName() . " a été désigné comme chef de départment!");
                    return  $this->redirectToRoute('esp_user_admin_departmentChief_create');
                }else
                {
                    $request->getSession()->getFlashBag()->add('infoError', "L'enregistrement du professeur". $professor->getName() . " en tant que chef de département a échoué!");
                    return $this->redirectToRoute('esp_user_admin_departmentChief_create');
                }
            }

            return $this->render('ESPUserBundle:DepartmentChief:create.html.twig', array('form'=>$form->createView(), 'professor'=>$professor, 'id'=>$id));
        }
    }

    public function confirmAction($confirmationToken, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ESPUserBundle:DepartmentChief");

        $departmentChief = $repository->getDepartmentChiefRelatedToThisToken($confirmationToken);

        /* si le token ne correspond à aucun compte d'professeur */
        if($departmentChief == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide, Veuillez vous faire inscrire par l'administrateur du site de l'ESP");
        }else
        /* si le token correspond bien à un compte d'professeur */
        {
            /* et que le compte ait déjà été activé */
            if($departmentChief->getEnabled() == true)
            {
                throw new NotFoundHttpException("Ce compte a déjà été activé!");                
            }
            /* le compte n'as pas été activé. On le fait tout de suite */
    
            elseif($departmentChief->getEnabled() == false)
            {
                $departmentChief->setEnabled(true);
                $em->flush();
                $request->getSession()->getFlashBag()->add('infoSuccess', 'Votre compte a été bien activé, '.$departmentChief->getName(). ' !');
                return $this->redirectToRoute("core_homepage");
            }
            else
            {
                throw new NotFoundHttpException("Cette page n'existe pas!");
            }

                            

        }
    

    }

    public function updateAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        /* si on veut avoir access à liste des profs pour ensuite choisir parmi ces derniers un chef de departement */
        if($id == null)
        {
            $depts =  $em->getRepository("ESPUserBundle:DepartmentChief")->getDepartmentChiefsWithProfessor();
            
            return $this->render("ESPUserBundle:DepartmentChief:update.html.twig", array("id"=> $id, "depts" =>$depts));
        }
        /* si on a deja choisi notre professeur */ 
        else
        {
            $professor = $em->getRepository("ESPUserBundle:Professor")->find($id);

            $departmentChief = $professor->getDepartmentChief();

            $form = $this->get('form.factory')->create(DepartmentChiefType::class, $departmentChief);

            /* lors de la soumission de formulaire */
            if($request->isMethod('POST'))
            {
                $form->handleRequest($request);
                if($form->isValid())
                {
                    $em->flush();
                    
                    $this->get('esp_user.email.mailer')->sendDepartmentChiefNotification($departmentChief);

                    $request->getSession()->getFlashBag()->add('infoSuccess', "Le professeur ". $professor->getName() . " a été désigné comme chef de départment!");
                    return $this->redirectToRoute('esp_user_admin_departmentChief_update');
                }else
                {
                    $request->getSession()->getFlashBag()->add('infoError', "L'enregistrement du professeur". $professor->getName() . " en tant que chef de département a échoué!");
                    return $this->redirectToRoute('esp_user_admin_departmentChief_update');
                }
            }

            return $this->render('ESPUserBundle:DepartmentChief:update.html.twig', array('form'=>$form->createView(), 'professor'=>$professor, 'id'=>$id));
        }
    }


    public function deleteAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        /* si on veut avoir access à liste des profs pour ensuite choisir parmi ces derniers un chef de departement */
        if($id == null)
        {
            $depts =  $em->getRepository("ESPUserBundle:DepartmentChief")->getDepartmentChiefsWithProfessor();
            
            return $this->render("ESPUserBundle:DepartmentChief:delete.html.twig", array("id"=> $id, "depts" =>$depts));
        }
        /* si on a deja choisi notre professeur */ 
        else
        {
            $professor = $em->getRepository("ESPUserBundle:Professor")->find($id);

            $departmentChief = $professor->getDepartmentChief();
            
            $form = $this->get('form.factory')->create(DepartmentChiefDeleteType::class, $departmentChief);

            /* lors de la soumission de formulaire */
            if($request->isMethod('POST'))
            {
                $form->handleRequest($request);
                if($form->isValid())
                {
                    $em->remove($departmentChief);

                    $em->flush();
                    
                    $this->get('esp_user.email.mailer')->sendDeletingDepartmentChiefNotification($departmentChief);

                    $request->getSession()->getFlashBag()->add('infoSuccess', "Le professeur ". $professor->getName() . " a été relevé du fonction chef de départment!");
                    return $this->redirectToRoute('esp_user_admin_departmentChief_delete');
                }else
                {
                    $request->getSession()->getFlashBag()->add('infoError', "Le relévement du professeur". $professor->getName() . " du fonction chef de département a échoué!");
                    return $this->redirectToRoute('esp_user_admin_departmentChief_delete');
                }
            }

            return $this->render('ESPUserBundle:DepartmentChief:delete.html.twig', array('form'=>$form->createView(), 'professor'=>$professor, 'id'=>$id));
        }
    }
   
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'professeur $id
        $departmentChief = $em->getRepository('ESPUserBundle:DepartmentChief')->find($id);
        if (null === $departmentChief) {
        throw new NotFoundHttpException("Ce lien n'est pas valide!");
        }

        return $this->render('ESPUserBundle:DepartmentChief:view.html.twig', array('DepartmentChief' => $departmentChief));
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'professeur $id
        $departmentChiefs = $em->getRepository('ESPUserBundle:DepartmentChief')->findAll();

        return $this->render('ESPUserBundle:DepartmentChief:viewAll.html.twig', array('DepartmentChiefs' => $departmentChiefs));
    }
}
