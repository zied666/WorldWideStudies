<?php

namespace Front\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormStep1Type extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('firstName')
                ->add('lastName')
                ->add('gender', 'choice', array(
                    'choices' =>array( '1'=>'male', '2'=>'female' ),
                    'required'=>TRUE,
                    'expanded'=>TRUE,
                ))
                ->add('birthDate','birthday')
                ->add('natianality')
                ->add('email')
                ->add('codePrimaryPhone')
                ->add('primaryPhone')
                ->add('codeAlternativePhone')
                ->add('alternativePhone')
                ->add('progressionUniversityDegree')
                ->add('levelOfStudy')
                ->add('subject')
                ->add('preferredIntake')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Front\GeneralBundle\Entity\FormStep1'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'front_generalbundle_formstep1';
    }

}
