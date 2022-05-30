<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',
                TextType::class,
                [
                    'label' => 'Nom du produit',
                    'constraints' => new Length([
                        'min' => 2,
                        'max' => 30
                    ]),
                    'attr' => [
                        'placeholder' => 'Saisir nom produit'
                    ]
                ]
            )
            ->add('description',
                TextareaType::class,
                [
                    'label' => 'Description du produit',
                    'constraints' => new Length([
                        'min' => 2,
                        'max' => 300
                    ]),
                    'attr' => [
                        'placeholder' => 'Saisir description produit'
                    ]
                ]
            )
            ->add('prixHt',
                MoneyType::class,
                [
                    'label' => 'Prix du produit',
                    'attr' => [
                        'placeholder' => 'Saisir prix produit'
                    ]
                ]
            )
            ->add('picture', FileType::class, [
                'label' => 'Photo du produit ( .jpg, .jpeg, .png )',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
            ])
            ->add('categories',
        EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'by_reference' => false,
                    'label' => 'Catégorie',
                    'attr' => [
                        'placeholder' => 'Choisir une catégorie'
                    ]
                ])
            ->add('promo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
