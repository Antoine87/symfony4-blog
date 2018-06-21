<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods={"GET"}, name="homepage")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, methods={"GET"}, name="homepage_paginated")
     */
    public function index(int $page, PostRepository $postRepository): Response
    {
        $posts = $postRepository->findLatest(4, $page);
        $lastPage = $posts->getNbPages();

        return $this->render('default/homepage.html.twig', compact('posts', 'page', 'lastPage'));
    }
}
