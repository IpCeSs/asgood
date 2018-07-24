<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('shipping')
            ->add('image', FileType::class, ['data_class'=>null, 'required' => false ], array('label'=>'Image (JPG)'))

            ->add('category', ChoiceType::class, (array(
                'choices' => (array(
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
                ))
            )))
            ->add('locale', ChoiceType::class, (array(
                'choices' => (array(
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
                ))
            )));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
