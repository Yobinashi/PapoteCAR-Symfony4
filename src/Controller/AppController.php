<?php

namespace App\Controller;

use App\Entity\Run;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/tableau-de-bord/trajet-en-cours", name="myRun")
     */
    public function rideToCourt(EntityManagerInterface $em)
    {
        $runs = $em->getRepository(Run::class)->selectRunsByDriversWhereDepartureSupNow($this->getUser());
        return $this->render('tableau/my_run.html.twig', ['runs'=>$runs]);
    }

    
    /**
     * @Route("/tableau-de-bord/rechercher-un-trajet", name="searchRun")
     */
    public function searchRide(EntityManagerInterface $em)
    {
        $runs = $em->getRepository(Run::class)->selectRunsByDriversWhereDepartureSupNow($this->getUser());
        return $this->render('tableau/search_run.html.twig', ['runs'=>$runs]);
    }


}
