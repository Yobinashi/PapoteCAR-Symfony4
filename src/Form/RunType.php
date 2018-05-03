<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Run;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', TextType::class, ['mapped' => false])
            ->add('arrival', TextType::class, ['mapped' => false])
            ->add('departureSchedule', DateTimeType::class, ['data'=> new \DateTime()])
            //créé un select ['affichage' => 'valeur']
            ->add('places', ChoiceType::class, ['choices'=>[
                '1'=> 1,
                '2'=> 2,
                '3'=> 3,
                '4'=> 4
            ]])
            ->add('price', NumberType::class)
            ->add('submit', SubmitType::class, ["label"=>"Proposer le trajet"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Run::class,
        ]);
    }
}
