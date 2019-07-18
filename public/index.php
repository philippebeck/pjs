<?php

// ===================================================== \\
// ======================= P J S ======================= \\
// ==================== Pam Jim Sam ==================== \\
// ===================================================== \\
// ========== https://github/philippebeck/pjs ========== \\
// ====== https://packagist.org/packages/pjs/pjs ======= \\
// ===================================================== \\

use Pam\Controller\FrontController;

// Loads Composer autoload
require_once '../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$frontController = new FrontController();

// Basic tests area
// print_r($_SESSION);
// var_dump($frontController);

$frontController->run();
