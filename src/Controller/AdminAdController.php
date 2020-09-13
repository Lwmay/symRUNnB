<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads", name="admin_ads_index")
     * @param AdRepository $repository
     * @return Response
     */
    public function index(AdRepository $repository)
    {
        return $this->render('admin/ad/index.html.twig', [
            'ads' => $repository->findAll(),
        ]);
    }

    /**
     * Permet d'afficher une annonce
     *
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     *
     * @param Ad $ad
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Ad $ad, Request $request, EntityManagerInterface $manager) {
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce a bien été modifiée"
            );
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     *
     * @Route ("/admin/ads/{id}/delete", name="admin_ads_delete")
     *
     * @param Ad $ad
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Ad $ad, EntityManagerInterface $manager) {
        if(count($ad->getBookings()) > 0) {
            $this->addFlash(
                "warning",
                "Vous ne pouvez pas supprimer l'annonce {$ad->getTitle()} car elle possède des annonces."
            );
        } else {
            $manager->remove($ad);
            $manager->flush();

            $this->addFlash(
                "sucess",
                "L'annonce {$ad->getTitle()} a bien été supprimée."
            );
        };

        return $this->redirectToRoute('admin_ads_index');
    }
}
