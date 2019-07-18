<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function loginAction()
  {
    if (!empty($this->post->getPostArray())) {
      $user = ModelFactory::get('User')->read($this->post->getPostVar('email'), 'email');

      if (password_verify($this->post->getPostVar('pass'), $user['pass'])) {
        $this->session->createSession(
          $user['id'],
          $user['name'],
          $user['image'],
          $user['email']
        );

        $this->cookie->createAlert('Successful authentication, welcome ' . $user['first_name'] .' !');

        $this->redirect('home');
      }
      $this->cookie->createAlert('Failed authentication !');
    }
    return $this->render('user/loginUser.twig');
  }

    /**
     *
     */
    public function logoutAction()
  {
    $this->session->destroySession();
    $this->cookie->createAlert('Good bye !');

    $this->redirect('home');
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createAction()
  {
    if (!empty($this->post)) {
      $user = ModelFactory::get('User')->read($this->post->getPostVar('email'), 'email');

      if (empty($user) == false) {
        $this->cookie->createAlert('There is already a user account with this email address');
      }
      $data['image'] = $this->files->uploadFile('img/user');

      $data['pass'] = password_hash($this->post->getPostVar('pass'), PASSWORD_DEFAULT);

      $data['name']     = $this->post['name'];
      $data['email']    = $this->post['email'];

      ModelFactory::get('User')->create($data);
      $this->cookie->createAlert('New user created successfully !');

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
    public function updateAction()
  {
    if (!empty($this->post)) {

      if (!empty($this->files->getFileVar('name'))) {
        $data['image'] = $this->files->uploadFile('img/user');
      }

      $data['pass'] = password_hash($this->post->getPostVar('pass'), PASSWORD_DEFAULT);

      $data['name']     = $this->post->getPostVar('name');
      $data['email']    = $this->post->getPostVar('email');

      ModelFactory::get('User')->update($this->get->getGetVar('id'), $data);
      $this->cookie->createAlert('Successful modification of the selected user !');

      $this->redirect('home');
    }
    $user = ModelFactory::get('User')->read($this->get->getGetVar('id'));

    return $this->render('user/updateUser.twig', ['user' => $user]);
  }

    public function deleteAction()
  {
    ModelFactory::get('User')->delete($this->get->getGetVar('id'));
    $this->cookie->createAlert('User permanently deleted !');

    $this->redirect('home');
  }
}
