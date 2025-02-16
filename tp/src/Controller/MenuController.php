<?php
namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Service\MistralAiService;
use Doctrine\ORM\EntityManagerInterface;
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

        $menu = null;

        if ($form->isSubmitted() && $form->isValid()) {
         
            $data = $form->getData();
            $menu = $mistralAiService->generateMenu($data['cuisine'], $data['nbPlats']);
            dump($menu->getDishes()); 
            $dishes = $menu->getDishes()->toArray(); 
        }

        return $this->render('menu/generate.html.twig', [
            'form' => $form->createView(),
            'menu' => $menu,
            'dishes' => $dishes,
        ]);
    }

    #[Route('/menu/list', name: 'menu_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $menus = $entityManager->getRepository(Menu::class)->findAll();

        return $this->render('menu/list.html.twig', [
            'menus' => $menus,
        ]);
    }
}
