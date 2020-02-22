<?php

namespace ESP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESP\UserBundle\Entity\Professor;
use ESP\UserBundle\Form\ProfessorType;
use ESP\UserBundle\Form\ProfessorDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProfessorController extends Controller
{
    public function createAction(Request $request)
    {
        $professor = new Professor();
         
        $form = $this->get('form.factory')->create(ProfessorType::class, $professor);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($professor);
                $em->flush();

                $this->get('esp_user.email.mailer')->sendConfirmationProfessorAccount($professor);

                $request->getSession()->getFlashBag()->add('infoSuccess', "Le professeur ". $professor->getFirstName() . " ". $professor->getLastName() . " a été enregistré(e) avec succés!");
                $this->redirectToRoute('esp_user_admin_professor_create');
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "L'enregistrement du professeur". $professor->getFirstName() . " ". $professor->getLastName() . " a échoué!");
                $this->redirectToRoute('esp_user_admin_professor_create');
            }
        }


        return $this->render('ESPUserBundle:Professor:create.html.twig', array('form'=>$form->createView()));
    }

    public function confirmAction($confirmationToken, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ESPUserBundle:Professor");

        $professor = $repository->getProfessorRelatedToThisToken($confirmationToken);

        /* si le token ne correspond à aucun compte d'professeur */
        if($professor == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide, Veuillez vous faire inscrire par l'administrateur du site de l'ESP");
        }else
        /* si le token correspond bien à un compte d'professeur */
        {
            /* et que le compte ait déjà été activé */
            if($professor->getEnabled() == true)
            {
                throw new NotFoundHttpException("Ce compte a déjà été activé!");                
            }
            /* le compte n'as pas été activé. On le fait tout de suite */
    
            elseif($professor->getEnabled() == false)
            {
                $professor->setEnabled(true);
                $em->flush();
                $request->getSession()->getFlashBag()->add('infoSuccess', 'Votre compte a été bien activé, '.$professor->getName(). ' !');
                return $this->redirectToRoute("core_homepage");
            }
            else
            {
                throw new NotFoundHttpException("Cette page n'existe pas!");
            }

                            

        }
    

    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ESPUserBundle:Professor");
        $professor = $repository->find($id); 
         
        if($professor == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide!");                
        }
        /* On recupère l'ancien email, nom et prenom */
        $previousEmail = $professor->getEmail();
        $previousFirstName = $professor->getFirstName();
        $previousLastName = $professor->getLastName();
        $previousRegistrationNumber = $professor->getRegistrationNumber();

        $form = $this->get('form.factory')->create(ProfessorType::class, $professor);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                /* si l'ancien email est different de l'email actuel du formulaire */
                if($previousEmail != $professor->getEmail())
                {
                    if($professor->getEnabled() == false)
                    {
                        $em->flush();

                        $this->get('esp_user.email.mailer')->sendConfirmationProfessorAccount($professor);

                        $request->getSession()->getFlashBag()->add('infoSuccess', "Le compte du professeur". $previousFirstName . " ". $previousLastName . " a été modifié(e) avec succés!");
                        return $this->redirectToRoute('esp_user_admin_professor_update', array("id"=>$id));
                    }elseif($professor->getEnabled() == true)
                    {
                        $request->getSession()->getFlashBag()->add('infoError', "Désolé les infos du compte du professeur". $previousFirstName . " ". $previousLastName . " sont personnelles et ne peuvent être modifiées!");
                        return $this->redirectToRoute('esp_user_admin_professor_update', array("id"=>$id));
                    }else
                    {
                        $request->getSession()->getFlashBag()->add('infoError', "Désolé la modification du compte du professeur". $previousFirstName . " ". $previousLastName . " a échoué!");        
                        return $this->redirectToRoute('esp_user_admin_professor_update', array("id"=>$id));
                    }
                    
                }/* L'email est le même que le précédent */
                else{
                    $em->flush();

                    /* On envoie une notification à l'élève!*/
                    if($professor->getEnabled() == true)
                    {
                        $this->get('esp_user.email.mailer')->sendProfessorUpdatingNotification($professor);
                    }elseif($professor->getEnabled() == false)
                    {
                        if($professor->getNumber() != $previousRegistrationNumber)
                        {
                            $this->get('esp_user.email.mailer')->sendConfirmationProfessorAccount($professor);
                        }

                    }

                    $request->getSession()->getFlashBag()->add('infoSuccess', "Le compte du professeur". $previousFirstName . " ". $previousLastName . " a été modifié(e) avec succés!");
                    return $this->redirectToRoute('esp_user_admin_professor_update', array("id"=>$id));
                }
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "Désolé la modification du compte du professeur". $previousFirstName . " ". $previousLastName . " a échoué!");        
                return $this->redirectToRoute('esp_user_admin_professor_update', array("id"=>$id));
            }
        }


        return $this->render('ESPUserBundle:Professor:update.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'professeur $id
        $professor = $em->getRepository('ESPUserBundle:Professor')->find($id);

        if (null === $professor) {
        throw new NotFoundHttpException("Ce lien est invalide.");
        }

        $form = $this->get('form.factory')->create(ProfessorDeleteType::class, $professor);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {

                $em->remove($professor);
                $em->flush();

                $this->get('esp_user.email.mailer')->sendProfessorDeletingNotification($professor);

                $request->getSession()->getFlashBag()->add('infoSuccess','Le compte du professeur '.$professor->getName().' a été supprimé!');
                return $this->redirectToRoute('esp_user_admin_professor_viewAll');
            }else
            {   
                $request->getSession()->getFlashBag()->add('infoError','Le compte du professeur '.$professor->getName().' n\'a pas pu être supprimé!');
                return $this->render('ESPUserBundle:Professor:delete.html.twig', array('professor'=>$professor, 'form'=>$form->createView()));
            }
        }

        // Ici, on gérera la suppression de l'professeur en question

        return $this->render('ESPUserBundle:Professor:delete.html.twig', array('professor'=>$professor, 'form'=>$form->createView()));

    }
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'professeur $id
        $professor = $em->getRepository('ESPUserBundle:Professor')->find($id);
        if (null === $professor) {
        throw new NotFoundHttpException("Ce lien n'est pas valide!");
        }

        return $this->render('ESPUserBundle:Professor:view.html.twig', array('professor' => $professor));
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'professeur $id
        $professors = $em->getRepository('ESPUserBundle:Professor')->findAll();

        return $this->render('ESPUserBundle:Professor:viewAll.html.twig', array('professors' => $professors));
    }
}
