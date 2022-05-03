<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeJsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dataFile = file_get_contents("../public/js/website/functions.js");
        $builder
            ->add('code_front', CKEditorType::class, ["data" => dump($dataFile)])
            ->add('code_front_submit', SubmitType::class, ["label" => "Envoyer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
