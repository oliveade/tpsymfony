<?php

Namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('/index.html.twig');
    }
    #[Route('/test', name:'app_admin')]
    public function maPage(): Response
    {
        return $this->render('/home.html.twig');
    }
    #[Route('/adminPage', name:'app_admin_connection')]
    public function adminDarshboard(): Response
    {
        return $this->render('/admin.html.twig');
    }
}