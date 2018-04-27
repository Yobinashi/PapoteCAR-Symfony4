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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //new DateTime permet de mettre une valeur par defaut égale à l'actuelle sur le formulaire
            ->add('departureSchedule', DateTimeType::class, ['data'=> new \DateTime()])
            //créé un select ['affichage' => 'valeur']
            ->add('places', ChoiceType::class, ['choices'=>[
                '1'=> 1,
                '2'=> 2,
                '3'=> 3,
                '4'=> 4
                                                                            ]])
            ->add('price', NumberType::class)
            //departure et arrival sont des objets de type City. EntityType demande a symfo d'aller chercher en bdd
                //toutes les entrées de City et les display en 'select'. Choice_label permet de choisir ce que va
                //afficher le select a l'utilisateur, ici, le cityName
            ->add('departure', EntityType::class,['class'=> City::class,
                'choice_label'=> 'cityName'])
            ->add('arrival',EntityType::class,['class'=> City::class,
                'choice_label'=> 'cityName'])
            ->add('submit', SubmitType::class, ["label"=>"Propose your run"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Run::class,
        ]);
    }
}
