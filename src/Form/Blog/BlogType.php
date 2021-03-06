<?php

namespace App\Form\Blog;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class,  [
            'attr' => ['class' => 'form-control'],
            'label' => 'Заголовок',
        ])
        ->add('slug', TextType::class,  [
            'attr' => ['class' => 'form-control'],
            'label' => 'URI',
        ])
        ->add('description', TextareaType::class,  [
            'attr' => ['class' => 'form-control'],
            'label' => 'Описание',
            'required' => false,
        ])
        ->add('save', SubmitType::class,  [
            'attr' => ['class' => 'btn btn-success'],
            'label' => 'Отправить',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}