<?php

namespace App\Controller;

use App\Entity\Run;
use App\Form\RunType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RunController extends Controller
{
    /**
     * @Route("/run/add", name="addRun")
     */
    public function addRun(Request $req, EntityManagerInterface $em)
    {
        if ($this->getUser()) {
            $run = new Run();
            $form = $this->createForm(RunType::class, $run);
            $form->handleRequest($req);

            if ($form->isSubmitted() && $form->isValid()) {
                $run->setDriver($this->getUser());
                $em->persist($run);
                $em->flush();

                $this->addFlash('success', 'Your run has been successfully added');
                return $this->redirectToRoute('account');
            }

            return $this->render('run/addRun.html.twig', ["runForm" => $form->createView()]);
        } else{
            return $this->redirectToRoute('home');
        }
}
}
