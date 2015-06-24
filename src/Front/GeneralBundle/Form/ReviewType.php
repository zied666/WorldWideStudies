<?php

namespace Front\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReviewType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title')
                ->add('name')
                ->add('text')
                ->add('note', 'choice', array(
                    'choices'=>array(
                        1=>'1 Star',
                        2=>'2 Stars',
                        3=>'3 Stars',
                        4=>'4 Stars',
                        5=>'5 Stars',
                    ),
                    'expanded'=>true,
                    'required'=>true,
                ))
//            ->add('schoolLocation')
//            ->add('accommodation')
//            ->add('courseTitle')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Front\GeneralBundle\Entity\Review'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'front_generalbundle_review';
    }

}
