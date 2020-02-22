<?php

namespace ESP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESP\UserBundle\Entity\Student;
use ESP\UserBundle\Form\StudentType;
use ESP\UserBundle\Form\StudentDeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class StudentController extends Controller
{
    public function homeAction()
    {
        
    }
    public function createAction(Request $request)
    {
        $student = new Student();
         
        $form = $this->get('form.factory')->create(StudentType::class, $student);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($student);
                $em->flush();

                $this->get('esp_user.email.mailer')->sendConfirmationAccount($student);

                $request->getSession()->getFlashBag()->add('infoSuccess', "L'étudiant(e) ". $student->getFirstName() . " ". $student->getLastName() . " a été enregistré(e) avec succés!");
                $this->redirectToRoute('esp_user_admin_student_create');
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "L'enregistrement ". $student->getFirstName() . " ". $student->getLastName() . " a échoué!");
                $this->redirectToRoute('esp_user_admin_student_create');
            }
        }


        return $this->render('ESPUserBundle:Student:create.html.twig', array('form'=>$form->createView()));
    }

    public function confirmAction($confirmationToken, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ESPUserBundle:Student");

        $student = $repository->getStudentRelatedToThisToken($confirmationToken);

        /* si le token ne correspond à aucun compte d'etudiant */
        if($student == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide, Veuillez vous faire inscrire par l'administrateur du site de l'ESP");
        }else
        /* si le token correspond bien à un compte d'etudiant */
        {
            /* et que le compte ait déjà été activé */
            if($student->getEnabled() == true)
            {
                throw new NotFoundHttpException("Ce compte a déjà été activé!");                
            }
            /* le compte n'as pas été activé. On le fait tout de suite */
    
            elseif($student->getEnabled() == false)
            {
                $student->setEnabled(true);
                $em->flush();
                $request->getSession()->getFlashBag()->add('infoSuccess', 'Votre compte a été bien activé, '.$student->getName(). ' !');
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
        $repository = $em->getRepository("ESPUserBundle:Student");
        $student = $repository->find($id); 
         
        if($student == null)
        {
            throw new NotFoundHttpException("Ce lien est invalide!");                
        }
        /* On recupère l'ancien email, nom et prenom */
        $previousEmail = $student->getEmail();
        $previousFirstName = $student->getFirstName();
        $previousLastName = $student->getLastName();
        $previousNumber = $student->getNumber();

        $form = $this->get('form.factory')->create(StudentType::class, $student);

        /* lors de la soumission de formulaire */
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                /* si l'ancien email est different de l'email actuel du formulaire */
                if($previousEmail != $student->getEmail())
                {
                    if($student->getEnabled() == false)
                    {
                        $em->flush();

                        $this->get('esp_user.email.mailer')->sendConfirmationAccount($student);

                        $request->getSession()->getFlashBag()->add('infoSuccess', "Le compte de l'etudiant(e)". $previousFirstName . " ". $previousLastName . " a été modifié(e) avec succés!");
                        return $this->redirectToRoute('esp_user_admin_student_update', array("id"=>$id));
                    }elseif($student->getEnabled() == true)
                    {
                        $request->getSession()->getFlashBag()->add('infoError', "Désolé les infos du compte de l'etudiant(e)". $previousFirstName . " ". $previousLastName . " sont personnelles et ne peuvent être modifiées!");
                        return $this->redirectToRoute('esp_user_admin_student_update', array("id"=>$id));
                    }else
                    {
                        $request->getSession()->getFlashBag()->add('infoError', "Désolé la modification du compte de l'etudiant(e)". $previousFirstName . " ". $previousLastName . " a échoué!");        
                        return $this->redirectToRoute('esp_user_admin_student_update', array("id"=>$id));
                    }
                    
                }/* L'email est le même que le précédent */
                else{
                    $em->flush();

                    /* On envoie une notification à l'élève!*/
                    if($student->getEnabled() == true)
                    {
                        $this->get('esp_user.email.mailer')->sendUpdatingNotification($student);
                    }elseif($student->getEnabled() == false)
                    {
                        if($student->getNumber() != $previousNumber)
                        {
                            $this->get('esp_user.email.mailer')->sendConfirmationAccount($student);
                        }

                    }

                    $request->getSession()->getFlashBag()->add('infoSuccess', "Le compte de l'etudiant(e)". $previousFirstName . " ". $previousLastName . " a été modifié(e) avec succés!");
                    return $this->redirectToRoute('esp_user_admin_student_update', array("id"=>$id));
                }
            }else
            {
                $request->getSession()->getFlashBag()->add('infoError', "Désolé la modification du compte de l'etudiant(e)". $previousFirstName . " ". $previousLastName . " a échoué!");        
                return $this->redirectToRoute('esp_user_admin_student_update', array("id"=>$id));
            }
        }


        return $this->render('ESPUserBundle:Student:update.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'etudiant $id
        $student = $em->getRepository('ESPUserBundle:Student')->find($id);

        if (null === $student) {
        throw new NotFoundHttpException("Ce lien est invalide.");
        }

        $form = $this->get('form.factory')->create(StudentDeleteType::class, $student);
        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {

                $em->remove($student);
                $em->flush();

                $this->get('esp_user.email.mailer')->sendDeletingNotification($student);

                $request->getSession()->getFlashBag()->add('infoSuccess','Le compte de l\'etudiant '.$student->getName().' a été supprimé!');
                return $this->redirectToRoute('esp_user_admin_student_viewAll');
            }else
            {   
                $request->getSession()->getFlashBag()->add('infoError','Le compte de l\'etudiant '.$student->getName().' n\'a pas pu être supprimé!');
                return $this->render('ESPUserBundle:Student:delete.html.twig', array('student'=>$student, 'form'=>$form->createView()));
            }
        }

        // Ici, on gérera la suppression de l'etudiant en question

        return $this->render('ESPUserBundle:Student:delete.html.twig', array('student'=>$student, 'form'=>$form->createView()));

    }
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'etudiant $id
        $student = $em->getRepository('ESPUserBundle:Student')->find($id);
        if (null === $student) {
        throw new NotFoundHttpException("Ce lien n'est pas valide!");
        }

        return $this->render('ESPUserBundle:Student:view.html.twig', array('student' => $student));
    }

    public function viewAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'etudiant $id
        $students = $em->getRepository('ESPUserBundle:Student')->findAll();

        return $this->render('ESPUserBundle:Student:viewAll.html.twig', array('students' => $students));
    }
}
