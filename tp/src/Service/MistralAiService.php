<?php
namespace App\Service;

use App\Entity\Menu;
use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MistralAiService
{
    private HttpClientInterface $client;
    private string $openAiApiKey;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClientInterface $client, string $openAiApiKey, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->openAiApiKey = $openAiApiKey;
        $this->entityManager = $entityManager;
    }

    public function generateMenu(string $cuisineType, int $nbPlats): Menu
{
    $prompt = "Génère un menu de type '$cuisineType' avec $nbPlats plats : 
    Chaque plat doit inclure :
    - Un nom
    - Une courte description
    - Un prix approximatif entre 5 et 25 euros

    Réponds STRICTEMENT en format JSON : 
    {
        \"menu\": [
            {\"type\": \"Entrée\", \"name\": \"Salade César\", \"description\": \"Salade avec parmesan et croûtons\", \"price\": 8.5},
            {\"type\": \"Plat\", \"name\": \"Pâtes Carbonara\", \"description\": \"Pâtes fraîches avec sauce crémeuse et lardons\", \"price\": 15.0},
            {\"type\": \"Dessert\", \"name\": \"Tiramisu\", \"description\": \"Dessert italien au café et mascarpone\", \"price\": 7.0}
        ]
    }";

    $response = $this->client->request('POST', 'https://api.mistral.ai/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $this->openAiApiKey,
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'model' => 'mistral-tiny',
            'messages' => [
                ['role' => 'system', 'content' => 'Tu es un assistant culinaire.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
        ],
    ]);

    $data = $response->toArray();
    $responseText = $data['choices'][0]['message']['content'] ?? '';

    if (preg_match('/\{.*\}/s', $responseText, $matches)) {
        $menuJson = json_decode($matches[0], true);
    } else {
        throw new \Exception("Aucun JSON valide trouvé dans la réponse : " . $responseText);
    }

    if (!isset($menuJson['menu']) || !is_array($menuJson['menu'])) {
        throw new \Exception("Réponse inattendue de l'API : " . json_encode($menuJson));
    }

    $menu = new Menu();
    $menu->setName("Menu " . ucfirst($cuisineType));
    $menu->setDescription("Menu de type $cuisineType avec $nbPlats plats.");
    $menu->setCreatedAt(new \DateTimeImmutable());
    $menu->setUpdatedAt(new \DateTimeImmutable());

    $this->entityManager->persist($menu);

    foreach ($menuJson['menu'] as $platData) {
        $dish = new Dish();
        $dish->setName($platData['name']);
        $dish->setDescription($platData['description']);
        $dish->setPrice($platData['price']);
        $dish->setCreatedAt(new \DateTimeImmutable());
        $dish->setUpdatedAt(new \DateTimeImmutable());
        $dish->setMenu($menu);
        $menu->addDish($dish);
        $this->entityManager->persist($dish);
    }

    $this->entityManager->flush();

    return $menu;
}

public function generateQuiz(Menu $menu): array
{
    $dishes = $menu->getDishes();
    $dishNames = array_map(function ($dish) {
        return $dish->getName();
    }, $dishes->toArray());

    $prompt = "Génère un quiz avec 3 questions sur le menu suivant : " . implode(", ", $dishNames);

    $response = $this->client->request('POST', 'https://api.mistral.ai/v1/chat/completions', [
        'json' => [
            'model' => 'mistral-tiny',
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'temperature' => 0.7,
        ],
    ]);
    return $response;
}


}
