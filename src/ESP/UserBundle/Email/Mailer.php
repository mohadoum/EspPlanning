<?php
// src/ESP/UserBundle/Email/Mailer.php

namespace ESP\UserBundle\Email;

use ESP\UserBundle\Entity\Student;
use ESP\UserBundle\Entity\Professor;
use ESP\UserBundle\Entity\DepartmentChief;

class Mailer
{
  /**
   * @var \Swift_Mailer
   */
  private $mailer;
  private $confirmationLinks;

  public function __construct(\Swift_Mailer $mailer, $confirmationLinks)
  {
    $this->mailer = $mailer;
    $this->confirmationLinks = $confirmationLinks;
  }

  public function sendConfirmationAccount(Student $student)
  {
      $message = new \Swift_Message(
        'Confirmation de compte ESPPlanning',
        "Yo ".$student->getName(). "! Veuillez confirmer votre compte pour bénéficier des services de ESPPlanning. \n"
        . "Vous pourrez ainsi accéder à votre emploi du temps tout le temps! \n"
        . "Cliquez ". "<a href=\"".$this->confirmationLinks["student"].$student->getConfirmationToken()."\"> ici!</a>"
      );
  
      $message
        ->addTo($student->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;
  
      $this->mailer->send($message);
  }

  public function sendUpdatingNotification(Student $student)
  {
 
      $message = new \Swift_Message(
        'Mise à jour de votre compte ESPPlanning',
        "Yo ".$student->getName(). "! Vos infos personnelles ont été modifiées! Veuillez-vous reconnectez!"
      );

      $message
        ->addTo($student->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;

      $this->mailer->send($message);
  }

  public function sendDeletingNotification(Student $student)
  {
      $message = new \Swift_Message(
        'Suppression de votre compte ESPPlanning',
        "Yo ".$student->getName(). "! Votre compte vient d'être supprimé! Nous espèrons vous revoir bientôt!"
      );
  
      $message
        ->addTo($student->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;
  
      $this->mailer->send($message);
  }

  /* Pour les profs */
  public function sendConfirmationProfessorAccount(Professor $professor)
  {
      $message = new \Swift_Message(
        'Confirmation de compte ESPPlanning',
        "Yo ".$professor->getName(). "! Veuillez confirmer votre compte pour bénéficier des services de ESPPlanning. \n"
        . "Vous pourrez ainsi accéder à votre emploi du temps tout le temps! \n"
        . "Cliquez ". "<a href=\"".$this->confirmationLinks["professor"].$professor->getConfirmationToken()."\"> ici!</a>"
      );
  
      $message
        ->addTo($professor->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;
  
      $this->mailer->send($message);
  }

  public function sendProfessorUpdatingNotification(Professor $professor)
  {
 
      $message = new \Swift_Message(
        'Mise à jour de votre compte ESPPlanning',
        "Yo ".$professor->getName(). "! Vos infos personnelles ont été modifiées! Veuillez-vous reconnectez!"
      );

      $message
        ->addTo($professor->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;

      $this->mailer->send($message);
  }

  public function sendProfessorDeletingNotification(Professor $professor)
  {
      $message = new \Swift_Message(
        'Suppression de votre compte ESPPlanning',
        "Yo ".$professor->getName(). "! Votre compte vient d'être supprimé! Nous espèrons vous revoir bientôt!"
      );
  
      $message
        ->addTo($professor->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;
  
      $this->mailer->send($message);
  }

  public function sendDepartmentChiefNotification(DepartmentChief $departmentChief)
  {
 
      $message = new \Swift_Message(
        'Mise à jour de votre compte ESPPlanning',
        "Yo ".$departmentChief->getProfessor()->getName(). "! Vous avez été désigné Chef de département. Félicitations!"
      );

      $message
        ->addTo($departmentChief->getProfessor()->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;

      $this->mailer->send($message);
  }

  public function sendDeletingDepartmentChiefNotification(DepartmentChief $departmentChief)
  {
 
      $message = new \Swift_Message(
        'Mise à jour de votre compte ESPPlanning',
        "Yo ".$departmentChief->getProfessor()->getName(). "! Vous avez été relevé de votre fonction de Chef de département."
      );

      $message
        ->addTo($departmentChief->getProfessor()->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
        ->addFrom('hairstyledic1@gmail.com')
      ;

      $this->mailer->send($message);
  }

}
