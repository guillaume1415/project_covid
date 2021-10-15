<?php

// namespace App\Action;
namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\Action;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class HelloAction extends Action
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    // public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
    //     $viewData = [
    //         'name' => 'World',
    //         'notifications' => [
    //             'message' => 'You are good!'
    //         ],
    //     ];
        
    //     return $this->twig->render($response, 'home.twig', $viewData);
    // }

    protected function action(): Response
    {
        // require_once(__DIR__ . "/views/login.html");
        
        // $this->response->getBody()->write('login !');
        echo $this->request->getBody();
        // var_dump($params = (array)$this->request->getParsedBody());
        
        // $users = $this->user_repositori->findAll();
        // // var_dump($users);
        // foreach ($users as $user) {
        //     // $this->logger->info($user->jsonSerialize());
        //     print($user->getName());
        // }
        // return $this->respondWithData($users);
        return $this->twig->render($this->response, 'home.twig');
    }
}