<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\Blog\BlogType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * Выводит все посты из таблицы Blog
     * @Route("", name="all", methods={"GET"})
     */
    public function all(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Blog::class);
        $posts = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * Создает новый пост в таблице Blog
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Blog();
        $form = $this->createForm(BlogType::class, $post);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('blog_all');
        }

        return $this->renderForm('blog/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Blog $post): Response
    {
        return $this->render('blog/detail.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Blog $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogType::class, $post);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('blog_edit', ['slug' => $post->getSlug()]);
        }
        return $this->render('blog/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}/delete", name="delete", methods={"POST"})
     */
    public function delete(Blog $post, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($post);
        $entityManager->flush();
        $this->addFlash('success', 'post.deleted_successfully');
           
        return $this->redirectToRoute('blog_all');
    }
}
