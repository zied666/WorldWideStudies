<?php

namespace Back\SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PriceType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('weekStart')
                ->add('weekEnd')
                ->add('price')
                ->add('fix', 'checkbox', array(
                    'label'   =>'Price fix',
                    'required'=>false
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Back\SchoolBundle\Entity\Price'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_schoolbundle_price';
    }

}
