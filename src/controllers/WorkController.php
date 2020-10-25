<?php
require_once __DIR__.'/../../core/Controller.php';
require_once __DIR__.'/../models/Work.php';
require_once __DIR__.'/../validations/WorkValidation.php';

class workController extends Controller
{

  function __construct()
  {
    parent::__construct();

    $this->validate = new WorkValidation();
    $this->work = new Work();
  }

  public function getAll()
  {
    $this->responseJson($this->work->getAll());
  }

  public function getWork($idwork)
  {
    $this->responseJson($this->work->getById($idwork));
  }

  public function register()
  {
    $this->validate->validationRegisterWork($this->request);
    $work = [
      'title' => $this->request['title'],
      'theme' => $this->request['theme'],
      'editor' => $this->request['editor'],
    ];

    $idwork = $this->work->register($work);
    $work = $this->work->getById($idwork);
    $this->responseJson(["work" => $work]);
  }

  public function updWork($id)
  {
    $work = [
      'title' => $this->request['title'],
    ];
    $this->work->updateWork($id, $work);
    $this->responseJson($work);
  }
  

  public function delWork($id)
  {
    $this->work->deleteWork($id);
    $this->responseJson('Obra borrada');
  }

}