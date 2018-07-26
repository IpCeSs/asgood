<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Mail\MailService;
use App\Repository\AdRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class AdApiController
 * @package App\Controller
 * @Route("/api")
 */
class AdApiController extends Controller
{
    /**
     * @Method ({"GET"})
     * @Route("/ads", name="ads")
     */
    public function allAds(AdRepository $adRepository)
    {
        $ads = $adRepository->findAll();

        return new JsonResponse($ads);
    }

    /**
     * @Method ({"GET"})
     * @Route("/ad/{ad}", name="OneAD")
     * @throws \Exception
     */
    public function findOne(Ad $ad)
    {
        if ($ad->getId()) {
            return new JsonResponse($ad);
        } else {
            return new JsonResponse('cette annonce n\existe pas');
        }
    }


    /**
     *
     * @Route ("/delete/ad/{ad}", name="delete")
     */
    public function delete(Ad $ad, MailService $mailer)
    {
        if (!$this->isGranted('edit', $ad)) {
            return $this->redirectToRoute("home");
        } else {
            $admin = $this->getUser();
            $em = $this->getDoctrine()->getManager();

            $fileSystem = new Filesystem();
            $filename = $ad->getImage();
            $fileSystem->remove($this->get('kernel')->getProjectDir() . '/public/uploads/images/' . $filename);

            $em->remove($ad);
            $em->flush();


            if ($ad->getUser()->getId() != $admin->getId()) {
                $mailer->sendEmailAdDeletionByAdmin($admin, $ad->getUser(), $ad);
            }
            return new JsonResponse('Annonce supprimée', Response::HTTP_OK);
        }
    }


    /**
     * @Method({"GET"})
     * @Route("/search")
     *
     */
    public function searchResults(Request $request, AdRepository $adRepository)
    {
        $form = $this->createFormBuilder()
            ->add('search', TextType::class, ['label' => ' '])
            ->add("save", SubmitType::class, ['label' => 'Search', 'attr' => ['class' => 'btn btn-outline-info center-block']])
            ->getForm();
        $form->handleRequest($request);

        $searchBoxValue = $form->get('search')->getData();
        $results = $adRepository->findByTitle($searchBoxValue);
        dump($results);

        return $this->render("ad/search.html.twig", ["form" => $form->createView(), 'results' => $results]);
    }

}
