<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage tags in the backend.
 *
 *
 * See http://knpbundles.com/keyword/admin
 *
 * @Route("/admin/tag")
 * @IsGranted("ROLE_ESCRITOR")
 *
 * @author GerMdz <gerardo.montivero@gmail.com>
 */
class TagController extends AbstractController
{
    /**
     * @Route("/", name="app_tag_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tags = $entityManager
            ->getRepository(Tag::class)
            ->findAll();

        return $this->render('admin/tag/index.html.twig', [
            'tags' => $tags,
        ]);
    }

    /**
     * @Route("/new", name="app_tag_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tag);
            $entityManager->flush();

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tag_show", methods={"GET"})
     */
    public function show(Tag $tag): Response
    {
        return $this->render('admin/tag/show.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_tag_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
