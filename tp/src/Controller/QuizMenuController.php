<?php
namespace App\Controller;

use App\Form\MenuType;
use App\Service\MistralAiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Menu;

class QuizMenuController extends AbstractController
{
#[Route('/menu/quiz/{id}', name: 'menu_quiz')]
public function generateQuiz(Menu $menu, MistralAiService $mistralAiService): Response
{
    $quiz = $mistralAiService->generateQuiz($menu);
    return $this->render('menu/quiz.html.twig', ['quiz' => $quiz]);
}
}