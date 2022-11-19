<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

    #[Route('/add', name: 'blog_add')]
    public function add()
    {

    }
    #[Route('/show/{id}', name: 'blog_show')]
    public function show($id)
    {

    }
}