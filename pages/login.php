<?php
if (filter_input(INPUT_POST, "login", FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
    //-- a belépési adatok ellenőrzése ---------------
    echo 'Adatok ellenőrzése';
    $username = htmlspecialchars(filter_input(INPUT_POST, "username"));
    $password = filter_input(INPUT_POST, "password");
    if ($db->validUser($username, $password)) {
        //-- azonosítás sikeres ------------
        $_SESSION['login'] = true;
        $_SESSION['user'] = true;

        header("Location: index.php");
    } else {
        echo 'Rossz a jelszó';
    }
    //$_SESSION['login'] = ;
}
?>
<div class="container">
    <h1>Belépés</h1>
    <form method="POST" class="  col-6">
        <div class="form-group justify-content-center">
            <input type="text" name="username" placeholder="felhasználó név"  class="form-control">
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="jelszó" class="form-control">
        </div>
        <div class="form-group">
            <button name="login" value="true"  class="btn btn-success">Belépés</button>
        </div>
    </form>
</div>
<?php



