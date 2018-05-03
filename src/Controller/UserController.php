<?php
namespace App\Controller;

use App\Entity\Member;
use App\Entity\Run;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $req, EntityManagerInterface $em, UserPasswordEncoderInterface $enc){
        $member = new Member();

        //créer et traite le formulaire
        $registerForm = $this->createForm(RegisterType::class, $member);
        $registerForm->handleRequest($req);


        if($registerForm->isSubmitted() && $registerForm->isValid()){

            //encode le mdp si le formulaire a bien été traité et est validé
            $encoded= $enc->encodePassword($member, $registerForm->get('password')->getData());
            $member->setPassword($encoded);
            $member->setRoles(["ROLE_USER"]);

            //Upload d'images
            /** @var UploadedFile $file */
            $file = $registerForm->get('picture')->getData();
            $fileName = md5(date('Y-m-d H:i:s:u')).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('img_upload'),
                $fileName
            );

            $member->setPicture($fileName);


            $em->persist($member);
            //ajoute en bdd
            $em->flush();


            //récupére les credentials apres le register, et se log automatiquement
            $token = new UsernamePasswordToken($member, null, 'main', $member->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main', serialize($token));

            //redirecte vers tableau de bord
            return $this->redirectToRoute("ridecourt");
        }
        return $this->render('user/register.html.twig', ["registerForm"=>$registerForm->createView()]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $auth){
        if($this->getUser()){
            return $this->redirectToRoute('ridecourt');
        }
        $error = $auth->getLastAuthenticationError();
        $lastUsername = $auth->getLastUsername();
        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);

    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
    }

    /**
     * @Route("/account", name="account")
     */
    public function account(EntityManagerInterface $em){
        if(!$this->getUser()){
            $this->redirectToRoute('login');
        }

        //trouve tous les trajets ajoutés par le current user qui ne sont pas encore arrivés
        $runs = $em->getRepository(Run::class)->selectRunsByDriversWhereDepartureSupNow($this->getUser());
        return $this->render('user/account.html.twig',['runs'=> $runs]);
    }


    /**
     * @Route("/account/delete", name="suppAccount")
     */
    public function suppAccount(EntityManagerInterface $em){
        if($this->getUser()) {
            //trouve l'utilisateur associé
            $userRepo = $em->getRepository(Member::class);
            $user = $userRepo->find($this->getUser()->getId());

            if ($user->getId() === $this->getUser()->getId()) {


                try {

                    //vide la session en vue de la deconnexion, avant la suppression du user
                    $session = $this->get('session');
                    $session = new Session();
                    $session->invalidate();

                    //supprime l'utilisateur
                    $em->remove($this->getUser());
                    $em->flush();

                    $this->addFlash('success', 'Account successfully deleted');
                    return $this->redirectToRoute('home');

                } catch (\PDOException $e) {
                    return $this->redirectToRoute('account');
                }
            }
        }else{
            return $this->redirectToRoute('home');
        }


    }

    /**
     * @Route("/account/edit", name="editAccount")
     */
    public function editAccount(EntityManagerInterface $em, Request $req, UserPasswordEncoderInterface $enc)
    {
        if($this->getUser()){

            //trouve l'user à éditer et hydrate une variable $member avec les info
            $member = $em->getRepository(Member::class)->find($this->getUser()->getId());

            //donne au formulaire les infos de $member afin de préremplir les champs et traite le formulaire
            $registerForm = $this->createForm(RegisterType::class, $member);
            $registerForm->handleRequest($req);


                if($registerForm->isSubmitted() && $registerForm->isValid()){

                    //si le user a rempli le champ "password", le change
                    //s'il n'a pas rempli le champs, le laisse comme à l'origine
                    if(!$registerForm->get('password')->getData() === null){
                        $encoded= $enc->encodePassword($member, $registerForm->get('password')->getData());
                        $member->setPassword($encoded);

                    }

                    $em->flush();
                    return $this->redirectToRoute("home");
                }

                return $this->render('user/register.html.twig', ["registerForm"=>$registerForm->createView()]);
            }else{
                return $this->redirectToRoute('home');
            }

    }

    /**
     * @Route("/users", name="users")
     */
    public function userList(EntityManagerInterface $em){
        $users = $em->getRepository(Member::class)->findAll();

        return $this->render('user/list.html.twig', ['users' => $users]);


    }

    /**
     * @Route("/user/profile/{id}", name="userProfile")
     */
    public function userProfile($id, EntityManagerInterface $em){
        $user = $em->getRepository(Member::class)->find($id);
        $runs = $em->getRepository(Run::class)->selectRunsByDriversWhereDepartureSupNow($user);
        if($this->getUser() && $this->getUser()->getId() == $id){
            return $this->redirectToRoute('account');
        }else{
            return $this->render('user/userProfile.html.twig', ['user'=>$user, 'runs'=> $runs]);
        }

    }
}