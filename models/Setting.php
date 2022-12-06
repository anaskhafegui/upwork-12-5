<?php
class Setting
{
    // DB Related
    private $conn;
    private $table = "settings";

    // Post Properties
    public $id;
    public $type;
    public $value;
    public $user;
    public $timestamp;

    // Construct with Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get All Settings
    public function read()
    {
        $query = "SELECT
        *
        FROM {$this->table} 
        ";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Get a Single Category
    public function single()
    {
        $query = "SELECT *
        FROM {$this->table} 
        WHERE id = ?
        LIMIT 0,1
        ";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            // Get the category
            $setting = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->type = $setting["type"];
            $this->value = $setting["value"];
            $this->user = $setting["user"];
            $this->timestamp = $setting["timestamp"];

            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Create a Category
    public function create()
    {
        $query = "INSERT INTO {$this->table} 
        SET 
        type = :type,
        value = :value,
        user = :user,
        timestamp = :timestamp";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->type = htmlspecialchars(strip_tags(trim($this->type)));
        $this->value = htmlspecialchars(strip_tags(trim($this->value)));
        $this->user = htmlspecialchars(strip_tags(trim($this->user)));
        $this->timestamp = htmlspecialchars(strip_tags(trim($this->timestamp)));

        // Bind Data
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":value", $this->value);
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":timestamp", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Update a Category
    public function update()
    {
        $query = "UPDATE {$this->table} 
        SET 
        type = :type,
        value = :value,
        user = :user,
        timestamp = :timestamp
        WHERE id = :id";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));
        $this->type = htmlspecialchars(strip_tags(trim($this->type)));
        $this->value = htmlspecialchars(strip_tags(trim($this->value)));
        $this->user = htmlspecialchars(strip_tags(trim($this->user)));
        $this->timestamp = htmlspecialchars(strip_tags(trim($this->timestamp)));

        // Bind Data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":value", $this->value);
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":timestamp", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Delete a Setting
    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id=:id";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));
        // Bind Data 
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }
}
