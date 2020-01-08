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


use App\Data\ContactData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 * @package App\Form
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class ContactType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false
            ])
            ->add('email', EmailType::class, [
                'label' => false
            ])
            ->add('subject', TextType::class, [
                'label' => false
            ])
            ->add('message', TextareaType::class, [
                'label' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactData::class,
        ]);
    }
}
