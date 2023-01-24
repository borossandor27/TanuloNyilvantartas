<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
<?php

class Database {

    protected $mysqli = null;
    protected $result = null;
    protected $fejlecNevek = array();
    protected static $errorString = null;
    protected static $error = false;

    function __construct($host = "localhost", $user = "root", $password = "", $db = "tanulok") {
        $this->mysqli = new mysqli($host, $user, $password, $db);

        if ($this->mysqli->connect_errno) {
//            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
            self::$errorString = $this->mysqli->connect_error;
            die();
        }
        // Change character set to utf8
        $this->mysqli->set_charset("utf8");
//        $this->mysqli->query("INSERT INTO `users` (`tanuloid`, `nev`, `jelszo`, `email`, `statusz`) VALUES (NULL, 'tanar', '" . password_hash('1234', PASSWORD_BCRYPT) . "', 'tanar@suli.hu', '1'); ");
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function validUser($username, $password) {
        $sql = "SELECT jelszo, tanuloid FROM `users` WHERE `nev` LIKE ?;";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $database_stored_password = $result->fetch_row()[0];

        if (password_verify($password, $database_stored_password)) {
            return true;
            $_SESSION['userid'] = $result->fetch_row()[1];
        } else {
            return false;
        }
    }

    function getTanulokHTML($sql, $update = false) {
        //-- Összes tanuló adatai HTML táblázatban ----

        $response = null;
        if ($this->result = $this->mysqli->query($sql)) {
            if ($this->result->num_rows > 0) {
                //-- Vannak megjelenítendő rekordok -----------
                $response = "<table class=\"table table-striped\">" . $this->getFejlecHTML($update) . "<tbody>";
                $row = null;
                while ($row = $this->result->fetch_assoc()) {
                    //-- Egy tanuló adatainak megjelenítése
                    $response .= "<tr>"
                            . "<td>" . $row['tanuloid'] . "</td>"
                            . "<td>" . $row['nev'] . "</td>"
                            . "<td>" . $row['email'] . "</td>"
                            . "<td>" . $row['kepnev'] . "</td>";
                    if ($row['kepraw'] == null) {
                        $response .= "<td>&nbsp</td>";
                    } else {
                        $response .= "<td><img class=\"col-2\""
                                . "src=\"data:" . $row['mime'] . ";base64, "
                                . base64_encode($row['kepraw']) . "\"/>"
                                . "</td>";
                    }
                    if ($update) {
                        $response .= "<td><button type=\"submit\" class=\"btn btn-info\" name=\"id\" value=\"" . $row['tanuloid'] . "\">Módosít</button></td>";
                    }
                    $response .= "</tr>";
                }
            } else {
                //-- Nincs tanuló!!!
                self::$error = true;
                self::$errorString = "Nincs tanuló!";
            }
        } else {
            //-- sikertelen lekérdezés --
            self::$error = true;
            self::$errorString = $this->mysqli->error;
        }
        $response .= "</tbody></table>";
        self::$error = false;
        return $response;
    }

    function getFejlecHTML($update) {
//        echo '<pre>';
//        var_dump($this->result->fetch_fields());
//        echo '</pre>';
        $fejlec = "<thead><tr>";
//        foreach ($this->result->fetch_fields() as $value) {
//            $this->fejlecNevek[] = $value->name;
//            $fejlec .= "<th>" . $value->name . "</th>";
//        }
        $fejlec .= "<th>Azonosító</th><th>Tanuló neve</th><th>Email cím</th><th>Kép neve</th><th>Profil kép</th>";
        $fejlec .= $update ? "<th>Módosítás</th>" : "";
        $fejlec .= "</tr></thead>";
        return $fejlec;
    }

    public function tanuloUpdate($id, $nev, $email, $kepbinary, $kepnev, $mimetype) {
        $sql = "INSERT INTO `users` ( `nev`, `email`, `kepnev`, `kepraw`, `mime`) "
                . "VALUES ($nev, $email, $kepnev, $kepbinary, $mimetype ) "
                . "WHERE `tanuloid`=$id";
        $this->result = $this->mysqli->query($sql);
        return $this->result == null ? false : true;
    }

    public function getTanulo($id) {
        $sql = "SELECT *  FROM `users` WHERE `tanuloid` = $id AND `statusz` = 0;";
        $result = $this->mysqli->query($sql);
        return $result->fetch_assoc();
    }

}
