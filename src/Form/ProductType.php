<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actif')
            ->add('name')
            ->add('slug')
            /* ->add('category',EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name'
            ]) */
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('u')
                                ->where('u.actif = 1')
                                ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'placeholder' => null,
                'label'=> 'Catégorie',
            ])
            ->add('marque', ChoiceType::class,[
                'choices' => [
                    'Marque 1' => 'Marque 1',
                    'Marque 2' => 'Marque 2', 
                    'Marque 3' => 'Marque 3']
            ])
            ->add('description', TextareaType::class , [
                'attr' => ['class' => 'tinymce']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'translation_domain' => 'forms'
        ]);
    }

}
