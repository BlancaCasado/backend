<?php
require_once __DIR__.'/../../core/Model.php';

class User extends Model
{
  function __construct()
  {
    parent::__construct();

    $this->table = 'users';
  }

  public function register($user)
  {
    extract($user);
    $sql = 'INSERT INTO users
              (email, password, rol)
            VALUES
              (:email, :password, :rol)';
    $params = [
      [':email',$email],
      [':password',password_hash($password, PASSWORD_BCRYPT)],
      [':rol', $rol, PDO::PARAM_INT],
    ];
    return $this->query($sql,$params);
  }


  public function getByEmail ($email) {
    $res = $this->getBy('email', $email);
    if(!isset($res[0])){
      $this->error('Ningun email registrado',404);
    }
    return $res[0];
  }
 
  public function changepassword($id, $password)
  {
    $sql = 'UPDATE users
            SET password = :password
            WHERE id = :id
            ';
    $params = [
      [':id', $id],
      [':password', password_hash($password, PASSWORD_BCRYPT)],
    ];
    $this->query($sql,$params);
  }
  public function recoverpassword($email)
  {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, 5 );

    $asunto = 'Recuperacion contraseña';
    $mensaje = '<p>Su contraseña ha sido cambiada</p>
    <p>Su nueva contraseña es : <b>'.$password.'</b></p>
    <p>Recuerde cambiar su contraseña una vez acceda </p>';

    if($this->getBy('email',$email)){
      $sql = 'UPDATE users
              SET password = :password
              WHERE email = :email';
      $params = [
        ['password',password_hash($password, PASSWORD_BCRYPT)],
        ['email',$email],
      ];
      emailsmtp($asunto,$mensaje,$email);
      $this->query($sql,$params);
    }else{
      $this->error('No existe una cuenta con ese email',400);
    }
  }
}