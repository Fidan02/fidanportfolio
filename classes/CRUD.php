<?php

include 'Database.php';

class CRUD {
    private $mysqli;

    public function __construct() {
        $db = Database::getInstance();
        $this->mysqli = $db->getConnection();
    }

    public function create($table, $data) {
        $sql = "INSERT INTO `" . $table . "` SET ";

        if(count($data)) {
            $count = 1;

            foreach($data as $column => $value) {
                if(count($data) > $count) {
                    $sql .= "`".$column."`='".$this->mysqli->real_escape_string($value)."', ";
                } else {
                    $sql .= "`".$column."`='".$this->mysqli->real_escape_string($value)."'";
                }

                $count++;
            }
        }

        return $this->mysqli->query($sql) ? true : $this->mysqli->error;
    }
    
    public function read($table, $condition = [], $limit = null, $order = []) {
        $sql = "SELECT * FROM `".$table."`";
        $items = [];

        if(count($condition)) {
            $sql .= " WHERE `".$condition['column']."`='".$condition['value']."'";
        }

        if(count($order) == 2) {
            $sql .= " ORDER BY " .$order['column'] ." " .$order['order'];
        }
        
        if(!is_null($limit)) {
            $sql .= " LIMIT " .$limit;
        }

        if($query = $this->mysqli->query($sql)) {
            if($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                    $items[] = $row;
                }
            }

            return $items;
        } else {
            return $this->mysqli->error;
        }
    }

    public function update($table, $data, $condition = []) {
        $sql = "UPDATE `".$table."` SET ";

        if(count($data)) {
            $count = 1;

            foreach($data as $column => $value) {
                if(count($data) > $count) {
                    $sql .= "`".$column."`='".$this->mysqli->real_escape_string($value)."', ";
                } else {
                    $sql .= "`".$column."`='".$this->mysqli->real_escape_string($value)."'";
                }

                $count++;
            }
        }

        if(count($condition)) {
            $sql .= " WHERE `".$condition['column']."`='".$condition['value']."'";
        }

        return $this->mysqli->query($sql) ? true : $this->mysqli->error;
    }

    public function delete($table, $condition = [], $limit = null) {
        $sql = "DELETE FROM `".$table."`";
        $items = [];

        if(count($condition)) {
            $sql .= " WHERE `".$condition['column']."`='".$condition['value']."'";
        }

        if(!is_null($limit)) {
            $sql .= " LIMIT " .$limit;
        }

        return $this->mysqli->query($sql) ? true : $this->mysqli->error;
    }

    public function search($table, $column, $value) {
        $sql = "SELECT * FROM `".$table."` WHERE `".$column."` LIKE '%".$value."%'";
        $items = [];

        if($query = $this->mysqli->query($sql)) {
            if($query->num_rows > 0) {
                while($row = $query->fetch_assoc()) {
                    $items[] = $row;
                }
            }

            return $items;
        } else {
            return $this->mysqli->error;
        }
    }
}