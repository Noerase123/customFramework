<?php 

  include '../config.php';

class DataController {

  public function __construct() {

    $this->viewClass = new ViewClass();
    
  }

  public function index() 
  {
    $json_data = file_get_contents("../data.json");

    $json = json_decode($json_data,true);

    $output = '';

    foreach ($json['data'] as $data) {
      
      $output .= '<h4> Title : '.$data['title'].'</h4>';
      $output .= '<h5> Author : '.$data['author'].'</h5>';
      $output .= '<p> Content : '.$data['short_description'].'</p>';

      $this->viewClass->happy();

    }
    return $output;
  }

}

$dataController = new DataController;

echo $dataController->index();