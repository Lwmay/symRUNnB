<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
        $repo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }


    /**
     * Permet de créer une annonce
     * @Route("/ads/new", name="ads_create")
     *
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {

        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        $this->addFlash(
            'sucess',
            "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
        );

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ad);
            $manager->flush();

            return $this->redirectToRoute('ads_show', [
               'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher une seule annonce
     * @param $slug
     * @param AdRepository $adRepository
     * @Route("/ads/{slug}", name="ads_show")
     *
     * @return Response
     */
    public function show($slug, Ad $ad) {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }

}
