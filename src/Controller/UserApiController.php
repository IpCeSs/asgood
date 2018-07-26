<?php

namespace App\Controller;


use App\Entity\User;

use App\Mail\MailService;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/api", name="user_api")
 */
class UserApiController extends Controller
{

    /**
     * @Method({"POST"})
     * @Route("/signup", name="user_tration")
     */

    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailService $mailer)
    {
        $user = new User();

        $firsName = $request->get('firsName');
        $lastName = $request->get('lastname');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $password = $passwordEncoder->encodePassword($user, $user->getPassword());


        if (empty($firsName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
            return new JsonResponse("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        } else {
            $user->setFirsName($firsName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setPassword($password);


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $mailer->sendMailOnRegisterOK($user);
            return new JsonResponse($user, Response::HTTP_OK);
        }

    }

//
//    /**
//     * @Method({"GET"})
//     * @Route("/login", name="loginApi")
//     */
//    public function login(Request $request, PasswordEncoderInterface $encoder)
//    {
//
//        $username=$request->get('username');
//        $plainPassword=$request->get('password');
//
//
//        $validPassword = $encoder->isPasswordValid(
//            $username->getPassword(), // the encoded password
//            $plainPassword,       // the submitted password
//            $username->getSalt());
//
//
//
//            return new JsonResponse($validPassword, Response::HTTP_OK);
//
////        } else {
////            return new JsonResponse("pas ok", Response::HTTP_PRECONDITION_FAILED);
////        }
//    }

    /**
     * @Method({"PUT"})
     * @Route ("/update/user/{user}", name="update_api")
     */
    public function update(EntityManagerInterface $em, User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {


        // $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        if (empty($user)) {
            return new JsonResponse("user not found", Response::HTTP_NOT_FOUND);

        }

        $em = $this->getDoctrine()->getManager();
        $firsName = $request->get('firsName');
        $lastName = $request->get('lastname');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $password = $passwordEncoder->encodePassword($user, $user->getPassword());

        if (!empty($firsName) || !empty($lastName) || !empty($email) || !empty($phone) || !empty($password)) {
            $user->setFirsName($firsName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setPassword($password);


            $em->flush();
            return new JsonResponse("User Updated Successfully", Response::HTTP_OK);
        } else {
            return new JsonResponse("Fields should not be blank", Response::HTTP_NOT_ACCEPTABLE);
        }
    }


}
