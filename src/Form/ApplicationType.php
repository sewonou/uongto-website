<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;

class ApplicationType extends  AbstractType
{
    /**
     * Permet d'avoir une configuration de base'
     *
     * @param $label string
     * @param $placeholder string
     * @param $options array
     * @return array
     */
    protected function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge_recursive([
            'label' => $label,
            'required' => false,
            'attr' => [
                'placeholder' => $placeholder,
            ]
        ], $options);
    }
}
