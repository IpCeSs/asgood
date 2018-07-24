<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/register", name="user_registration")
     */

    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->add("save", SubmitType::class, ["label" => "Create account"]);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //to send an email to the new user to confirm his registration
            $message = (new \Swift_Message('Welcome to AsGoodAsNew !'))
                ->setFrom('ceciliapigeolet@homail.fr')
                ->setTo($user->getEmail())
                ->setBody('You successfully signed up to AsGoodAsNew ! We are glad to have you with us ! You can now go find the best deals of your region!', 'text/html');

            $mailer->send($message);

            return $this->redirectToRoute('login', ["userName"=> $user->getUsername()]);

        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route ("/update/{user}", name="user_update")
     */
    public function update(EntityManagerInterface $em, User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $user=$this->getUser();
        $form = $this->createForm(UserTYpe::class, $user)->add('save', SubmitType::class, ["label" => "Update"]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);


            $em->flush();
            return $this->redirect("/{_locale}/home");
        }
        return $this->render("/user/update.html.twig", ["form" => $form->createView()]);
    }

}
