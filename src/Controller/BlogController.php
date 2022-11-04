<?php

namespace App\Controller;

use App\Service\Greeting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/greeting', name: 'blog_greeting')]
    public function index(Request $request): Response
    {
        return $this->render('greeting.html.twig', ['message' => $this->greeting->greet($request->get('name'))]);
    }
}