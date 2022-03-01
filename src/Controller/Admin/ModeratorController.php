<?php

namespace App\Controller\Admin;

use App\Entity\Moderator;
use App\Form\ModeratorType;
use App\Repository\ModeratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/moderator")
 */
class ModeratorController extends AbstractController
{
    /**
     * @Route("/", name="app_moderator_index", methods={"GET"})
     */
    public function index(ModeratorRepository $moderatorRepository): Response
    {
        return $this->render('moderator/index.html.twig', [
            'moderators' => $moderatorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_moderator_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ModeratorRepository $moderatorRepository): Response
    {
        $moderator = new Moderator();
        $form = $this->createForm(ModeratorType::class, $moderator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moderatorRepository->add($moderator);
            return $this->redirectToRoute('app_moderator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moderator/new.html.twig', [
            'moderator' => $moderator,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_moderator_show", methods={"GET"})
     */
    public function show(Moderator $moderator): Response
    {
        return $this->render('moderator/show.html.twig', [
            'moderator' => $moderator,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_moderator_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Moderator $moderator, ModeratorRepository $moderatorRepository): Response
    {
        $form = $this->createForm(ModeratorType::class, $moderator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moderatorRepository->add($moderator);
            return $this->redirectToRoute('app_moderator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moderator/edit.html.twig', [
            'moderator' => $moderator,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_moderator_delete", methods={"POST"})
     */
    public function delete(Request $request, Moderator $moderator, ModeratorRepository $moderatorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moderator->getId(), $request->request->get('_token'))) {
            $moderatorRepository->remove($moderator);
        }

        return $this->redirectToRoute('app_moderator_index', [], Response::HTTP_SEE_OTHER);
    }
}
