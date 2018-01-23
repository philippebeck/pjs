<?php

// ****************************** \\
// ***** APP TWIG EXTENSION ***** \\
// ****************************** \\

namespace App\Helper;

use Pam\Model\ModelFactory;
use Pam\Helper\Session;


/** ********************************\
* Extends Twig with Application code
*/
class App_Twig_Extension extends \Twig_Extension
{

  /** ***********************************************************\
  * Returns an array of functions to add to the Twig functions
  * @return Twig_Function[] => the array who contains all functions for Twig
  */
  public function getFunctions()
  {
    // Returns an array of Twig functions
    return array(
      new \Twig_Function('adminEmail',  array($this, 'adminEmail'))
      // !! You can add new function calls here to use with Twig !!
    );
  }


  /** ************************************************\
  * Checks the connection then returns the admin email
  * @return string => the user email
  */
  public function adminEmail()
  {
    // Checks if a user is connected
    if (Session::isLogged() == false)
    {
      return null;
    }
    // Reads the admin datas, then stores it
    $admin = ModelFactory::get('User')->read(1);

    // Returns the admin email
    return $admin['email'];
  }

  // !! Add the new php functions here !!
}
