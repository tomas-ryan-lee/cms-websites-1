<?php

namespace App\Form;

use App\Entity\Pages;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page_title', TextType::class, [
                "label" => "Nom de la page",
            ])
            ->add('page_content', CKEditorType::class, [
                "label" => "Contenu de la page",
                "required" => false,
            ])
            ->add('page_url', TextType::class, [
                "label" => "URL de la page",
                "required" => false
            ])
            ->add('page_meta_title', TextType::class, [
                "label" => "Balise Title de la page",
                "required" => false,
            ])
            ->add("page_meta_desc", TextareaType::class, [
                "label" => "Balise Description de la page",
                "required" => false,
            ])
            ->add("page_submit", SubmitType::class, [
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
