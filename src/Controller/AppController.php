<?php

namespace App\Controller;

use App\Entity\Run;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


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
     * @Method({"GET", "POST"})
     */
    public function searchRide(EntityManagerInterface $em, Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $departure = $request->request->get('departure');
            $arrival = $request->request->get('arrival');
            $dateEnter = $request->request->get('date');
            $date = new \DateTime($dateEnter);
        } else {
            $departure = "";
            $arrival = "";
            $date = new \DateTime('now 00:00');
        }

        $runs = $em->getRepository(Run::class)->searchRun($departure, $arrival, $date);
        return $this->render('tableau/search_run.html.twig', ['runs'=>$runs]);


    }


}
