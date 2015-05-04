<?php

namespace Back\UniversityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseTitleType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('description')
                ->add('price')
                ->add('duration')
                ->add('deadLine')
                ->add('subject')
                ->add('qualification')
                ->add('studyMode')
                ->add('level')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=>'Back\UniversityBundle\Entity\CourseTitle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'back_universitybundle_coursetitle';
    }

}
