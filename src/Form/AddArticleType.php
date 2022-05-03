<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article_title', TextType::class, ["label" => "Nom de l'article"])
            ->add('article_slug', TextType::class, [
                "label" => "URL de l'article (Optionnel)",
                "required" => false,
                'attr' => array(
                    'placeholder' => 'Peut être généré automatiquement'
                )
            ])
            ->add('article_content', CKEditorType::class, [
                "label" => "Contenu de l'article",
                "required" => false,
            ])
            ->add('article_metatitle', TextType::class, [
                "label" => "Balise Title de l'article",
                "required" => false,
            ])
            ->add('article_metadesc', TextareaType::class, [
                "label" => "Balise Description de l'article",
                "required" => false,
                ])
            ->add("article_submit", SubmitType::class, ["label" => "Envoyer"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
