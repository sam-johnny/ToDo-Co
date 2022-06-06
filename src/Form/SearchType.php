<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 30/05/2022
 * Time: 23:24
 */

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['placeholder' => 'Rechercher']
            ])
            ->add('done', CheckboxType::class, [
                'label' => 'Fait',
                'required' => false
            ])
            ->add('toDo', CheckboxType::class, [
                'label' => 'Non fait',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * Pour avoir une URL 'propre'
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}