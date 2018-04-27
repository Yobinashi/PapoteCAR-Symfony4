<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RunController extends Controller
{
    /**
     * @Route("/run/add", name="addRun")
     */
    public function addRun()
    {

        return $this->render('run/addRun.html.twig');
    }
}
