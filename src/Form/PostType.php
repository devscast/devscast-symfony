<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('thumb_url', FileType::class, [
                'label' => 'thumb'
            ])
            ->add('video_url')
            ->add('is_online', CheckboxType::class, [
                'required' => false
            ])
            ->add('duration')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'required' => true,
                'multiple' => false,
                'choice_label' => 'name'
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'required' => false,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            ->add('description', TextareaType::class, [
                'required' => false
            ])
            ->add('content', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
