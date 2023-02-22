
<?php

class DBConnection {

  protected $dbh;
  protected $stmt;
  protected $error;

  protected function __construct($sqliteDB=''){

    // Create PDO instance
    try{
      $this->dbh = new PDO($sqliteDB);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  // Prepare statement with query
  protected function query($sql){
    $this->stmt = $this->dbh->prepare($sql);
  }

  // Bind values
  protected function bind($param, $value, $type = null){
    if(is_null($type)){
      switch(true){
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->stmt->bindParam($param, $value, $type);
  }

  // Execute the prepared statement
  protected function execute(){
    return $this->stmt->execute();
  }

  // Get result set as array of objects
  protected function resultSet(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // Get single record as object
  protected function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  // Convert characters to UTF8 encoding
  protected function convertUTF8($array){
    array_walk_recursive($array, function(&$item, $key){
      if(!mb_detect_encoding($item, 'utf-8', true))
        $item = utf8_encode($item);
    });
    return $array;
  }

  protected function test(){
    return 'test';
  }

  // Get row count
  public function rowCount(){
    return $this->stmt->rowCount();
  }

}






