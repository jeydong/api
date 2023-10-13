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

$data=json_decode($request->getBody());
$fname =$data->fname;
$lname =$data->lname;
//Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";
try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname",

$username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE,

PDO::ERRMODE_EXCEPTION);

$sql = "INSERT INTO names (lname, fname)
VALUES ('".$fname ."','". $lname ."')";
//VALUES ('".'$fname' ."','". '$lname' ."')";
// use exec() because no results are returned

$conn->exec($sql);
$response->getBody()-> 

write(json_encode(array("status"=>"success","data"=>null)));


} catch(PDOException $e){
$response->getBody()->write(json_encode(array("status"=>"error",
"message"=>$e->getMessage())));
}
$conn = null;

    
return $response;
});

//endpoint post print
$app->post('/postPrint', function (Request $request, Response $response, array $args) {

//Database

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM names";
$result = $conn->query($sql);
if ($result->num_rows > 1) { 
$data=array();
while($row = $result->fetch_assoc()) {
array_push($data, array("fname"=>$row["fname"]

,"lname"=>$row["lname"]));
}
$data_body=array("status"=>"success","data"=>$data);
$response->getBody()->write(json_encode($data_body));
} else {
$response->getBody()->write(array("status"=>"success","data"=>null));
}
$conn->close();


    return $response;
});

//endpoint post update
$app->post('/postUpdate', function (Request $request, Response $response, array $args)
{

$data=json_decode($request->getBody());
$id=$data->id;
$fname =$data->fname;
$lname =$data->lname;
//Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";
try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname",

$username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE,

PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE names SET  lname='$lname', fname='$fname' WHERE id=$id";
//$sql = "UPDATE names SET lname='doe', fname='john' WHERE id=$id"; this is quite working

$conn->exec($sql);
$response->getBody()-> 

write(json_encode(array("status"=>"update success","data"=>null)));


} catch(PDOException $e){
$response->getBody()->write(json_encode(array("status"=>"error",
"message"=>$e->getMessage())));
}
$conn = null;

    
return $response;
});

//endpoint post Delete
$app->post('/postDelete', function (Request $request, Response $response, array $args)
{

$data=json_decode($request->getBody());
$id=$data->id;

//Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";
try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname",

$username, $password);

// set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE,

PDO::ERRMODE_EXCEPTION);

$sql = "DELETE FROM names WHERE id=$id";
//$sql = "UPDATE names SET lname='doe', fname='john' WHERE id=$id"; this is quite working

$conn->exec($sql);
$response->getBody()-> 

write(json_encode(array("status"=>"deleted successfully","data"=>null)));


} catch(PDOException $e){
$response->getBody()->write(json_encode(array("status"=>"error",
"message"=>$e->getMessage())));
}
$conn = null;

    
return $response;
});




$app->run();






?>