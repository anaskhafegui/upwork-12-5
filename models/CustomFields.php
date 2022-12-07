<?php
class CustomFields
{
    // DB Related
    private $conn;
    private $table = "customfields";

    // User Properties
    public $id;
    public $fieldname;
    public $user;
    public $timestamp;

    // Construct with Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get All customfields
    public function read($email = null)
    {
        $query = "SELECT
        *
        FROM {$this->table} p
        ";

        if($email)  $query = $query."WHERE p.user LIKE '%$email%'";
        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Get a Single Custom Field
    public function single()
    {
        $query = "SELECT
        *
        FROM {$this->table} p
        WHERE p.id = ?
        LIMIT 0,1
        ";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            // Get the Custom Field
            $customfield = $stmt->fetch(PDO::FETCH_ASSOC);
            if($customfield){
                $this->fieldname = $customfield["fieldname"];
                $this->user = $customfield["user"];
                $this->timestamp = $customfield["timestamp"];
            return true;
            }else{
                throw new Exception("no custom field found");
            }
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Create a Custom Field
    public function create()
    {
        $query = "INSERT INTO {$this->table} 
        SET 
        fieldname = :fieldname,
        user= :user, 
        timestamp= :timestamp";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->fieldname = htmlspecialchars(strip_tags(trim($this->fieldname)));
        $this->user = htmlspecialchars(strip_tags(trim($this->user)));
        $this->timestamp = htmlspecialchars(strip_tags(trim($this->timestamp)));

        // Bind Data
        $stmt->bindParam(":fieldname", $this->fieldname);
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":timestamp", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }


    // Update a Custom Field
    public function update()
    {
        $query = "UPDATE {$this->table} 
        SET 
        fieldname = :fieldname,
        user = :user, 
        timestamp= :timestamp
        WHERE id = :id";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));
        $this->fieldname = htmlspecialchars(strip_tags(trim($this->fieldname)));
        $this->user = htmlspecialchars(strip_tags(trim($this->user)));
        $this->timestamp = htmlspecialchars(strip_tags(trim($this->timestamp)));

        // Bind Data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":fieldname", $this->fieldname);
        $stmt->bindParam(":user", $this->user);
        $stmt->bindParam(":timestamp", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Delete a Custom Field
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
