<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Option;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Saisir le titre de la catégorie"))
            ->add('isActive', CheckboxType::class, $this->getConfiguration("Actif", ""))
            ->add('metaDescription', TextareaType::class, $this->getConfiguration("Meta description de la catégorie", "Saisir la méta description de la catégorie"))
            ->add('isPublished', CheckboxType::class, $this->getConfiguration("Publiée", ""))
            ->add('type', EntityType::class, $this->getConfiguration('Option', "", [
                'placeholder'=>"Choisir l'option de la catégorie",
                'class' => Option::class,
                'choice_label' => 'title'
            ]) )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
