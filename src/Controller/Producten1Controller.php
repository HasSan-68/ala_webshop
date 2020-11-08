<?php

namespace App\Controller;

use App\Entity\Producten1;
use App\Form\Producten1Type;
use App\Repository\ProductenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producten1")
 */
class Producten1Controller extends AbstractController
{
    /**
     * @Route("/", name="producten1_index", methods={"GET"})
     */
    public function index(ProductenRepository $productenRepository): Response
    {
        return $this->render('producten1/index.html.twig', [
            'producten1s' => $productenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="producten1_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producten1 = new Producten1();
        $form = $this->createForm(Producten1Type::class, $producten1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producten1);
            $entityManager->flush();

            return $this->redirectToRoute('producten1_index');
        }

        return $this->render('producten1/new.html.twig', [
            'producten1' => $producten1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producten1_show", methods={"GET"})
     */
    public function show(Producten1 $producten1): Response
    {
        return $this->render('producten1/show.html.twig', [
            'producten1' => $producten1,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="producten1_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Producten1 $producten1): Response
    {
        $form = $this->createForm(Producten1Type::class, $producten1);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producten1_index');
        }

        return $this->render('producten1/edit.html.twig', [
            'producten1' => $producten1,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producten1_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Producten1 $producten1): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producten1->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producten1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producten1_index');
    }
}
