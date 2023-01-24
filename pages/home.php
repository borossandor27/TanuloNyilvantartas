<form action="index.php?menu=update" method="POST">
    <?php
    //$sql = "SELECT `tanuloid` AS \"Azonosító\",`nev` AS \"Tanuló neve\",`email`,`kepraw` AS \"profil kép\" FROM `users` WHERE `statusz`=0;";
    $sql = "SELECT * FROM `users` WHERE `statusz`=0;";
    echo $db->getTanulokHTML($sql, true);
    ?>
</form>
