<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';
$app = new \Slim\App;
//endpoint get greeting
$app->get('/getName/{fname}/{lname}', function (Request $request, Response

$response, array $args) {
$name = $args['fname']." ".$args['lname'];
$response->getBody()->write("Hello, $name");
return $response;

});
//endpoint post greeting
$app->post('/postName', function (Request $request, Response $response, array $args)
{
return $response;
});
//endpoint post print
$app->post('/postPrint', function (Request $request, Response $response, array $args) {
return $response;
});
$app->run();
?>