<pre>
    <?php

    function kepfajlbinary($upload) {
        if ($binary = getimagesize($upload)) {
            // -- van kép --
            return file_get_contents($upload);
        } else {
            // --  'nincs kép' ---
            return NULL;
        }
    }

    $id = null;
    $adatok = null;
    if (filter_input(INPUT_POST, "modosit", FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE)) {
        //-- Módosítási kérelem feldolgozása ------------------
        var_dump($_FILES);
        $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        $uploadfile = $_FILES['profilkep']['tmp_name'];
        $kepbinary = kepfajlbinary($uploadfile);
        $mimetype = $_FILES['profilkep']['mime'];
        $kepnev = $_FILES['profilkep']['name'];
        $db->tanuloUpdate($id, $name, $email, $kepbinary, $kepnev, $mimetype);
    } else {
        $id = filter_input(INPUT_POST, "id");
        $adatok = $db->getTanulo($id);
    }
    var_dump($_POST);
    var_dump($_FILES);
    ?>
</pre>
<form action="#" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT); ?>">
    <div class="container">
        <div class="form-group">
            <label for="name">Név</label>
            <input type="text" class="form-control" name="name" value="<?php echo $adatok['nev']; ?>">
        </div>
        <div class="form-group">
            <label for="email">Név</label>
            <input type="email" class="form-control" name="email" value="<?php echo $adatok['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="profilkep" class="form-label">kép fájl:</label>
            <input class="form-control" type="file" name="profilkep">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" value="true" name="modosit">Módosít</button>
        </div>
    </div><h1>update</h1>
</form>

