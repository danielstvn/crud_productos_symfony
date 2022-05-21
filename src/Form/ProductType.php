<?php

namespace App\Form;

use App\Entity\Product;
use DateTime;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;



class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('code', TextType::class,[
                'label' => 'Codigo',
                'attr' =>[
                    'placeholder' => 'Codigo',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                    'pattern' => '[A-Za-z0-9]+',
                    'minlength' => '4',
                    'maxlength' => '10'
                    

                ]
            ])

            ->add('name',TextType::class,[
                'label' => 'Nombre',
                'attr' =>[
                    'placeholder' => 'Nombre',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                    'minlength' => '4'
                    
                ]
            ])


            ->add('description',TextType::class,[
                'label' => 'Descripción',
                'attr' =>[
                    'placeholder' => 'Descripción',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true
                ]
            ])

            ->add('brand',TextType::class,[
                'label' => 'Marca',
                'attr' =>[
                    'placeholder' => 'Marca del producto',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true
                ]
            ])

            ->add('price',NumberType::class,[
                'label' => 'Precio',
                'attr' =>[
                    'placeholder' => 'Precio del Producto',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                    'required' => true,
                    'pattern' => '^[1-9]\d*$'
                    
                    

                ]
            ])

            ->add('category')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
