<?php

namespace App\Form;

use App\Entity\Historic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoricType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', TextType::class, $this->getConfiguration("Période", "Saisir la période de l'historique"))
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Saisir le titre de l'historique"))
            ->add('subtitle', TextType::class, $this->getConfiguration("Sous titrage", "Saisir le sous titrage de l'historique"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description", "Saisir la description de l'Historique"))
            ->add('isPublished', CheckboxType::class, $this->getConfiguration("Publiée", ""))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Historic::class,
        ]);
    }
}
