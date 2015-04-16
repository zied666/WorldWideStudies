<?php

namespace Back\SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GenerateDatesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('monday', 'checkbox', array(
                    'label'   =>'Monday',
                    'required'=>false
                ))
                ->add('tuesday', 'checkbox', array(
                    'label'   =>'Tuesday',
                    'required'=>false
                ))
                ->add('wednesday', 'checkbox', array(
                    'label'   =>'Wednesday',
                    'required'=>false
                ))
                ->add('thursday', 'checkbox', array(
                    'label'   =>'Thursday',
                    'required'=>false
                ))
                ->add('friday', 'checkbox', array(
                    'label'   =>'Friday',
                    'required'=>false
                ))
                ->add('saturday', 'checkbox', array(
                    'label'   =>'Saturday',
                    'required'=>false
                ))
                ->add('startDate', 'date', array(
                    'widget'=>'single_text',
                    'format'=>'yyyy-MM-dd',
                ))
                ->add('endDate', 'date', array(
                    'widget'=>'single_text',
                    'format'=>'yyyy-MM-dd',
                ))
        ;
    }

    public function getName()
    {
        return 'back_schoolbundle_generatedates';
    }

}
