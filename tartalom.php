<?php

switch ($menu) {
    case "home":
        require_once './pages/home.php';
        break;
    case "update":
        require_once './pages/update.php';
        break;
    case "jegyek":
        echo 'jegyek írása';
        break;
    case "logout":
        require_once './pages/logout.php';
        break;

    default:
        break;
}
