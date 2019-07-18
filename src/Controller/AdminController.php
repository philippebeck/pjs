<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
  {
    if ($this->session->islogged()) {

      if ($this->session->userEmail()) {

        $allArticles  = ModelFactory::get('Article')->list();
        $allComments  = ModelFactory::get('Comment')->list();
        $allUsers     = ModelFactory::get('User')   ->list();

        return $this->render('admin/admin.twig', [
          'allArticles'       => $allArticles,
          'allComments'       => $allComments,
          'allUsers'          => $allUsers
        ]);
      }
      $this->cookie->createAlert('Access reserved for the site administrator');

      $this->redirect('home');
    }
    $this->cookie->createAlert('You must be logged in to access the administration');

    $this->redirect('user!login');
  }
}
