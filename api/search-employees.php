
<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $postData = json_decode(file_get_contents('php://input'), true);

  require_once '../db/DBConnectionEmployees.php';

  $db = new DBConnectionEmployees('../db/employees.db', '../db/json/employees.json');

  if(!$postData['search']){
    $data = [
      'order' => htmlentities($postData['order']) . ' ' . htmlentities($postData['orderBy']),
    ];
  }else{
    $data = [
      'searchTerm' => htmlentities($postData['search']),
      'searchBy' => htmlentities($postData['searchBy']),
      'order' => htmlentities($postData['order']) . ' ' . htmlentities($postData['orderBy']),
    ];
  }

  echo json_encode($db->getEmployeeBy($data));

}else{
  die('Invalid request method');
}