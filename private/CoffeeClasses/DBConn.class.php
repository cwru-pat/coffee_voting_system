<?php
/* @file
 * 
 * This file implements logic to create a basic mysqli connection.
 * 
 */
namespace CoffeeClasses;

/*
 * @var DBConn
 * A class used to connect to a database, perform basic validation, make calls, etc.
 */
class DBConn
{
    public $conn; // so functionality can be used directly if needed
    private $debug = FALSE;
    private $tables = NULL;

    public function __construct($database, $charset = "utf8")
    {
        $this->conn = new \mysqli($database['host'], $database['user'], $database['pass'], $database['name']);
        if($this->conn->connect_errno)
        {
            trigger_error("Failed to connect to MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error, E_USER_ERROR);
        }

        /* change character set */
        if(!$this->conn->set_charset($charset))
        {
            printf("Error loading character set {$charset}: %s\n", $this->conn->error);
        }

        $this->tables = $database['tables'];
    }

    public function setDebug($val)
    {
        $this->debug = $val ? TRUE : FALSE;
        return $this;
    }

    // kill script, display error message.
    public function showDatabaseError($message)
    {
        // Normal users just get a "Sorry", developers/debuggers get more details
        if($_SERVER['SERVER_NAME'] == 'localhost'  ||  $this->debug){
            die("<p>$message</p>\n");
        }
        else
        {
            die("<p>Uh-oh!  There was a problem with the database. Please try again later, and contact the website administrator if this message persists.</p>");
        }
    }

    public function mysqlEscape($val)
    {
        if($val === "")
        {
            return "";
        }
        elseif(is_numeric($val))
        {
            return $val;
        }
        elseif(is_string($val))
        {
            return $this->conn->real_escape_string($val);
        }
        else
        {
            $this->showDatabaseError("Error attempting to escape mysql data!");
        }
    }

    // return an array of result objects.
    public function dbQuery($query)
    {
        // print command if in debug mode
        if($this->debug){
            global $dbQueryCtr;
            $dbQueryCtr++;
            $this->printCommand($query);
        }

        $result = $this->conn->query($query);
        if($this->conn->error)
        {
            $this->showDatabaseError("Unable to perform database query!");
        }

        $rows = array();
        while ($row = $result->fetch_object())
        {
            $rows[] = $row;
        }

        $result->close();

        return $rows;
    }

    // just run a query, don't need to process return values
    public function dbCommand($command)
    {

        // print command if in debug mode
        if($this->debug){
            $this->printCommand($command);
        }

        $result = $this->conn->query($command);

        if($this->conn->error)
        {
            $this->showDatabaseError("Unable to execute database command!");
        }

        return $this;
    }


    // We can hopefully transition to using bound statements at some point
    function boundCommand($statement, $params /* array of references; first entry is type string */)
    {
        $statement = $this->conn->prepare($statement);
        if(!$statement) {
            $this->showDatabaseError("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error, E_USER_ERROR);
        }
        call_user_func_array(array($statement,'bind_param'), $params);
        $statement->execute();
        $statement->close();
        return;
    }

    // Use this to get results
    function boundQuery($statement, $params /* array of references */, $return_statement = FALSE)
    {
        // prepare, execute, then return either the statement or entire result set.
        $statement = $this->conn->prepare($statement);
        if(!$statement) {
            $this->showDatabaseError("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error, E_USER_ERROR);
        }
        call_user_func_array(array($statement,'bind_param'), $params);
        $statement->execute();
        if($return_statement) {
            return $statement;
        }
        $statement->store_result();
        $meta = $statement->result_metadata();

        // extract column names and bind to vars
        $cols = array();
        $data = array();
        while($column = $meta->fetch_field()) {
            $cols[] = &$data[$column->name];
        }
        call_user_func_array(array($statement, 'bind_result'), $cols);
        
        // amass results (less than ideal - return the statement if
        // optimization is needed?)
        $array = array(); $i=0;
        while($statement->fetch()) {
            $array[$i] = array();
            foreach($data as $k=>$v)
                $array[$i][$k] = $v;
            $i++;
        }

        $statement->close();
        return $array;
    }

    function dbDebug($query)
    {
        echo "<table border='1'>";
        foreach($this->dbQuery($query) as $result)
        {
            echo "<tr>";
            foreach(get_object_vars($result) as $property => $value)
            {
                echo "<td>" . htmlEntities($value) . "</td>"; 
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function printCommand($command)
    {
        if(strlen($command) < 1010) {
            $commandForShow =  $command;
        } else {
            $commandForShow =  substr($command,0,1000) . '[...' . (strlen($command)-1000) . '...]';;
        }
        echo "\n\n<!-- \n{$commandForShow}\n -->\n\n";

        return $this;
    }

    public function createTables()
    {
        foreach($this->tables as $table_name => $columns) {
            $query = "CREATE TABLE IF NOT EXISTS " . $table_name . " (id INT(11) NOT NULL AUTO_INCREMENT ";
            foreach($columns as $field => $type) {
                $query .= ", " . $field . " " . $type;
            }
            $query .= " , PRIMARY KEY (id) )";
            $this->dbCommand($query);
        }

        return $this;
    }

}
