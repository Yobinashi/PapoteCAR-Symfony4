<?php

namespace App\Form;

use App\Entity\Run;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departureSchedule', DateTimeType::class)
            ->add('places', ChoiceType::class, ['choices'=>[
                '1'=> 1,
                '2'=> 2,
                '3'=> 3,
                '4'=> 4
                                                                            ]])
            ->add('price', NumberType::class)
            ->add('driver', EntityType::class)
            ->add('departure')
            ->add('arrival')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Run::class,
        ]);
    }
}
