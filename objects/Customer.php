<?php

class Customer{
    private $conn;
    private $table_name = "customers";
    public $id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $shipping_address;
    public $billing_address;

    public function __construct($pdo){
        $this->conn = $pdo;
    }

    public function create() {
        $query = "INSERT INTO $this->table_name(name,email,password,phone,shipping_address,billing_address)
        VALUES (:name, :email, :password, :phone, :shipping_address, :billing_address)";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->shipping_address = htmlspecialchars(strip_tags($this->shipping_address));
        $this->billing_address = htmlspecialchars(strip_tags($this->billing_address));  

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":shipping_address", $this->shipping_address);
        $stmt->bindParam(":billing_address", $this->billing_address);

        if($stmt->execute())
        {
            return true;
        }
        return false;
    }

    public function customerAuthentication() {
        $query = "SELECT * FROM $this->table_name WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->name = $row["name"];
            return true;
        }
        return false;
    }

    public function allCustomer() {
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleCustomer() {
        $query = "SELECT * FROM $this->table_name WHERE id =:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id",$this->id);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row["name"];
        $this->email = $row["email"];
        $this->password = $row["password"];
        $this->phone = $row["phone"];
        $this->shipping_address = $row["shipping_address"];
        $this->billing_address = $row["billing_address"];
    }

    public function updateCustomer() {
        $query = "UPDATE $this->table_name
                SET name = :name, email = :email, password = :password, phone = :phone, shipping_address = :shipping_address,
                billing_address = :billing_address WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->shipping_address = htmlspecialchars(strip_tags($this->shipping_address));
        $this->billing_address = htmlspecialchars(strip_tags($this->billing_address));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":shipping_address", $this->shipping_address);
        $stmt->bindParam(":billing_address", $this->billing_address);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function deleteCustomer() {
        $query = "DELETE FROM $this->table_name WHERE id =:id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function getShippingAddress() {
        $query = "SELECT shipping_address FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->shipping_address = $row["shipping_address"];
    }
}