<?php
session_start();

// Import the router
require_once __DIR__ . '/app/Router/Router.php';
require_once __DIR__ . '/app/core/Controller.php';
require_once __DIR__ . '/app/core/Database.php';

require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/ChatController.php';
require_once __DIR__ . '/app/controllers/PrivateChatController.php';
require_once __DIR__ . '/vendor/autoload.php';

use app\Router\Router;


// Create a new router instance
$router = new Router();

// Define routes
$router->add('GET', '/', function () {
    $controller = new App\Controllers\UserController();
    $controller->login();
});

$router->add('GET', '/login', function () {
    $controller = new App\Controllers\UserController();
    $controller->index();
});

$router->add('POST', '/login', function () {
    $controller = new App\Controllers\UserController();
    $controller->login();
});

$router->add('GET', '/register', function () {
    $controller = new App\Controllers\UserController();
    $controller->registerForm();
});

$router->add('POST', '/register', function () {
    $controller = new App\Controllers\UserController();
    $controller->register();
});

$router->add('GET', '/chat', function () {
    $controller = new App\Controllers\ChatController();
    $controller->globalChat();
});

$router->add('POST', '/chat/send', function () {
    $controller = new App\Controllers\ChatController();
    $controller->sendMessage();
});

$router->add('GET', '/chat/messages', function () {
    $controller = new App\Controllers\ChatController();
    $controller->getMessages();
});

$router->add('GET', '/chat/private/{id}/messages', function ($receiverId) {
    $controller = new App\Controllers\PrivateChatController();
    $controller->getMessages($receiverId);
});

$router->add('POST', '/chat/private/{id}/send', function ($receiverId) {
    $controller = new App\Controllers\PrivateChatController();
    $controller->sendMessage($receiverId);
});

$router->add('GET', '/chat/private/search', function () {
    $controller = new App\Controllers\PrivateChatController();
    $controller->searchUsers();
});

// Dispatch the route
$router->dispatch();
