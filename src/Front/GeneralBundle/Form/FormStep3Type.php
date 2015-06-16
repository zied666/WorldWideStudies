<?php

namespace Front\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormStep3Type extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('sourceFunding', 'choice', array(
                    'choices' =>array(
                        1=>"I am self-funding or family-funded",
                        2=>"I have sponsorship from a government, organisation or individual",
                        3=>"I expect to get a scholarship from elsewhere",
                        4=>"I have no funding and am seeking a full scholarship",
                    ),
                    'required'=>TRUE,
                    'expanded'=>TRUE,
                ))
                ->add('addressLine1')
                ->add('addressLine2')
                ->add('city')
                ->add('region')
                ->add('postal')
                ->add('country')
                ->add('currently', 'choice', array(
                    'choices' =>array( TRUE=>'Yes', FALSE=>'No' ),
                    'required'=>TRUE,
                    'expanded'=>TRUE,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Front\GeneralBundle\Entity\FormStep3'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'front_generalbundle_formstep3';
    }

}
