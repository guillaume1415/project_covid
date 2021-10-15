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

class RegisterUserAction extends Action
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

        echo $this->request->getBody();

        $this->registerUser($_POST);

        return $this->twig->render($this->response, 'user_register_page.twig');
    }


    public function registerUser($post)
    {
        if (!empty($post)) {

            $errors = [];

            // checking name
            if (empty($post['name'])) {
                $errors = "nom non valide";
            }
            if (empty($post['date_birthday'])) {
                $errors = "date de naissance vide";
            }
            // checking first name
            if (empty($post['first_name'])) {
                $errors = "prénom non valide";
            }
            //TODO FAIRE VERIFICATION DATE DE NAISSANCE https://stackoverflow.com/questions/13746332/using-filter-var-to-verify-date
            if (empty($post['email'] || !filter_var($post['email'], FILTER_VALIDATE_EMAIL))) {
                $errors = "email vide";
            } else {
//                echo"EMAIL";
//                var_dump($post['email']);
                $email = trim(htmlentities($post['email']));
                $query = $this->em->createQuery('SELECT e.id FROM \App\Entity\Users e WHERE e.email = :email ');
                $query->setParameters(array(
                    'email' => $email,
                ));
                $user = $query->getResult();
//                var_dump($user);
                if ($user) {
                    $errors['email'] = 'cette adresse email est déjà prise';
                }
            }

            if (empty($post['password']) || $post['password'] != $post['password_confirm']) {
                $errors = "mot de passe invalide";
            }
//            var_dump($errors);
//            var_dump($post);
            if (empty($errors)) {
                $name = trim(htmlentities($post['name']));
                $first_name = trim(htmlentities($post['first_name']));
//                 $username = trim(htmlentities($post['username']));
                $email = trim(htmlentities($post['email']));
                $password = trim(htmlentities($post['password']));
                $birth_day = $post['date_birthday'];
                $user_id = $this->user->insertUser($name, $first_name, $email, $password,$birth_day);
//                var_dump($user_id);
                if ($user_id) {
                    // exit();
                } else {
                    // exit();
                }
            }
        }
    }
}
