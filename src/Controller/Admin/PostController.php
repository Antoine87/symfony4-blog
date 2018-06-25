<?php

namespace App\Controller\Admin;

use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
    /**
     * @Route("/admin/post", name="admin_post")
     */
    public function index(PostRepository $postRepository)
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAllWithAuthors()
        ]);
    }
}
