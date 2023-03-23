<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("", ""))
            ->add('shortName', TextType::class, $this->getConfiguration("", ""))
            ->add('url', UrlType::class, $this->getConfiguration("", ""))
            ->add('year', NumberType::class, $this->getConfiguration("", ""))
            ->add('facebookUrl', UrlType::class, $this->getConfiguration("", ""))
            ->add('twitterUrl', UrlType::class, $this->getConfiguration("", ""))
            ->add('linkedInUrl', UrlType::class, $this->getConfiguration("", ""))
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Choisir l'image"))
            ->add('description', TextareaType::class, $this->getConfiguration("", ""))
            ->add('isPublished', CheckboxType::class, $this->getConfiguration("Publié", ""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
