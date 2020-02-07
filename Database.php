<?php
class Database
{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname;
    private $dblink; // veza sa bazom
    private $result; // Holds the MySQL query result
    private $records; // Holds the total number of records returned
    private $affected; // Holds the total number of affected rows
    function __construct($dbname)
    {
        $this->dbname = $dbname;
        $this->Connect();
    }
    /*
function __destruct()
{
$this->dblink->close();
//echo "Konekcija prekinuta";
}
*/
    public function getResult()
    {
        return $this->result;
    }
    //konekcija sa bazom
    function Connect()
    {
        $this->dblink = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if ($this->dblink->connect_errno) {
            printf("Konekcija neuspešna: %s\n", $this->dblink->connect_error);
            exit();
        }
        $this->dblink->set_charset("utf8");
        //echo "Uspesna konekcija";
    }
    //select funkcija
    function select($table , $rows , $where , $order )
    {
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null)
            $q .= ' WHERE ' . $where;
        if ($order != null)
            $q .= ' ORDER BY ' . $order;

       return $this->ExecuteQuery($q);
        //print_r($this->getResult()->fetch_object());
    }

    function insert($table , $rows, $values)
    {
        $insert = 'INSERT INTO ' . $table;
        if ($rows != null) {
            $insert .= ' (' . $rows . ')';
        }
        $insert .= ' VALUES (' ;
        for ($i = 0; $i < count($values); $i++) {
            if (is_numeric ($values[$i])){
                $insert.=$values[$i];
            }else {
                $insert.="'".$values[$i]."'";
            }
            $insert.=",";
        }
        $insert = substr($insert, 0, -1);
        $insert .= ')';
        //echo $insert;
    
            if ($this->ExecuteQuery($insert)){
                return true;
            }else {
                return false;
            }
      
    
    }
    function update($table , $id, $keys, $values)
    {
        $set_query = array();
        for ($i = 0; $i < sizeof($keys); $i++) {
            $set_query[] = $keys[$i] . " = '" . $values[$i] . "'";
        }
        $set_query_string = implode(',', $set_query);


        $update = "UPDATE " . $table . " SET " . $set_query_string . " WHERE id=" . $id;
        if (($this->ExecuteQuery($update)) && ($this->affected > 0))
            return true;
        else return false;
    }
    function delete($table,  $keys, $values)
    {
        $delete = "DELETE FROM " . $table . " WHERE " . $keys[0] . " = '" . $values[0] . "'";
        //echo $delete;
        if ($this->ExecuteQuery($delete))
            return true;
        else return false;
    }

    //funkcija za izvrsavanje upita
    function ExecuteQuery($query)
    {
        if ($this->result = $this->dblink->query($query)) {
            if (isset($this->result->num_rows)) $this->records = $this->result->num_rows;
            if (isset($this->dblink->affected_rows)) $this->affected = $this->dblink->affected_rows;
            // echo "Uspesno izvrsen upit";
            return true;
        } else {
            return false;
        }
    }

    function updateCards ($id, $value){
        $q = "UPDATE film SET brojKarata = '$value' where id = '$id'";
        //echo "'$q'";
      return  $this->ExecuteQuery($q);
    }

    function getMovieAndDirector ($id){
        $q = "SELECT f.*, r.ime, r.prezime  FROM film f
        INNER JOIN reziser r ON f.reziser = r.id  WHERE f.id='$id'";
        $this->ExecuteQuery($q);
    }

    function getReservation ($id){
        $q = "SELECT r.datum , r.brojKarata, f.naziv FROM rezervacije r
        INNER JOIN film f ON r.filmId = f.id WHERE r.korisnikId ='$id'";
        $this->ExecuteQuery($q);
    }


    function CleanData()
    {
        //mysql_string_escape () uputiti ih na skriptu vezanu za bezbednost i sigurnost u php aplikacijama!!
    }
}
