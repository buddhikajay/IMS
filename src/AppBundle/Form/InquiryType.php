<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InquiryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('semester')
            ->add('probability')
            ->add('lastModified', 'datetime')
            ->add('created', 'datetime')
            ->add('person')
            ->add('course')
            ->add('inquiryMode')
            ->add('inquiryStatus')
            ->add('counsellor')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Inquiry'
        ));
    }
}
