<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            // ->add('slug')
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ description est obligatoire.',
                    ]),
                ],
            ])
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'brouillon' => 'brouillon',
                    'publier' => 'publier',
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'required' => true,
            ])
        
            // ->add('updatedAt')
            // ->add('createdAt')
            // ->add('imageName')
            // ->add('imageSize')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
