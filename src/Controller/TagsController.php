<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{

    private TagRepository $tagsRepository;

    /**
     * @param TagRepository $tagsRepository
     */
    public function __construct(TagRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * @Route("/tags", name="app_tags")
     */
    public function index(): Response
    {
        $tags = $this->tagsRepository->getTagsActive();

        return $this->render('tags/index.html.twig', [
            'controller_name' => 'TagsController',
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/tags/activas", name="app_api_tags")
     */
    public function tagsActivas(): Response
    {
        $tags = $this->tagsRepository->getTagsActive();
        return new JsonResponse($tags);

    }
}
