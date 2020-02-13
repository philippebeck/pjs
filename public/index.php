<?php

// ===================================================== \\
// ======================= P J S ======================= \\
// ==================== Pam Jim Sam ==================== \\
// ===================================================== \\
// ========== https://github/philippebeck/pjs ========== \\
// ====== https://packagist.org/packages/pjs/pjs ======= \\
// ===================================================== \\

use Pam\Router;

require_once '../vendor/autoload.php';
require_once '../config/parameters.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();
$router->run();
