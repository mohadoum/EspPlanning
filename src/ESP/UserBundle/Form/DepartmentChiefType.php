<?php

namespace ESP\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DepartmentChiefType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('department' , ChoiceType::class, array(
            'choices' => array(
                'Département génie informatique' => "DGI",
                'Département génie mécanique' => "DGM",
                'Département génie civil' => "DGC",
                'Département de gestion' => "DG"
           
            )))
                ->add('save', SubmitType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ESP\UserBundle\Entity\DepartmentChief'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'esp_userbundle_admin_departmentChief';
    }


}
