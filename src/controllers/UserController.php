<?php
require_once __DIR__.'/../../core/Controller.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../validations/UserValidation.php';

class userController extends Controller
{

  function __construct()
  {
    parent::__construct();

    $this->validate = new UserValidation();
    $this->user = new User();
  }
  public function login()
  {
    $this->validate->validationLogin($this->request);
    $user = $this->user->getByEmail($this->request['email']);
    $hash = $user['password'];
    if(password_verify($this->request['password'],$hash)){
      //1º get roles
      $payload = [
        'iduser' => $user['id'],
        'user' => $user,
        'created_at' => time()
      ];
      $token = $this->getToken($payload);
      $this->responseJson([
        "token" => $token,
        "user" => $user,
        "created_at" => time()
      ]);
    }else{
      $this->error('Contraseña o email incorrecto',400);
    }
  }
  public function register()
  {
    // $this->error('No implementado',400);
    $this->validate->validationRegister($this->request);
    $this->user->checkEmail($this->request['email']);
    $user = [
      'email' => $this->request['email'],
      'rol' => 2,
      'password' => $this->request['password']
    ];

    $iduser = $this->user->register($user);
    $payload = [
      "email" => $user['email'],
      "created" => time(),
    ];
    $user = $this->user->getById($iduser);
    $token = $this->getToken($payload);
    $this->responseJson([
      "token" => $token,
      "user" => $user,
      // "email" => $email
    ]);
  }

  public function getProfile()
  {
    // $this->checkToken();
    $id = $this->token->iduser;
    $user = $this->user->getById($id);
    $this->responseJson($user);
  }

  public function getAll ()
  {
    $this->responseJson($this->user->getAll());
  }
  public function getUser ($iduser)
  {
    $this->responseJson($this->user->getById($iduser));
  }

  public function changePasswd()
  {
    $this->checkToken();
    $id = $this->token->iduser;
    $user = $this->user->getById($id);
    $hash = $user['password'];
    if(password_verify($this->request['password'],$hash))
    {
      if($this->request['password'] === $this->request['newpassword']){
        $this->error('La nueva contraseña no puede ser igual a la anterior', 400);
      }else{
        $this->user->changePasswd($this->request['newpassword']);
        $this->responseJson('Contraseña modificada con exito');
      }
    }else{
      $this->error('Contrasena incorrecta',400);
    }
  }
  public function recoverPasswd()
  {
    $this->validate->validationRecover($this->request);
    $this->user->recoverpassword($this->request['email']);
    $this->responseJson('Password modificada');
  }
}