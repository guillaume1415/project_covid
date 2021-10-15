<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\HelloAction;
use App\Application\Actions\HomeAction;

// 
use App\Application\Actions\user\LoginUserAction;
use App\Application\Actions\user\ShowLoginUserAction;
use App\Application\Actions\user\RegisterUserAction;
use App\Application\Actions\User\UserAction;

use Slim\Views\Twig;

return function (App $app) {

    $app->get('/', HomeAction::class);
    
    $app->get('/home ', function (Request $request, Response $response) {
        $response->getBody()->write('home');
        return $response;
    });

    // $app->get('/inscription', RegisterUserAction::class);
    // $app->post('/inscription', RegisterUserAction::class);
    $app->get('/inscription', RegisterUserAction::class);
    $app->post('/inscription', RegisterUserAction::class);

    // $app->get('/connexion', ShowLoginUserAction::class);
    // $app->post('/connexion', LoginUserAction::class );
    $app->get('/connexion', LoginUserAction::class . ':showLoginUserPage');
    $app->post('/connexion', LoginUserAction::class . ':verifyUserLogin');


    $app->get('/setting', function (Request $request, Response $response) {
        $response->getBody()->write('login');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/hello', HelloAction::class);
};
