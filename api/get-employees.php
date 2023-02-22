
<?php

if($_SERVER['REQUEST_METHOD'] === 'GET'){

  $page = htmlentities($_GET['page']) ?? 1;
  $order = htmlentities($_GET['order']) ?? 'employee_id';
  $orderBy = htmlentities($_GET['orderBy']) ?? 'ASC';

  require_once '../db/DBConnectionEmployees.php';

  $db = new DBConnectionEmployees('../db/employees.db', '../db/json/employees.json');
  $limit = 10;
  $start = (intval(htmlentities($page)) - 1) * $limit;

  $pageData = [
    'order' => $order . ' ' . $orderBy,
    'start' => $start,
    'limit' => $limit
  ];

  echo json_encode($db->getEmployeesForPage($pageData));

}else{
  die('Invalid request method');
}