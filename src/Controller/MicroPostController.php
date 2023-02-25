<?php

namespace App\Controller;

use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/micro-post')]
class MicroPostController extends AbstractController
{
    #[Route('/', name: 'micro_post_index')]
    public function index(MicroPostRepository $microPostRepository): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $microPostRepository->findAll(),
            'controller_name' => 'MicroPostController',
        ]);
    }

    #[Route('/add', 'micro_post_add')]
    public function add()
    {
        return $this->render('micro_post/add.html.twig');
    }
}
