<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
  {
    $allArticles = ModelFactory::get('Article')->list();

    return $this->render('blog/blog.twig', ['allArticles' => $allArticles]);
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createAction()
  {
    if (!empty($this->post->getPostArray())) {
      $data['image'] = $this->files->uploadFile('img/blog');

      $data['title']        = $this->post->getPostVar('title');
      $data['link']         = $this->post->getPostVar('link');
      $data['content']      = $this->post->getPostVar('content');
      $data['created_date'] = $this->post->getPostVar('date');
      $data['updated_date'] = $this->post->getPostVar('date');

      ModelFactory::get('Article')->create($data);
      $this->cookie->createAlert('New article created successfully !');

      $this->redirect('admin');
    }
    return $this->render('admin/createArticle.twig');
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function readAction()
  {
    $article  = ModelFactory::get('Article')->read($this->get->getGetVar('id'));
    $comments = ModelFactory::get('Comment')->list($this->get->getGetVar('id'), 'article_id');

    if(!empty($comments)) {

      for ($i = 0; $i < count($comments); $i++) {

        $userId = $comments[$i]['user_id'];

        $user = ModelFactory::get('User')->read($userId);

        $comments[$i]['user']   = $user['name'];
        $comments[$i]['image']  = $user['image'];
      }
    }
    return $this->render('blog/readArticle.twig', [
      'article'   => $article,
      'comments'  => $comments
    ]);
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateAction()
  {
    if (!empty($this->post->getPostArray())) {

      if (!empty($this->files->getFileVar('name'))) {
        $data['image'] = $this->files->uploadFile('img/blog');
      }

      $data['title']        = $this->post->getPostVar('title');
      $data['link']         = $this->post->getPostVar('link');
      $data['content']      = $this->post->getPostVar('content');
      $data['updated_date'] = $this->post->getPostVar('date');

      ModelFactory::get('Article')->update($this->get->getGetVar('id'), $data);
      $this->cookie->createAlert('Successful modification of the selected article !');

      $this->redirect('admin');
    }
    $article = ModelFactory::get('Article')->read($this->get->getGetVar('id'));

    return $this->render('admin/blog/updateArticle.twig', ['article' => $article]);
  }

    public function deleteAction()
  {
    ModelFactory::get('Article')->delete($this->get->getGetVar('id'));
    $this->cookie->createAlert('Article permanently deleted !');

    $this->redirect('admin');
  }
}
