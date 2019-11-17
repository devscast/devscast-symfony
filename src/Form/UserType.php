<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('password', PasswordType::class, [

            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => $this->getRolesChoices(),
            ])
            ->add('avatar', FileType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getRolesChoices()
    {
        return [
            "ROLE_ADMIN" => "ROLE_ADMIN",
            "ROLE_USER" => "ROLE_USER",
        ];
    }
}
