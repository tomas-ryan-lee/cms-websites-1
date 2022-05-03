<?php

namespace App\Form;

use App\Entity\NavPosition;
use App\Entity\Pages;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagesListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pages_list', EntityType::class, [
                "label" => false,
                'class' => Pages::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'expanded' => true,
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Envoyer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
