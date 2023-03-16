<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $years = range($y = date('Y'), $y + 10);

        $builder
            ->add('name', null, [
                'label' => 'Nom',
            ])
            ->add('description')
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'divisor' => 100,
            ])
            // ->add('createdAt')
            ->add('startAt', null, [
                'label' => 'Date de début',
                'years' => $years,
            ])
            ->add('endAt', null, [
                'label' => 'Date de fin',
                'years' => $years,
            ])
            ->add('poster', null, [
                'label' => 'Image',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
