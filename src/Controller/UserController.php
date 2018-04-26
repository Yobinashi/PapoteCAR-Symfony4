<?php
namespace App\Controller;
use App\Entity\Member;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $req, EntityManagerInterface $em, UserPasswordEncoderInterface $enc){
        $member = new Member();
        $registerForm = $this->createForm(RegisterType::class, $member);
        $registerForm->handleRequest($req);
        $encoded= $enc->encodePassword($member, $member->getPassword());
        $member->setPassword($encoded);
        $member->setRoles(["ROLE_USER"]);
        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $em->persist($member);
            $em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render('user/register.html.twig', ["registerForm"=>$registerForm->createView()]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $auth){
        if($this->getUser()){
            return $this->redirectToRoute('account');
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
    public function account(){
        if(!$this->getUser()){
            $this->redirectToRoute('login');
        }
        return $this->render('user/account.html.twig');
    }


    /**
     * @Route("/account/delete", name="suppAccount")
     */
    public function suppAccount(EntityManagerInterface $em){

    $userRepo = $em->getRepository(Member::class);
    $user = $userRepo->find($this->getUser()->getId());

    if($user->getId() === $this->getUser()->getId()) {


        try {

            $session = $this->get('session');
            $session = new Session();
            $session->invalidate();

            $em->remove($this->getUser());
            $em->flush();

            $this->addFlash('success', 'Account successfully deleted');
            return $this->redirectToRoute('home');

        } catch (\PDOException $e) {
            return $this->redirectToRoute('account');
        }
    }


    }

    /**
     * @Route("/account/edit", name="editAccount")
     */
    public function editAccount(EntityManagerInterface $em, Request $req, UserPasswordEncoderInterface $enc){

        if($this->getUser()){
            $member = $this->getUser();

            $registerForm = $this->createForm(RegisterType::class, $member);
            $registerForm->handleRequest($req);
            $encoded= $enc->encodePassword($member, $member->getPassword());
            $member->setPassword($encoded);

            if($registerForm->isSubmitted() && $registerForm->isValid()){
                $em->persist($member);
                $em->flush();
                return $this->redirectToRoute("home");
            }
        }else{
            return $this->redirectToRoute('home');
        }



        return $this->render('user/register.html.twig', ["registerForm"=>$registerForm->createView()]);
    }
}