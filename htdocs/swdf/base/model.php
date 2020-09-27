<?php
namespace swdf\base;

abstract class model
{
    private $table = NULL;
    private $filter = NULL;
    private $variables = array();


    /**
     *
     *
     */
    public function __construct()
    {
        $this->table = $this->get_table_name();
    }


    /**
     *
     *
     */
    abstract public function get_table_name();


    /*
     * Raw query.
     */
    public function raw($sql)
    {
        $this->filter = NULL;

        $sth = \swdf::$app->db->prepare($sql);

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
        $this->filter = NULL;

        //print "<pre>";
        //print "[" . $sql . "]\n";
        //print_r($this->variables);
        //print "</pre>";

        $sth = \swdf::$app->db->prepare($sql);

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


    /**
     *
     *
     */
    public function select_count()
    {
        $sql = sprintf("SELECT COUNT(*) FROM `%s` %s", $this->table, $this->filter);
        $this->filter = NULL;

        $sth = \swdf::$app->db->prepare($sql);

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


    /**
     *
     *
     */
    public function select_first()
    {
        $sql = sprintf("SELECT * FROM `%s` %s", $this->table, $this->filter);
        $this->filter = NULL;

        $sth = \swdf::$app->db->prepare($sql);

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


    /**
     *
     *
     */
    public function select_by_id($id)
    {
        $sql = sprintf("SELECT * FROM `%s` WHERE `id` = :id", $this->table);
        $this->filter = NULL;

        $sth = \swdf::$app->db->prepare($sql);
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


    /**
     *
     *
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

        $sth = \swdf::$app->db->prepare($sql);

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
        $last_id = \swdf::$app->db->lastInsertId();

        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
            "last_id" => $last_id,
        );
    }


    /**
     *
     *
     */
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
        $this->filter = NULL;

        $sth = \swdf::$app->db->prepare($sql);

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


    /**
     *
     *
     */
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

        $sth = \swdf::$app->db->prepare($sql);

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


    /**
     *
     *
     */
    public function delete()
    {
        $sql = sprintf("DELETE FROM `%s` %s", $this->table, $this->filter);
        $this->filter = NULL;

        $sth = \swdf::$app->db->prepare($sql);

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


    /**
     *
     *
     */
    public function delete_by_id($id)
    {
        $sql = sprintf("DELETE FROM `%s` WHERE `id` = :id", $this->table);

        $sth = \swdf::$app->db->prepare($sql);
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


    /**
     *
     * SELECT `column` FROM `table`
     * WHERE
     *     `article_id` = (int) $article["id"]
     *     AND
     *     `target_id` IS NULL;
     *
     *
     * $where = array(
     *     array(
     *         "field" => "article_id",
     *         "value" => (int) $article["id"],
     *         "operator" => "=",
     *         "condition" => "AND",
     *     ),
     *     array(
     *         "field" => "target_id",
     *         "operator" => "IS NULL",
     *         "condition" => "",
     *     ),
     * );
     */
    public function where($where = array())
    {
        if (isset($where))
        {
            $where_list = array();
            foreach ($where as $one_where)
            {
                if (isset($one_where["value"]))
                {
                    $where_list[] = sprintf("`%s` %s ? %s", $one_where["field"], $one_where["operator"], $one_where["condition"]);

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
                    $where_list[] = sprintf("`%s` %s %s", $one_where["field"], $one_where["operator"], $one_where["condition"]);
                }
            }

            $this->filter .= " WHERE ";
            $this->filter .= implode(" ", $where_list);
        }

        return $this;
    }


    /**
     *
     * SELECT `column` FROM `table`
     * WHERE
     *     `article_id` = (int) $article["id"]
     *     AND
     *     `target_id` IS NULL;
     *
     *
     * $where = array(
     *     "AND",
     *     array(
     *         array(
     *             "field" => "article_id",
     *             "value" => (int) $article["id"],
     *             "operator" => "=",
     *         ),
     *         array(
     *             "field" => "target_id",
     *             "operator" => "IS NULL",
     *         ),
     *     )
     * );
     */
    public function batch_where($where = array())
    {
        if (isset($where))
        {
            $where_list = array();
            foreach ($where[1] as $one_where)
            {
                if (isset($one_where["value"]))
                {
                    $where_list[] = sprintf("`%s` %s ?", $one_where["field"], $one_where["operator"]);

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
                    $where_list[] = sprintf("`%s` %s", $one_where["field"], $one_where["operator"]);
                }
            }

            $this->filter .= " WHERE ";
            $this->filter .= implode(" " . $where[0] . " ", $where_list);
        }
        else
        {
        }

        return $this;
    }


    /**
     *
     *
     */
    public function order($order = array())
    {
        if(isset($order)) {
            $this->filter .= " ORDER BY ";
            $this->filter .= implode(", ", $order);
        }

        return $this;
    }


    /**
     *
     *
     */
    public function limit($limit = array())
    {
        if(isset($limit)) {
            $this->filter .= " LIMIT ";
            $this->filter .= implode(", ", $limit);
        }

        return $this;
    }
}
?>
