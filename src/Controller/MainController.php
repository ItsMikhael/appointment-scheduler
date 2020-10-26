<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('user-main');
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
