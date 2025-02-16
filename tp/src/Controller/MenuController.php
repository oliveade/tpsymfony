<?php
namespace App\Controller;

use App\Form\MenuType;
use App\Service\MistralAiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu/generate', name: 'menu_generate')]
    public function generateMenu(Request $request, MistralAiService $mistralAiService): Response
    {
        $form = $this->createForm(MenuType::class);
        $form->handleRequest($request);

        $menu = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $menu = $mistralAiService->generateMenu($data['cuisine'], $data['nbPlats']);
        }

        return $this->render('menu/generate.html.twig', [
            'form' => $form->createView(),
            'menu' => $menu,
        ]);
    }
}
