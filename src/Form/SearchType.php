<?php

namespace App\Form;


use App\Entity\Category;
use App\Entity\Search;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class,
                [
                'label'=>false,
                'required'=>false,
                'attr'=> [
                    'placeholder' => 'Nom du produit ...',
                    'class'=>'form-control-sm',
                ]
            ])
            ->add('categories',
                EntityType::class,
                [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'label'=>false,
                'required'=>false,
                'attr'=> [
                    'placeholder' => 'Catégorie du produit ...',
                    'class'=>'form-control-sm',
                ]
            ])
            ->add('promo', CheckboxType::class,
                [
                    'label'=>false,
                    'required'=>false,
                    'attr'=> [
                        'placeholder' => 'Articles en promotion',
                        'class'=>'form-check-input',
                    ]
                ])
        ;
   }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}

