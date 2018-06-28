<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/post")
 * @Security("has_role('ROLE_ADMIN')")
 */
class PostController extends Controller
{
    /**
     * @Route("/", methods={"GET"}, name="admin_post_index")
     */
    public function index(PostRepository $postRepository)
    {
        return $this->render('admin/post/index.html.twig', [
            'posts' => $postRepository->findAllWithAuthors()
        ]);
    }

    /**
     * @Route("/new", methods={"GET", "POST"}, name="admin_post_new")
     */
    public function new(Request $request): Response
    {
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, methods={"GET"}, name="admin_post_show")
     */
    public function show(Post $post): Response
    {
    }

    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, methods={"GET", "POST"}, name="admin_post_edit")
     */
    public function edit(Request $request, Post $post): Response
    {
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="admin_post_delete")
     */
    public function delete(Request $request, Post $post, ObjectManager $manager): Response
    {
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('admin_post_index');
    }
}
