<?php

namespace Drupal\custom_form;

use Drupal\Core\Database\Connection;

class CustomFormServices
{

  protected $db_name;
  protected $connection;

  public function __construct(connection $connection)
  {
    $this->connection = $connection;
    $this->db_name = 'd8_demo';
  }

  public function insertFormValue($data)
  {
    //Insert data in table.
    $status = $this->connection->insert($this->db_name)
      ->fields($data)
      ->execute();
    return $status;
  }

  public function fetchData() {
     $result=$this->connection->select('d8_demo','d8')->fields('d8',['firstname','lastname'])->range(0,1)->execute();
      while($row = $result->fetchAssoc()){
        $output .= $row['firstname'];
        $output .= $row['lastname'];
      }
        return $output;
  }
}
