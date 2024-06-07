<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddImageController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/add/image', name: 'app_add_image')]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageFormType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('path')->getData();
            if ($file) {
                $newFilename = uniqid().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                $image->setPath($newFilename);
            }

            $currentUser = $this->security->getUser();
            $image->setUserId($currentUser);

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_add_image');
        }

        return $this->render('add_image/index.html.twig', [
            'form' => $form->createView(),
            'error' => null,
        ]);
    }
}
