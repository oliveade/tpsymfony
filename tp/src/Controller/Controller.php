<?php

Namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/test', name:'admin_list')]
    public function maPage(): Response
    {
        return $this->render('/test.html.twig');
    }
}