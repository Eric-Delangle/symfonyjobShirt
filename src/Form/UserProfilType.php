<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('password', PasswordType::class, [
                'attr' => [
                    'required' => false,
                    'style' => 'placeho',
                ]
            ])
            ->add('password_verify', PasswordType::class, [
                'attr' => [
                    'required' => false,
                    'style' => 'placeho',
                ] 
            ])
            ->add('numero')
            ->add('rue')
            ->add('codePostal')
            ->add('ville')
            ->add('tel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms',
        ]);
    }
}
