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


class ShowLoginUserAction extends Action
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
        
        return $this->twig->render($this->response, 'user_login_page.twig'); 
    }
    
    public function showLoginUser(Request $request, Response $response){
        return $this->twig->render($this->response, 'user_login_page.twig');
    }    
}
