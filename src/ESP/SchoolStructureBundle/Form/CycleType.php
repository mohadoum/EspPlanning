<?php

namespace ESP\SchoolStructureBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ESP\SchoolStructureBundle\Form\LevelType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormInterface;
use ESP\SchoolStructureBundle\Entity\Department;


class CycleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('department', EntityType::class, array(
            'class'        => 'ESPSchoolStructureBundle:Department',
            'choice_label' => 'name',
            'multiple'     => false,
            'placeholder' => ''
        ))
        
        ->add('name', TextType::class)
        ->add('description', TextareaType::class, array('required'=>false))
        ->add('levels', CollectionType::class, array(
            'entry_type'   => LevelType::class,
            'allow_add'    => true,
            'allow_delete' => true
          ))
        ->add('save', SubmitType::class);

    

        $formModifier = function (FormInterface $form, Department $department = null) {
            $departmentOptions = null === $department ? array() : $department->getDepartmentOptions();

            $form
            ->add('departmentOption', EntityType::class, array(
                'class'        => 'ESPSchoolStructureBundle:DepartmentOption',
                'choice_label' => 'name',
                'multiple'     => false,
                'choices' => $departmentOptions,
                'required' => false
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();              

                $formModifier($event->getForm(), $data->getDepartment());
            }
        );

        $builder->get('department')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)

                $department = $event->getForm()->getData();


                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $department);
            }
        );
        
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ESP\SchoolStructureBundle\Entity\Cycle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'esp_schoolstructurebundle_cycle';
    }


}
