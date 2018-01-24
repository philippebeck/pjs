<?php

// ===================================================== \\
// ======================= P J S ======================= \\
// ==================== Pam Jim Sam ==================== \\
// ===================================================== \\
// ========== https://github/philippebeck/pjs ========== \\
// ====== https://packagist.org/packages/pjs/pjs ======= \\
// ===================================================== \\



// ************************ \\
// ***** Installation ***** \\

// To install via Composer :
//$ composer require pjs/pjs



// ******************** \\
// ***** Overview ***** \\

// Pjs, a microCMS for coding in pyjamas !

// You will find a lot of features to construct a website :
//    Php classes provided by Pam, the Php Appoachable Microframework
//    JavaScript functions provided by Jim, the Javascript Interactive Microlibrary
//    Css classes provided by Sam, the Scss Animated Microframework
//    Filters & classes in the views by Twig, the Symfony Template Engine
//    And others tools provided by Pjs, the microCMS

// Pjs is a study project, but don't hesitate to send issues or pull requests, I will watch them with interest...

// Enjoy !!



// ************************* \\
// ***** Documentation ***** \\

// The documentation will be available the next week...



// ************************ \\
// ***** Contribution ***** \\

// Pjs needs you if you like it : sends pull requests on GitHub to improve it !!



use Pam\Controller\FrontController;


// Loads Composer autoload
require_once dirname(__DIR__).'/vendor/autoload.php';


// Creates a front controller instance
$frontController = new FrontController();


// Basic tests area
// print_r($_SESSION);
// var_dump($frontController);


// Calls the run method on the front controller instance
$frontController->run();
