<?php

// ****************************** \\
// ***** ARTICLE CONTROLLER ***** \\
// ****************************** \\

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Pam\Helper\Session;


/** *********************************\
* All control actions to the articles
*/
class ArticleController extends Controller
{

  /** ****************\
  * Reads all articles
  * @return mixed => the rendering of the view article
  */
  public function IndexAction()
  {
    // Reads all articles, then stores them
    $allArticles = ModelFactory::get('Article')->list();

    // Returns the rendering of the view blog with all articles
    return $this->render('blog/blog.twig', ['allArticles' => $allArticles]);
  }


  /** *******************\
  * Creates a new article
  * @return mixed => the rendering of the view createArticle
  */
  public function CreateAction()
  {
    // Checks if the form has been completed
    if (!empty($_POST))
    {
      // Uploads the image & gets back the file name
      $data['image'] = $this->upload('img/blog');

      // Creates the $data array to store the new article
      $data['title']        = $_POST['title'];
      $data['link']         = $_POST['link'];
      $data['content']      = $_POST['content'];
      $data['created_date'] = $_POST['date'];
      $data['updated_date'] = $_POST['date'];

      // Creates the article
      ModelFactory::get('Article')->create($data);

      // Creates a valid message to confirm the creation of a new article
      Session::createAlert('New article created successfully !', 'valid');

      // Redirects to the admin
      $this->redirect('admin');
    }
    else {
      // Returns the rendering of the view createArticle with the empty fields
      return $this->render('admin/createArticle.twig');
    }
  }


  /** ***********************************************************\
  * Reads an article, his comments & attributes the user comments
  * @return mixed => the rendering of the view readArticle
  */
  public function ReadAction()
  {
    // Gets the article id, then stores it
    $id = $_GET['id'];

    // Reads the article & his comments, then stores them
    $article  = ModelFactory::get('Article')->read($id);
    $comments = ModelFactory::get('Comment')->list($id, 'article_id');

    if(!empty($comments))
    {
      // Loops on each comment
      for ($i = 0; $i < count($comments); $i++)
      {
        // Stores the comment user_id value
        $userId = $comments[$i]['user_id'];

        // Reads the user table with $userId instead of the user id value, then stores the user results
        $user = ModelFactory::get('User')->read($userId);

        // Stores the first_name value & the image value with new keys
        $comments[$i]['user']   = $user['first_name'];
        $comments[$i]['image']  = $user['image'];
      }
    }
    // Returns the rendering of the view readArticle with the article & his comments
    return $this->render('blog/readArticle.twig', [
      'article'   => $article,
      'comments'  => $comments
    ]);
  }


  /** ****************\
  * Updates an article
  * @return mixed => the rendering of the view updateArticle
  */
  public function UpdateAction()
  {
    // Gets the article id, then stores it
    $id = $_GET['id'];

    // Checks if the form has been completed
    if (!empty($_POST))
    {
      // Checks if a new file has been uploaded
      if (!empty($_FILES['file']['name']))
      {
        // Uploads the image, then gets back the file name
        $data['image'] = $this->upload('img/blog');
      }
      // Retrieves form data & stores them
      $data['title']        = $_POST['title'];
      $data['link']         = $_POST['link'];
      $data['content']      = $_POST['content'];
      $data['updated_date'] = $_POST['date'];

      // Updates the article
      ModelFactory::get('Article')->update($id, $data);

      // Creates an info message to confirm the update of the selected article
      Session::createAlert('Successful modification of the selected article !', 'info');

      // Redirects to the admin
      $this->redirect('admin');
    }
    // Reads the article, then store it
    $article = ModelFactory::get('Article')->read($id);

    // Returns the rendering of the view updateArticle with the current article
    return $this->render('admin/blog/updateArticle.twig', ['article' => $article]);
  }


  /** ****************\
  * Deletes an article
  */
  public function DeleteAction()
  {
    // Gets the article id, then stores it
    $id = $_GET['id'];

    // Deletes the article
    ModelFactory::get('Article')->delete($id);

    // Creates a delete message to confirm the removal of the selected article
    Session::createAlert('Article permanently deleted !', 'delete');

    // Redirects to the admin
    $this->redirect('admin');
  }
}
