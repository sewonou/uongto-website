<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,  $this->getConfiguration("Titre", "Saisir le titre de la page"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description","Saisir la description pour le SEO"))
            ->add('codeName', TextType::class, $this->getConfiguration("Code Name","saisir le code name sans espace"))
            ->add('isActive', CheckboxType::class, $this->getConfiguration("Actif", ""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
