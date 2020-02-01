<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BlogType
 * @package App\Form
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('thumb_file', FileType::class, [
                'required' => false,
                'label' => 'thumb'
            ])
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
            ->add('content', TextareaType::class)
            ->add('is_online', CheckboxType::class, [
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
