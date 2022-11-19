<?php

namespace App\Controller;

use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class BlogController extends AbstractController
{
    private Greeting $greeting;

    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/{name}', name: 'blog_greeting')]
    public function index($name): Response
    {
        return $this->render('greeting.html.twig', ['message' => $this->greeting->greet($name)]);
    }
}