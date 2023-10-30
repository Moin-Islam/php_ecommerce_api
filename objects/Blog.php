<?php
class Blog{
    private $conn;
    private $table_name = "blogs";
    public $id;
    public $title;
    public $content;
    public $created_at;

    public function __construct($pdo){
        $this->conn = $pdo;
    }

    public function getBlog() {
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function createblog() {
        $query = "INSERT INTO $this->table_name(title,content) VALUES(:title, :content)";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);

        if($stmt->execute()){
            return true;
        }
        else false;
    }

    public function deleteBlog() {
        $query = "DELETE FROM $this->table_name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateBlog() {
        $query = "UPDATE $this->table_name
                 SET title = :title, content = :content WHERE id =:id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}