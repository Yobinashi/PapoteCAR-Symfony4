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
            //créer et traite le formulaire d'ajout de trajet
            $form = $this->createForm(RunType::class, $run);
            $form->handleRequest($req);

            if ($form->isSubmitted() && $form->isValid()) {

                //si le form est validé, set le driver avec le current user
//                $departure = $em->getRepository(City::class)->findOneBy(['cityName'=> $form->get('departure')->getData()]);
//                $arrival = $em->getRepository(City::class)->findOneBy(['cityName'=>$form->get('arrival')->getData()]);


                $run->setDriver($this->getUser());
//                $run->setDeparture($departure);
//                $run->setArrival($arrival);

                $em->persist($run);
                $em->flush();

                $this->addFlash('success', 'Votre trajet à bien été ajouté');
                return $this->redirectToRoute('myRun');
            }
            
            return $this->render('run/addRun.html.twig', ["runForm" => $form->createView()]);
        } else{
            return $this->redirectToRoute('login');
        }

}

    /**
     * @Route("/run/delete/{id}", name="deleteRun")
     */
    public function suppRun(EntityManagerInterface $em, $id){
        $run = $em->getRepository(Run::class)->find($id);

        if($this->getUser()) {
            if ($run->getDriver() === $this->getUser()) {
                $em->remove($run);
                $em->flush();
                $this->addFlash('success', 'Votre trajet a bien été annulé');
                return $this->redirectToRoute('myRun');
            }else{
                $this->addFlash('danger', 'Vous ne pouvez pas supprimer ce trajet');
                return $this->redirectToRoute('myRun');
            }
        }else{
            return $this->redirectToRoute('myRun');
        }
    }

    /**
     * @Route("/run/edit/{id}", name="editRun")
     */
    public function editRun(EntityManagerInterface $em, Request $req, $id){
        if($this->getUser()){
            $run = $em->getRepository(Run::class)->find($id);

            if($run->getDriver() === $this->getUser()){

                //créer et traite le formulaire de modification de trajet
                $form = $this->createForm(RunType::class, $run);
                $form->handleRequest($req);

                if($form->isSubmitted() && $form->isValid()){
                    $em->flush();
                    $this->addFlash('success', 'Le trajet à bien été mis à jour');
                    return $this->redirectToRoute('account');
                }
                
                return $this->render('run/addRun.html.twig', ['runForm'=> $form->createView()]);

            }else{
                $this->addFlash('danger', 'Vous ne pouvez pas mettre ce trajet à jour');
                return $this->redirectToRoute('myRun');
            }
        }else{
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/run/{id}", name="detailRun")
     */
    public function detailRun(EntityManagerInterface $em, Request $req, $id){
        $run = $em->getRepository(Run::class)->find($id);
        return $this->render('run/detailRun.html.twig', ['run'=> $run]);
    }

    /**
     * @Route("/runs", name="listRuns")
     */
    public function listRuns(EntityManagerInterface $em){
        $runs = $em->getRepository(Run::class)->findAll();
        return $this->render('tableau/search_run.html.twig', ['runs'=> $runs]);

    }

    /**
     * @Route("/run/reserve/{id}", name="reserveRun")
     */
    public function reserveRun(EntityManagerInterface $em, $id){

        if($this->getUser()){
            $run = $em->getRepository(Run::class)->find($id);

            $run->setPlaces($run->getPlaces()-1);
            $run->addPassenger($this->getUser());
            $em->persist($run);
            $em->flush();
            return $this->redirectToRoute('myRun');
        }else{
            $this->addFlash('warning', 'Inscrivez vous pour réserver');
            return $this->redirectToRoute('login');
        }

    }
    /**
     * @Route("/run/remove/{id}", name="removePlace")
     */
    public function removePlace(EntityManagerInterface $em, $id){

        $run = $em->getRepository(Run::class)->find($id);

        $run->setPlaces($run->getPlaces()+1);
        $run->removePassenger($this->getUser());
        $em->persist($run);
        $em->flush();
        return $this->redirectToRoute('myRun');

    }

}
