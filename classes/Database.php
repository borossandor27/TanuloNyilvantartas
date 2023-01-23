
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
//        $this->mysqli->query("INSERT INTO `users` (`tanuloid`, `nev`, `jelszo`, `email`, `kep`, `statusz`) VALUES (NULL, 'tanar', '" . password_hash('1234', PASSWORD_BCRYPT) . "', 'tanar@suli.hu', NULL, '1'); ");
    }

    function __destruct() {
        $this->mysqli->close();
    }

    function validUser($username, $password) {
        $sql = "SELECT jelszo FROM `users` WHERE `nev` LIKE ?;";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $database_stored_password = $result->fetch_row()[0];

        if (password_verify($password, $database_stored_password)) {
            return true;
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
                while ($row = $this->result->fetch_assoc()) {
                    //-- Egy tanuló adatainak megjelenítése
                    $response .= "<tr>";
                    foreach ($row as $value) {
                        $response .= "<td>$value</td>";
                    }

                    if ($update) {
                        $response .= "<td><button type=\"submit\" class=\"btn btn-info\" name=\"id\" value=\"" . $row['Azonosító'] . "\">Módosít</button></td>";
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
        foreach ($this->result->fetch_fields() as $value) {
            $this->fejlecNevek[] = $value->name;
            $fejlec .= "<th>" . $value->name . "</th>";
        }
        $fejlec .= $update ? "<th>Módosítás</th>" : "";
        $fejlec .= "</tr></thead>";
        return $fejlec;
    }

    public function tanuloUpdate($id, $nev, $email, $kep) {

    }

    public function getTanulo($id) {
        $sql = "SELECT *  FROM `users` WHERE `tanuloid` = $id AND `statusz` = 0;";
        $result = $this->mysqli->query($sql);
        return $result->fetch_assoc();
    }

}
