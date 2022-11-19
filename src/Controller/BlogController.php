<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class BlogController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    #[Route('/', name: 'blog_index')]
    public function index(): Response
    {
        return $this->render('blot/index.html.twig', ['posts' => $this->session->get('posts')]);
    }

    /**
     * @throws Exception
     */
    #[Route('/add', name: 'blog_add')]
    public function add(): void
    {
        $posts = $this->session->get('posts');
        $posts[uniqid('post', true)] = [
            'title' => 'A random title ' . random_int(1, 500),
            'text' => 'Some random text nr ' . random_int(1, 500),
        ];
        $this->session->set('posts', $posts);
    }

    #[Route('/show/{id}', name: 'blog_show')]
    public function show($id): Response
    {
        $posts = $this->session->get('posts');
        if (!$posts || !isset($posts[$id])) {
            throw new NotFoundHttpException('Post not found');
        }
        return $this->render('blog/post.html.twig', ['id' => $id, 'post' => $posts[$id]]);
    }
}