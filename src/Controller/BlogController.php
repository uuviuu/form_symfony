<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("", name="all", methods={"GET","HEAD"})
     */
    public function all(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Blog::class);
        $posts = $repository->findAll();
        foreach ($posts as $post) {
            return new Response('Check out this great data: ' . $post->getId());
        }
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(ManagerRegistry $doctrine, ValidatorInterface $validator): Response
    {
        $entityManager = $doctrine->getManager();
        $post = new Blog();
        $post->setTitle('Keyboard');
        $post->setSlug('keyboard');
        $post->setDescription('Ergonomic and stylish!');

        $errors = $validator->validate($post);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($post);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('Saved new product with id ' . $post->getId());
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET","HEAD"})
     */
    public function show(Blog $post): Response
    {
        return new Response('Check out this great data: ' . $post->getTitle());
    }

    /**
     * @Route("/edit/{slug}", name="update")
     */
    public function update(ManagerRegistry $doctrine, Blog $post): Response
    {
        $entityManager = $doctrine->getManager();
        $data = $entityManager->getRepository(Blog::class)->find($post);

        $data->setTitle('New data title!');
        $entityManager->flush();
        return $this->redirectToRoute('blog_show', [
            'slug' => $data->getSlug()
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="delete")
     */
    public function delete(ManagerRegistry $doctrine, Blog $post): Response
    {
        $entityManager = $doctrine->getManager();
        $data = $entityManager->getRepository(Blog::class)->find($post);
        $entityManager->remove($data);
        $entityManager->flush();
        return $this->redirectToRoute('blog_all');
    }
}
