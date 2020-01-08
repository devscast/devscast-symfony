<?php

namespace App\Form;

use App\Entity\GlobalMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlobalMessageType extends AbstractType
{
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
