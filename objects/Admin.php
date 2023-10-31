<?php

class Admin{
    private $conn;
    private $table_name ="admins";
    public $id;
    public $name;
    public $email;
    public $password;
    public function __construct($pdo){
        $this->conn = $pdo;
    }

    public function createAdmin() {
        $query = "INSERT INTO $this->table_name(name, email, password)
        VALUES(:name, :email, :password)";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if($stmt->execute()){
            return true;
    }
    return false;
    }

    public function deleteAdmin() {
        $query = "DELETE FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function updateAdmin() {
        $query = "UPDATE $this->table_name
                SET name = :name, email = :email, password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()){
            return true;
    }
    return false;
    }

    public function getAdminList() {
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}