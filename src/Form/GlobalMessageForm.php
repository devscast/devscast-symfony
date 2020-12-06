<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Form;

use App\Entity\GlobalMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GlobalMessageForm
 * @package App\Form
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class GlobalMessageForm extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => $this->getTypeChoice()
            ])
            ->add('state', CheckboxType::class, [
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
            'data_class' => GlobalMessage::class,
        ]);
    }

    /**
     * @return array
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function getTypeChoice()
    {
        return [
            'warning' => 'warning',
            'success' => 'success',
            'danger' => 'danger',
            'info' => 'info'
        ];
    }
}
