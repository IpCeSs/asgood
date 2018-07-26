<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['attr' => ['class' => "form-control"]])
            ->add('description')
            ->add('price', TextType::class, ['attr' => ['class' => "form-control"]])
            ->add('shipping', TextType::class, ['attr' => ['class' => "form-control"]])
            ->add('image', FileType::class)
            ->add('category', ChoiceType::class, array(
                    'choices' => array(
                        'Cars' => 'Cars',
                        'Music instruments' => 'Music instruments',
                        'Bikes' => 'Bikes',
                        'House Furnitures' => 'House Furniture',
                        'Gaming' => 'Gaming',
                        'Real Estate' => 'Real Estate',
                        'Miscellaneous' => 'Miscellaneous',
                        'Île-de-France' => 'Île-de-France',
                        'Computers' => 'Computers',
                        'Phones' => 'Phones',
                    ),
                    'attr' => array('class' => 'custom-select'))
            )
            ->add('locale', ChoiceType::class, array(
                'choices' => array(
                    'Auvergne-Rhône-Alpes' => 'Auvergne-Rhône-Alpes',
                    'Bourgogne-Franche-Comté' => 'Bourgogne-Franche-Comté',
                    'Bretagne' => 'Bretagne',
                    'Centre-Val de Loire' => 'Centre-Val de Loire',
                    'Corse' => 'Corse',
                    'Grand Est' => 'Grand Est',
                    'Hauts-de-France' => 'Hauts-de-France',
                    'Île-de-France' => 'Île-de-France',
                    'Normandie' => 'Normandie',
                    'Nouvelle-Aquitaine' => 'Nouvelle-Aquitaine',
                    'Occitanie' => 'Occitanie',
                    'Pays de la Loire' => 'Pays de la Loire',
                    'Provence - Alpes - Côte d\'Azur' => 'Provence - Alpes - Côte d\'Azur',
                ),
                'attr' => array('class' => 'custom-select'))
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
