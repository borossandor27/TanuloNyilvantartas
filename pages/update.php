<pre>
    <?php
    $id = filter_input(INPUT_POST, "id");
    $adatok = $db->getTanulo($id);
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
            <label for="kep" class="form-label">kép fájl:</label>
            <input class="form-control" type="file" name="kep">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" value="true" name="modosit">Módosít</button>
        </div>
    </div><h1>update</h1>
</form>

