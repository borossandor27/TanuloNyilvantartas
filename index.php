<?php
header('Content-Type: text/html; charset=utf-8'); //-- válaszfájl kódolásának a beállítása
session_start(); //-- állapotok tárolása
include_once './classes/Database.php'; //-- adatkapcsolat kezelő osztály betöltése
$db = new Database(); //-- adatkapcsolat kezelő osztály példányosítása

$login = isset($_SESSION['login']) ? $_SESSION['login'] : false; //-- belépett-e egy regisztrált felhasználó
$menu = htmlspecialchars(filter_input(INPUT_GET, "menu"));
?>
<!DOCTYPE html>
<!--
    Iskolai tanuló nyilvántartás

    - Csak regisztrált tanulók és egyetlen tanár használhatja
    - A tanuló megnézheti a jegyeit
    - A tanár regisztrálhat tanulót és írhat be jegyet.
-->
<html lang="hu">
    <head>
        <?php require_once './layout/head.php'; ?>
    </head>
    <body>
        <div class="container min-vh-100">
            <?php
            if ($login) {
                //-- védett oldal megjeleníthető -------
                //-- sikeresen belépett ----------------
                require_once './layout/menu.php';
                require_once './tartalom.php';
            } else {
                //-- csak belépési lehetőség -----------
                include_once './pages/login.php';
            }
            ?>
        </div>
    </body>
</html>
