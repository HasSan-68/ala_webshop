<?php

namespace App\Controller;

use App\Entity\Producten;
use App\Form\ProductenType;
use App\Repository\ProductenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producten")
 */
class ProductenController extends AbstractController
{
    /**
     * @Route("/", name="producten_index", methods={"GET"})
     */
    public function index(ProductenRepository $productenRepository): Response
    {
        return $this->render('producten/index.html.twig', [
            'productens' => $productenRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="producten_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producten = new Producten();
        $form = $this->createForm(ProductenType::class, $producten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producten);
            $entityManager->flush();

            return $this->redirectToRoute('producten_index');
        }

        return $this->render('producten/new.html.twig', [
            'producten' => $producten,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producten_show", methods={"GET"})
     */
    public function show(Producten $producten): Response
    {
        return $this->render('producten/show.html.twig', [
            'producten' => $producten,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="producten_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Producten $producten): Response
    {
        $form = $this->createForm(ProductenType::class, $producten);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producten_index');
        }

        return $this->render('producten/edit.html.twig', [
            'producten' => $producten,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producten_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Producten $producten): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producten->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producten);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producten_index');
    }
}
