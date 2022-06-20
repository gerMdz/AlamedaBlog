<?php

namespace App\Action\Post;


use App\Repository\PostRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Serializer;

class LastPost
{


    private PostRepository $postRepository;


    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {

        $this->postRepository = $postRepository;
    }

    /**
     */
    public function __invoke()
    {
        return new JsonResponse($this->postRepository->findLastPost());
    }
}