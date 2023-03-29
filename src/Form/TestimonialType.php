<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Testimonial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestimonialType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Saisir le titre"))
            ->add('content', TextareaType::class, $this->getConfiguration("Message", "Saisir le message"))
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Choisir l'image"))
            ->add('isPublished', CheckboxType::class, $this->getConfiguration("Publiée", ""))
            ->add('page', EntityType::class, $this->getConfiguration('Page', "", [
                'placeholder'=>"Choisir l'option de la catégorie",
                'class' => Page::class,
                'choice_label' => 'title',
            ]) )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimonial::class,
        ]);
    }
}
