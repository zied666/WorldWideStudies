<?php

namespace Front\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormStep4Type extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('specialNeeds', 'choice', array(
                    'choices' =>array( TRUE=>'Yes', FALSE=>'No' ),
                    'required'=>TRUE,
                    'expanded'=>TRUE,
                ))
                ->add('comments')
                ->add('term1', 'checkbox', array(
                    'label'   =>'I declare that the information I have supplied on and with this form is complete and correct. I declare that I am over 18 or can provide proof of parental consent',
                    'required'=>true
                ))
                ->add('term2', 'checkbox', array(
                    'label'   =>'I have read and accept the terms and conditions below.',
                    'required'=>true
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Front\GeneralBundle\Entity\FormStep4'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'front_generalbundle_formstep4';
    }

}
