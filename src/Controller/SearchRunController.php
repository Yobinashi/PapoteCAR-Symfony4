<?php

namespace App\Controller;

use App\Entity\Run;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SearchRunController extends Controller
{

    /**
     * @Route("/tableau-de-bord/rechercher-un-trajet/recherche", name="searchRunAjax")
     * @Method({"GET", "POST"})
     */
    public function searchRun(Request $request)
    {
        var_dump($request);
        if($request->isXmlHttpRequest()) {
            $departure = $request->request->get('departure');
            $arrival = $request->request->get('arrival');
            $dateEnter = $request->request->get('date');
            $date = new \DateTime($dateEnter);

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository(Run::class);

            $runs = $repository->searchRun($departure, $arrival, $date);
            return $this->render('tableau/search_run.html.twig', ['runs' => $runs]);
        }

    }
}
