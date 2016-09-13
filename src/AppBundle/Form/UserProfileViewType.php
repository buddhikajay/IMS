<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/15/2016
 * Time: 12:50 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileViewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('first_name', TextType::class, array('label' => 'First Name'))
            ->add('last_name', TextType::class, array('label' => 'Last Name'))
            ->add('contact', TextType::class, array('label' => 'Contact Number'))
            ->add('profile_pic', FileType::class, array('label' => 'Profile Picture (.JPEG)', 'attr' => array('accept' => 'image/jpeg')))
            ->add('update', SubmitType::class, array('label' => 'Update Profile'))
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserProfile'
        ));
    }
}