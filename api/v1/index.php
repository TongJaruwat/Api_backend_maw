<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization'); */

header('Access-Control-Allow-Origin', '*');
require_once './DbHandler.php';
require_once '../include/Config.php';
require '../../vendor/autoload.php';


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;




$app = AppFactory::create();
$app->setBasePath('/Api_backend_maw/api/v1');



$app->get('/checkapi', function($request, $response, $args) use ($app) {
    $data = array();
    $data["res_code"] = "00";
    $data["res_text"] = "แสดงข้อมูลสำเร็จ";
    return echoRespnse($response, 200, $data);
});




// ทำเอง

$app->post('/login', function($request, $response, $args) use ($app) {



    $username = $request->getParsedBody()['username'];
    $password = $request->getParsedBody()['password'];


    $db = new DbHandler(); 
    $result = $db->login( $username,$password); 
 
    if ($result != NULL || $result == true) {
        $data["res_code"] = "00";
        $data["res_text"] = "เข้าสู่ระบบสำเร็จ";
        $data["user_role"] = $result;
    } else {
        $data["res_code"] = "01"; 
        $data["res_text"] = "เข้าสู่ระบบไม่สำเร็จ"; 
    }

    return echoRespnse($response, 200, $data); 
});














































// ***************************************************************************************************
// ***************************************************************************************************
// ***************************************************************************************************

        /*** แสดงผล json ***/
        function echoRespnse($response, $status_code, $data) {
            $response = $response->withStatus($status_code)
                                ->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode($data));
            return $response;
        }

// ***************************************************************************************************
// ***************************************************************************************************
// ***************************************************************************************************







$app->run();
?>
