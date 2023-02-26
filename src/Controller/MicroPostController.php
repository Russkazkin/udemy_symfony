<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/micro-post')]
class MicroPostController extends AbstractController
{
    #[Route('/', name: 'micro_post_index')]
    public function index(MicroPostRepository $microPostRepository): Response
    {
        return $this->render('micro_post/index.html.twig', ['posts' => $microPostRepository->findBy([], ['time' => 'DESC'])]);
    }

    #[Route('/add', 'micro_post_add')]
    public function add(Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, RouterInterface $router): Response
    {
        $microPost = new MicroPost();
        $microPost->setTime(new DateTime());

        $form = $formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($microPost);
            $entityManager->flush();
            return new RedirectResponse($router->generate('micro_post_index'));
        }
        return $this->render('micro_post/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/edit/{post}', name: 'micro_post_edit')]
    public function edit(MicroPost $post, Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, RouterInterface $router): Response
    {
        $form = $formFactory->create(MicroPostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return new RedirectResponse($router->generate('micro_post_index'));
        }
        return $this->render('micro_post/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{post}', name: 'micro_post_post')]
    public function post(MicroPost $post): Response
    {
        return $this->render('micro_post/post.html.twig', ['post' => $post]);
    }
}
