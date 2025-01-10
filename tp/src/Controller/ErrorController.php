<?php

Namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/bannedPage', name:'app_banned')]
    public function errorPage(): Response
    {
        return $this->render('/error.html.twig');
    }
  
}