<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('app/home.html.twig');
    }

    /**
     * @Route("/tableau-de-bord/trajet-en-cours", name="ridecourt")
     */
    public function rideToCourt()
    {
        return $this->render('tableau/ride_to_court.html.twig');
    }

    
    /**
     * @Route("/tableau-de-bord/rechercher-un-trajet", name="searchride")
     */
    public function searchRide()
    {
        return $this->render('tableau/search_ride.html.twig');
    }
}
