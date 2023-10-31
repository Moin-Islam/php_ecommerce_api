<?php

class Order{
    private $conn;
    private $table_name = "orders";
    public $id;
    public $admin_id;
    public $customer_id;
    public $order_date;
    public $order_total;
    public $order_status;
    public $created_at;

    public function __construct($pdo){
        $this->conn = $pdo;
    }

    public function getAllOrder() {
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function createOrder() {
        $query = "INSERT INTO $this->table_name(admin_id, customer_id, order_total, order_status)
                  VALUES (:admin_id, :customer_id, :order_total, :order_status)";
        $stmt = $this->conn->prepare($query);


        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->order_date = htmlspecialchars(strip_tags($this->order_date));
        $this->order_total = htmlspecialchars(strip_tags($this->order_total));
        $this->order_status = htmlspecialchars(strip_tags($this->order_status));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(":admin_id", $this->admin_id);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":order_total", $this->order_total);
        $stmt->bindParam(":order_status", $this->order_status);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function deleteOrder() {
        $query = "DELETE FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function updateOrder() {
        $query = "UPDATE $this->table_name
                SET admin_id = :admin_id, customer_id = :customer_id, order_total = :order_total, order_status = :order_status
                WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->order_total = htmlspecialchars(strip_tags($this->order_total));
        $this->order_status = htmlspecialchars(strip_tags($this->order_status));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":admin_id", $this->admin_id);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":order_total", $this->order_total);
        $stmt->bindParam(":order_status", $this->order_status);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function getOrderById() {
        $query = "SELECT * FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->admin_id = $row["admin_id"];
        $this->customer_id = $row["customer_id"];
        $this->order_date = $row["order_date"];
        $this->order_total = $row["order_total"];
        $this->order_status = $row["order_status"];
        $this->created_at = $row["created_at"];
    }

    public function exists() {
        $query = "SELECT 1 FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        return false;
    }

    public function cancelOrder() {
        
        $cancel = "cancelled";
        $query = "UPDATE $this->table_name
                SET order_status = :order_status WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":order_status", $cancel);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

}