<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods={"GET"}, name="post_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, methods={"GET"}, name="post_index_paginated")
     */
    public function index(int $page, PostRepository $postRepository): Response
    {
        $posts = $postRepository->findLatestPaginated(5, $page);
        $lastPage = $posts->getNbPages();

        return $this->render('post/index.html.twig', compact('posts', 'page', 'lastPage'));
    }

    /**
     * @Route("/{slug}", methods={"GET"}, name="post_show")
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', ['post' => $post]);
    }
}
