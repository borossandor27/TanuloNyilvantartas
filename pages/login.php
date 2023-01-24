<?php
if (filter_input(INPUT_POST, "login", FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)) {
    //-- a belépési adatok ellenőrzése ---------------
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
<div class="d-flex align-items-center justify-content-center m-3">
    <form method="POST" class="col-sm-10 col-md-3">
        <fieldset class="p-4">
            <legend>Belépés</legend>
            <div class="form-group m-3">
                <input type="text" name="username" placeholder="felhasználó név"  class="form-control">
            </div>
            <div class="form-group m-3">
                <input type="password" name="password" placeholder="jelszó" class="form-control">
            </div>
            <div class="form-group m-3">
                <button name="login" value="true"  class="btn btn-success">Belépés</button>
            </div>
        </fieldset>
    </form>
</div>
<?php



