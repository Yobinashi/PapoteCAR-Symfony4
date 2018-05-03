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
<<<<<<< HEAD
            //departure et arrival sont des objets de type City. EntityType demande a symfo d'aller chercher en bdd
                //toutes les entrées de City et les display en 'select'. Choice_label permet de choisir ce que va
                //afficher le select a l'utilisateur, ici, le cityName
            ->add('departure', TextType::class)
            ->add('arrival', TextType::class)
        //new DateTime permet de mettre une valeur par defaut égale à l'actuelle sur le formulaire
=======
            ->add('departure', TextType::class)
            ->add('arrival', TextType::class)
            //new DateTime permet de mettre une valeur par defaut égale à l'actuelle sur le formulaire
>>>>>>> 92b0d199ecb616321d00af2f6ebfe03b51c71b20
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
