
<?php

require_once 'DBConnection.php';

class DBConnectionEmployees extends DBConnection{

  public function __construct($dbLocation, $jsonLocation){
    parent::__construct('sqlite:' . $dbLocation);
    $this->initEmployees($jsonLocation);
  }

  public function test(){
    return "Hello test";
  }

  private function initEmployees($jsonLocation){
    $this->createTableEmployees();
    $data = json_decode(file_get_contents($jsonLocation), true);
    $this->setAllEmployees($data);

  }

  private function createTableEmployees(){
    $this->query('drop table if exists employees');
    $this->execute();
    $this->query('create table if not exists employees(
      employee_id text primary key,
      first_name text,
      last_name text,
      dni text
    );');
    $this->execute();
  }

  public function getAllEmployees(){
    $this->query('SELECT * FROM employees');
    return json_decode(json_encode($this->resultSet()), true);
  }

  private function setAllEmployees($data){
    foreach($data as $employee){
      $this->query("INSERT INTO employees VALUES(:employee_id,:first_name,:last_name, :dni)");
      
      $this->bind(':employee_id', $employee['employee_id']);
      $this->bind(':first_name', $employee['first_name']);
      $this->bind(':last_name', $employee['last_name']);
      $this->bind(':dni', $employee['dni']);

      $this->execute();
    }
  }

  public function getEmployeesForPage($pageData){

    $this->query('SELECT * FROM employees ORDER BY ' . $pageData['order'] . ' LIMIT :start, :limit');

    $this->bind(':start', $pageData['start']);
    $this->bind(':limit', $pageData['limit']);

    return $this->resultSet();
  }

  public function getEmployeeBy($data){

    if(isset($data['searchTerm'])){
      $this->query('SELECT * FROM employees WHERE ' . $data['searchBy'] . ' LIKE :searchTerm ORDER BY ' . $data['order']);
      $this->bind(':searchTerm', $data['searchTerm'].'%');
    }else{
      $this->query('SELECT * FROM employees ORDER BY ' . $data['order']);
    }
    
    return $this->resultSet();
  }
}
