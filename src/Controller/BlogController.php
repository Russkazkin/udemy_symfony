<?php

namespace App\Controller;

use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'blog_index')]
    public function index(SessionInterface $session): Response
    {
        return $this->render('blog/index.html.twig', ['posts' => $session->get('posts')]);
    }

    /**
     * @throws Exception
     */
    #[Route('/add', name: 'blog_add')]
    public function add(SessionInterface $session, RouterInterface $router): RedirectResponse
    {
        $posts = $session->get('posts');
        $posts[uniqid('post', true)] = [
            'title' => 'A random title ' . random_int(1, 500),
            'text' => 'Some random text nr ' . random_int(1, 500),
            'date' => new DateTime(),
        ];
        $session->set('posts', $posts);
        return new RedirectResponse($router->generate('blog_index'));
    }

    #[Route('/show/{id}', name: 'blog_show')]
    public function show(SessionInterface $session, $id): Response
    {
        $posts = $session->get('posts');
        if (!$posts || !isset($posts[$id])) {
            throw new NotFoundHttpException('Post not found');
        }
        return $this->render('blog/post.html.twig', ['id' => $id, 'post' => $posts[$id]]);
    }
}