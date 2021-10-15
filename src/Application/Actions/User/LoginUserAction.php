<?php

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\Action;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Entity\Users;
// use Doctrine\ORM\EntityManagerInterf ace;


class LoginUserAction extends Action
{
    private $twig;

    public function __construct(LoggerInterface $Logger, EntityManager $em, Twig $twig, Users $user)
    {
        $this->em = $em;
        $this->user_repositori = $this->em->getRepository('App\Entity\Users');
        $this->logger = $Logger;
        $this->twig = $twig;
        $this->user = $user;
    }

    protected function action(): Response
    {
        echo $this->request->getBody() . "</br>";
        return $this->twig->render($this->response, 'user_login_page.twig');
    }

    public function showLoginUserPage(Request $request, Response $response)
    {
        return $this->twig->render($response, 'user_login_page.twig');
    }

    public function verifyUserLogin(Request $request, Response $response): Response
    {
        if ($_POST['email'] && $_POST['password']) {
            $email =  trim(htmlentities($_POST['email']));
            $password = trim(htmlentities($_POST['password']));
            
            $user = $this->user->loginUser($email, $password);
            if ($user) {
                var_dump("mot de pass okay");
                return $response->withHeader('Location', '/connexion')->withStatus(302);

                 exit;
            } else {
                var_dump("error connection");
                return $response->withHeader('Location', '/connexion')->withStatus(302);
                // exit;
            }
        }
    }

    public function test()
    {
        // var_dump($this->respondWithData($users));
        // $this->response->getBody()->write($form);
        // var_dump($params = (array)$this->request->getParsedBody());

        // $users = $this->user_repositori->findAll();
        // var_dump($users);
        // foreach ($users as $user) {
        // $this->logger->info($user->jsonSerialize());
        //     print($user->getName());
        //     print($user->getEmail());
        // }
        // var_dump($this->respondWithData($users));
    }
}
