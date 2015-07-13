<?php

namespace Front\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormStep2Type extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('universityDegree', 'choice', array(
                    'choices' =>array( TRUE=>'Yes', FALSE=>'No' ),
                    'required'=>TRUE,
                    'expanded'=>TRUE,
                ))
                ->add('lastQualification')
                ->add('graduationYear')
                ->add('currentYearStudy')
                ->add('expectedGraduationYear')
                ->add('schoolName')
                ->add('country')
                ->add('lastQualificationS2')
                ->add('graduationYearS2')
                ->add('schoolNameS2')
                ->add('countryS2')
                ->add('englishTest', 'choice', array(
                    'choices' =>array( TRUE=>'Yes', FALSE=>'No' ),
                    'required'=>TRUE,
                    'expanded'=>TRUE,
                ))
                ->add('test', 'choice', array(
                    'choices' =>array( 1=>'IELTS', 2=>'TOEFL', 3=>'OTHER' ),
                    'required'=>false,
                    'expanded'=>TRUE,
                ))
                ->add('score')
                ->add('nameTest')
                ->add('testDate','birthday')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Front\GeneralBundle\Entity\FormStep2'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'front_generalbundle_formstep2';
    }

}
