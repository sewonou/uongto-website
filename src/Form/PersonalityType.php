<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Personality;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalityType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Choisir l'image"))
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom (s)", "Saisir le (s) prénom (s)"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom de famille", "Saisir le nom de famille"))
            ->add('facebookUrl', UrlType::class, $this->getConfiguration("Url Facebook", "Saisir l'Url facebook"))
            ->add('twitterUrl', UrlType::class, $this->getConfiguration("Url Twitter", "Saisir l'Url Twitter"))
            ->add('linkedinUrl',UrlType::class, $this->getConfiguration("Url LinkedIn", "Saisir l'Url LinkedIn"))
            ->add('isPublished', CheckboxType::class, $this->getConfiguration("Publié", ""))
            ->add('office', TextType::class, $this->getConfiguration("Poste occupé", "Saisir le poste occupé"))
            ->add('page', EntityType::class, $this->getConfiguration("Page de publication", "Sélectionner la page", [
                'placeholder'=>"Sélectionner la page",
                'class' => Page::class,
                'choice_label' => 'title'
            ]))
            ->add('gender', ChoiceType::class,  $this->getConfiguration("Sexe", "Sélectionner le sexe", [
                'placeholder'=>"Sélectionner le sexe",
                'choices' => [
                    'Masculin' => 'male',
                    'Féminin' => 'feminine',
                ]
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personality::class,
        ]);
    }
}
