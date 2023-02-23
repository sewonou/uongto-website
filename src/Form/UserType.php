<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, $this->getConfiguration("Nom d'utilisateur", "Saisir le nom d'utilisateur"))
            ->add('password', PasswordType::class, $this->getConfiguration("Mot de passe","Saisir le mot de passe"))
            ->add('firstName', TextType::class, $this->getConfiguration("Prénoms", "Saisir le(s) prénom(s)"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Saisir le nom"))
            ->add('imageFile', FileType::class, $this->getConfiguration("Image de profil", "Chpoisir l'image de profil"))
            ->add('userRoles', EntityType::class, $this->getConfiguration("Role","Choisir le niveau d'accès ...", [
                'class' => Role::class,
                'choice_label' => 'title',
                'multiple'=> true,
                'placeholder' => "Choisir le niveau d'accès ..."
            ]))
            ->add('email', TextType::class, $this->getConfiguration("Adresse Email","Saisir l'adresse Email"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            //'csrf_protection' => false,
        ]);
    }
}
