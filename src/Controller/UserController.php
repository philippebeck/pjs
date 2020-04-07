<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
  {
    if (!empty($this->globals->getPost()->getPostArray())) {
      $user = ModelFactory::getModel('User')->readData($this->globals->getPost()->getPostVar('email'), 'email');

      if (password_verify($this->globals->getPost()->getPostVar('pass'), $user['pass'])) {
        $this->globals->getSession()->createSession(
          $user['id'],
          $user['name'],
          $user['image'],
          $user['email']
        );

        $this->globals->getSession()->createAlert('Successful authentication, welcome ' . $user['first_name'] .' !', 'info');

        $this->redirect('home');
      }
      $this->globals->getSession()->createAlert('Failed authentication !', 'warning');
    }
    return $this->render('user/loginUser.twig');
  }

    /**
     *
     */
    public function logoutMethod()
  {
    $this->globals->getSession()->destroySession();
    $this->globals->getSession()->createAlert('Good bye !', 'info');

    $this->redirect('home');
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
  {
    if (!empty($this->globals->getPost()->getPostArray())) {
      $user = ModelFactory::getModel('User')->readData($this->globals->getPost()->getPostVar('email'), 'email');

      if (empty($user) == false) {
        $this->globals->getSession()->createAlert('There is already a user account with this email address', 'warning');
      }
      $data['image'] = $this->globals->getFiles()->uploadFile('img/user');

      $data['pass'] = password_hash($this->globals->getPost()->getPostVar('pass'), PASSWORD_DEFAULT);

      $data['name']     = $this->globals->getPost()['name'];
      $data['email']    = $this->globals->getPost()['email'];

      ModelFactory::getModel('User')->create($data);
      $this->globals->getSession()->createAlert('New user created successfully !', 'valid');

      $this->redirect('home');
    }
    return $this->render('user/createUser.twig');
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
  {
    if (!empty($this->globals->getPost()->getPostArray())) {

      if (!empty($this->globals->getFiles()->getFileVar('name'))) {
        $data['image'] = $this->globals->getFiles()->uploadFile('img/user');
      }

      $data['pass'] = password_hash($this->globals->getPost()->getPostVar('pass'), PASSWORD_DEFAULT);

      $data['name']     = $this->globals->getPost()->getPostVar('name');
      $data['email']    = $this->globals->getPost()->getPostVar('email');

      ModelFactory::getModel('User')->updateData($this->globals->getGet()->getGetVar('id'), $data);
      $this->globals->getSession()->createAlert('Successful modification of the selected user !', 'info');

      $this->redirect('home');
    }
    $user = ModelFactory::getModel('User')->readData($this->globals->getGet()->getGetVar('id'));

    return $this->render('user/updateUser.twig', ['user' => $user]);
  }

    public function deleteMethod()
  {
    ModelFactory::getModel('User')->deleteData($this->globals->getGet()->getGetVar('id'));
    $this->globals->getSession()->createAlert('User permanently deleted !', 'delete');

    $this->redirect('home');
  }
}
