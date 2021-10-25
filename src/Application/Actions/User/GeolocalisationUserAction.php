<?php

namespace App\Application\Actions\User;

use App\Entity\Geolocalisation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Application\Actions\Action;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use \App\Entity\Users;

class GeolocalisationUserAction extends Action
{
    private $twig;

    public function __construct(LoggerInterface $Logger, EntityManager $em, Twig $twig, Users $user,Geolocalisation $localisation)
    {
        $this->em = $em;
//        $this->user_repositori = $this->em->getRepository('App\Entity\Users');
        $this->geo_repositori = $this->em->getRepository('App\Entity\Geolocalisation');
        $this->logger = $Logger;
        $this->twig = $twig;
        $this->user = $user;
        $this->geolocalisation = $localisation;
    }

    protected function action(): Response
    {

        echo $this->request->getBody();

        $this->registerLocalisation($_POST);

        return $this->twig->render($this->response, 'geolocalisation_register_page.twig');
    }


    public function registerLocalisation($post)
    {
        if (!empty($post)) {

            $errors = [];

            // checking name
            if (empty($post['latitude'])) {
                $errors = "champ latitude vide";
            }
            if (empty($post['longitude'])) {
                $errors = "champ longitude vide";
            }
            if (empty($errors)) {
                $longitude = trim(htmlentities($post['longitude']));
                $latitude = trim(htmlentities($post['latitude']));



                $id_loca = $this->insertLocalisation($longitude,$latitude);
//                $this->user->setGeolocalisationUser($id_loca);
//                var_dump($loca);
//                if ($loca) {
//                    // exit();
//                } else {
//                    // exit();
//                }
            }
        }
    }

    public function insertLocalisation($latitude,$longitude){
        $loca = new Geolocalisation;
        $loca->setLongitude($longitude);
        $loca->setLatitude($latitude);
        $user_loca = $this->user->setGeolocalisationUser($loca);
        var_dump($this->user);
        $this->em->persist($loca);
        $this->em->flush();

        $this->user->em->persist($user_loca);
        $this->user->em->flush();
//        $loca_id= $this->getId();
//        var_dump($loca_id);
        return $loca;
        // $user_id = lastInsertId();
    }
}
