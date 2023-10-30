<?php

class Product{
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $price;
    public $description;
    public $image;
    public $quantity;
    public $size;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function read(){
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt-> execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO $this->table_name (name, price, description, image, quantity, size)
        VALUES (:name, :price, :description, :image, :quantity, :size)";
        $stmt = $this->conn->prepare($query);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->size = htmlspecialchars(strip_tags($this->size));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":size", $this->size);

        if($stmt->execute()){
            return true;
        }
        return false;

    }

    public function update() {
        $query = "Update $this->table_name
                 SET name = :name, price = :price, description = :description, image = :image, quantity = :quantity, size = :size
                 WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->size = htmlspecialchars(strip_tags($this->size));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":size", $this->size);
       

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function readOne() {
        $query = "SELECT * FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        $stmt-> execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row["name"];
        $this->price = $row["price"];
        $this->description = $row["description"];
        $this->image = $row["image"];
        $this->quantity = $row["quantity"];
        $this->size = $row["size"];
    }

    public function delete() {

        $query = "DELETE FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}