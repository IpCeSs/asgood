<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HomeController extends Controller
{


    /**
     * @Route("/home", name="home")
     */
    public function home(AdRepository $adRepository, Request $request)
    {



        $ads = $adRepository->findAll();


        return $this->render('home/home.html.twig', ['ads' => $ads]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }
}
