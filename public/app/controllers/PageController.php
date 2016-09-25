<?php

abstract class PageController {

  protected $title;
  protected $metaDesc;
  protected $dbc;
  protected $plates;
  protected $data = [];

  public function __construct() {

    //Instantiates (create instance of) Plates Library
    $this->plates = new League\Plates\Engine('app/templates');
  }

  //Force children classes to have a buildHTML function
  abstract public function buildHTML();

}
