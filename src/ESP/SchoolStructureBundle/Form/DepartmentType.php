<?php

namespace ESP\SchoolStructureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ESP\SchoolStructureBundle\Form\DepartmentOptionType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class DepartmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
        ->add('description', TextareaType::class, array('required'=>false))
        ->add('departmentOptions', CollectionType::class, array(
            'entry_type'   => DepartmentOptionType::class,
            'allow_add'    => true,
            'allow_delete' => true
          ))
        ->add('save', SubmitType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ESP\SchoolStructureBundle\Entity\Department'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'esp_schoolstructurebundle_department';
    }


}
