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
    if (!empty($this->post)) {
      $user = ModelFactory::get('User')->read($this->post['email'], 'email');

      if (password_verify($this->post['pass'], $user['pass'])) {
        $this->session->createSession(
          $user['id'],
          $user['first_name'],
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
      $user = ModelFactory::get('User')->read($this->post['email'], 'email');

      if (empty($user) == false) {
        $this->cookie->createAlert('There is already a user account with this email address');
      }
      $data['image'] = $this->files->uploadFile('img/user');

      $data['pass'] = password_hash($this->post['pass'], PASSWORD_DEFAULT);

      $data['first_name']   = $this->post['first_name'];
      $data['last_name']    = $this->post['last_name'];
      $data['zipcode']      = $this->post['zipcode'];
      $data['country']      = $this->post['country'];
      $data['email']        = $this->post['email'];
      $data['created_date'] = $this->post['date'];
      $data['updated_date'] = $this->post['date'];

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

      if (!empty($_FILES['file']['name'])) {
        $data['image'] = $this->files->uploadFile('img/user');
      }

      $data['pass'] = password_hash($this->post['pass'], PASSWORD_DEFAULT);

      $data['first_name']   = $this->post['first_name'];
      $data['last_name']    = $this->post['last_name'];
      $data['zipcode']      = $this->post['zipcode'];
      $data['country']      = $this->post['country'];
      $data['email']        = $this->post['email'];
      $data['updated_date'] = $this->post['date'];

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
