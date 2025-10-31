<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Attribute\Route;


final class PostController extends AbstractController
{
    #[Route('/', name: 'app_post')]
    public function defaultAction(Request $request, PostRepository $postRepository): Response
    {
        $post = $postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $post,
        ]);
    }

    #[Route('/post/new', name: 'app_post_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $post = new Post();

        $post->setTitle($request->get('title'));
        $post->setCreated(new \DateTimeImmutable());
        $post->setContent($request->get('content'));

        try {
            $entityManager->persist($post);
            $entityManager->flush();
        } catch (\Exception $e){
            return $this->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return $this->json([
            'success' => true,
            'post' => [
                'title' => $post->getTitle(),
                'created' => $post->getCreated()->format('Y-m-d'),
            ]
        ]);
    }




    #[Route('/delete/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Post $post, Request $request, EntityManagerInterface $entityManager): Response {

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'id' => $request->get('id'),
        ]);
    }

    #[Route('/view/{id}', name: 'app_post_view', methods: ['GET'])]
    public function   view(int $id, Request $request, PostRepository $postRepository): Response {

        $post = $postRepository->findOneBy([
            'id' => $id
        ]);

        return $this->json([
            'success' => true,
            'details' => [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'created' => $post->getCreated()->format('Y-m-d'),
            ]
        ]);
    }
}
