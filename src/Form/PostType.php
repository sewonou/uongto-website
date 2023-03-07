<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Page;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isActive', CheckboxType::class, $this->getConfiguration("Actif", ""))
            ->add('isPublished', CheckboxType::class, $this->getConfiguration("Publiée", ""))
            ->add('title', TextType::class, $this->getConfiguration("",""))
            ->add('content', TextareaType::class, $this->getConfiguration("Contenu", "Saisir le conbtenu"))
            ->add('contentIntro', TextareaType::class, $this->getConfiguration("Introduction du contenu", "Saisir l'introduction'"))
            ->add('contentDescription', TextareaType::class, $this->getConfiguration("Description du contenu", "Saisir la desctiption du contenu"))
            ->add('metaDescription', TextareaType::class, $this->getConfiguration("",""))
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Choisir l'image "))
            ->add('quote', TextareaType::class, $this->getConfiguration("",""))
            ->add('categories', EntityType::class, $this->getConfiguration("","", [
                'placeholder'=>"Choisir la catégorie",
                'class' => Category::class,
                'multiple' => true,
                'choice_label' => 'title'
            ]))
            ->add('page', EntityType::class, $this->getConfiguration("Page de publication","", [
                'placeholder'=>"Choisir la page",
                'class' => Page::class,
                'choice_label' => 'title'
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
