<?php
class db_method
{
    public $table;
    private $handle;
    private $filter = "";
    private $variables = array();

    public function __construct()
    {
        $this->table = $this->table_name;
        $app_setting = $this->get_app_setting();
        $this->connect($app_setting::DB_HOST, $app_setting::DB_NAME, $app_setting::DB_USER, $app_setting::DB_PASSWORD);
        $this->check_table($app_setting::META_TABLE, $app_setting::SQL);
    }

    private function connect($host, $dbname, $user, $pass)
    {
        try
        {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $host, $dbname);

            $this->handle = new \PDO($dsn, $user, $pass);

            $this->handle->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->handle->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //$this->handle->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, FALSE);
            //$this->handle->setAttribute(\PDO::ATTR_EMULATE_PREPARES, FALSE);
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }
    }

    private function check_table($meta_table, $sql)
    {
        try
        {
            $this->handle->query("SELECT * FROM `" . $meta_table . "`");
        }
        catch (\PDOException $e)
        {
            try
            {
                $this->handle->query($sql);
            }
            catch (\PDOException $e)
            {
                print "Error!: " . $e->getMessage() . "<br/>";
                exit();
            }
        }
    }

    /*
     * Raw query.
     */
    public function raw($sql)
    {
        $this->filter = "";

        $sth = $this->handle->prepare($sql);

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $record = $sth->fetchAll();

        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );
    }
    /*
     * # Fetch functions.
     */
    public function select()
    {
        $sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);
        $this->filter = "";

        //print "<pre>";
        //print "[" . $sql . "]\n";
        //print_r($this->variables);
        //print "</pre>";

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($this->variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }
        $this->variables = array();

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $record = $sth->fetchAll();

        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );
    }

    public function select_count()
    {
        $sql = sprintf("SELECT COUNT(*) FROM `%s` %s", $this->table, $this->filter);
        $this->filter = "";

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($this->variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }
        $this->variables = array();

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $record = $sth->fetchColumn();

        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );
    }

    public function select_first()
    {
        $sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);
        $this->filter = "";

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($this->variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }
        $this->variables = array();

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $record = $sth->fetch();

        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );
    }

    public function select_by_id($id)
    {
        $sql = sprintf("SELECT * FROM `%s` WHERE `id` = :id", $this->table);
        $this->filter = "";

        $sth = $this->handle->prepare($sql);
        $sth->bindValue(":id", $id, \PDO::PARAM_INT);

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $record = $sth->fetch();

        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );
    }

    /*
     * # Modification functions.
     */

    public function add($data)
    {
        $keys = array();
        $params = array();
        $variables = array();
        foreach ($data as $key => $value)
        {
            $keys[] = sprintf("`%s`", $key);
            $params[] = "?";

            if (is_null($value))
            {
                $type = \PDO::PARAM_NULL;
            }
            else if (is_bool($value))
            {
                $type = \PDO::PARAM_BOOL;
            }
            else if (is_int($value))
            {
                $type = \PDO::PARAM_INT;
            }
            else
            {
                $type = \PDO::PARAM_STR;
            }
            $one_variable = array();
            $one_variable["value"] = $value;
            $one_variable["type"] = $type;

            $variables[] = $one_variable;
        }

        $keys_string = implode(", ", $keys);
        $params_string = implode(", ", $params);

        $sql = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $this->table, $keys_string, $params_string);

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $row_count = $sth->rowCount();
        $last_id = $this->handle->lastInsertId();

        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
            "last_id" => $last_id,
        );
    }

    public function update($data)
    {
        $updates = array();
        $variables = array();
        foreach ($data as $key => $value)
        {
            $updates[] = sprintf("`%s` = ?", $key);

            if (is_null($value))
            {
                $type = \PDO::PARAM_NULL;
            }
            else if (is_bool($value))
            {
                $type = \PDO::PARAM_BOOL;
            }
            else if (is_int($value))
            {
                $type = \PDO::PARAM_INT;
            }
            else
            {
                $type = \PDO::PARAM_STR;
            }
            $one_variable = array();
            $one_variable["value"] = $value;
            $one_variable["type"] = $type;

            $variables[] = $one_variable;
        }
        $updates_string = implode(", ", $updates);

        $sql = sprintf("UPDATE `%s` SET %s %s", $this->table, $updates_string, $this->filter);
        $this->filter = "";

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }

        $i = count($variables) + 1;
        foreach ($this->variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }
        $this->variables = array();

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $row_count = $sth->rowCount();

        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );
    }

    public function update_by_id($id, $data)
    {
        $updates = array();
        $variables = array();
        foreach ($data as $key => $value)
        {
            $updates[] = sprintf("`%s` = ?", $key);

            if (is_null($value))
            {
                $type = \PDO::PARAM_NULL;
            }
            else if (is_bool($value))
            {
                $type = \PDO::PARAM_BOOL;
            }
            else if (is_int($value))
            {
                $type = \PDO::PARAM_INT;
            }
            else
            {
                $type = \PDO::PARAM_STR;
            }
            $one_variable = array();
            $one_variable["value"] = $value;
            $one_variable["type"] = $type;

            $variables[] = $one_variable;
        }
        $updates_string = implode(", ", $updates);

        $sql = sprintf("UPDATE `%s` SET %s WHERE `id` = ?", $this->table, $updates_string);

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }

        $i = count($variables) + 1;
        $sth->bindValue($i, $id, \PDO::PARAM_INT);

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $row_count = $sth->rowCount();

        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );
    }

    public function delete()
    {
        // Strange，$this->filter has value, but still print message.
        //if ($this->filter === "");
        //{
        //    var_dump( "WHERE `article_id` = ?" === "");
        //    print "Are you want delete all?";
        //    exit();
        //}
        $sql = sprintf("DELETE FROM `%s` %s", $this->table, $this->filter);
        $this->filter = "";

        $sth = $this->handle->prepare($sql);

        $i = 1;
        foreach ($this->variables as $one_variable)
        {
            $sth->bindValue($i, $one_variable["value"], $one_variable["type"]);
            $i = $i + 1;
        }
        $this->variables = array();

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $row_count = $sth->rowCount();

        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );
    }

    public function delete_by_id($id)
    {
        $sql = sprintf("DELETE FROM `%s` WHERE `id` = :id", $this->table);

        $sth = $this->handle->prepare($sql);
        $sth->bindValue(":id", $id, \PDO::PARAM_INT);

        try
        {
            $sth->execute();
        }
        catch (\PDOException $e)
        {
            print "Error!: " . $e->getMessage() . "<br/>";
            exit();
        }

        $errorcode = $sth->errorCode();
        $row_count = $sth->rowCount();

        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );
    }

    /*
     * ## Fetch filter functions
     */

    public function where($where = array())
    {
        if (isset($where))
        {
            $where_final = array();
            foreach ($where as $one_where)
            {
                if (isset($one_where["value"]))
                {
                    $where_final[] = sprintf("`%s` %s ? %s", $one_where["field"], $one_where["operator"], $one_where["condition"]);

                    if (is_null($one_where["value"]))
                    {
                        $type = \PDO::PARAM_NULL;
                    }
                    else if (is_bool($one_where["value"]))
                    {
                        $type = \PDO::PARAM_BOOL;
                    }
                    else if (is_int($one_where["value"]))
                    {
                        $type = \PDO::PARAM_INT;
                    }
                    else
                    {
                        $type = \PDO::PARAM_STR;
                    }

                    $one_variable = array();
                    $one_variable["value"] = $one_where["value"];
                    $one_variable["type"] = $type;

                    $this->variables[] = $one_variable;
                }
                else
                {
                    $where_final[] = sprintf("`%s` %s %s", $one_where["field"], $one_where["operator"], $one_where["condition"]);
                }
            }

            $this->filter .= " WHERE ";
            $this->filter .= implode(" ", $where_final);
        }

        return $this;
    }

    public function order($order = array())
    {
        if(isset($order)) {
            $this->filter .= " ORDER BY ";
            $this->filter .= implode(", ", $order);
        }

        return $this;
    }

    public function limit($limit = array())
    {
        if(isset($limit)) {
            $this->limit .= " LIMIT ";
            $this->limit .= implode(", ", $limit);
        }

        return $this;
    }
}
?>
