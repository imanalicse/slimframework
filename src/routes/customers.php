<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// Get All Customers
$app->get('/api/customers', function (Request $request, Response $response, array $args) {    

    $sql = "SELECT * FROM customers";
    try{
        // Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);        
    } catch( PDOException $e){
        echo  $e->getErrorMessage();
    }    
});


// Get Single Customer
$app->get('/api/customer/{id}', function (Request $request, Response $response, array $args) {

    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM customers WHERE id = $id";
    try{
        // Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);        
    } catch( PDOException $e){
        echo  $e->getErrorMessage();
    }    
});

// Add Customer
$app->get('/api/customer/add', function (Request $request, Response $response, array $args) {
    
    $first_name = $request->getParams('first_name');
    $first_name = $request->getParams('last_name');
    $phone = $request->getParams('phone');
    $email = $request->getParams('email');
    $address = $request->getParams('address');
    $city = $request->getParams('city');
    $state = $request->getParams('state');
    
    $sql = "INSERT INTO customers (first_name, last_name, phone, email, `address`, city, `state`) VALUES 
    (:first_name, :last_name, :phone, :email, :`address`, :city, :`state` )";
    try{
        // Get DB Object
        $db = new db();
        //Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);       
        
        $stmt->execute();
        
        echo '{"notice": { "text": "Customer Added" }';

    } catch( PDOException $e){
        echo  $e->getErrorMessage();
    }    
});