<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nic')
            ->add('name')
            ->add('telephone')
            ->add('email')
            ->add('school')
            ->add('district')
            ->add('olEnglish')
            ->add('olMaths')
            ->add('language')
            ->add('alGrades')
            ->add('dob', 'date')
            ->add('availableTime', 'datetime')
            ->add('eduQualification')
            ->add('workExperience')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Person'
        ));
    }
}
