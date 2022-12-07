<?php
class User
{
    // DB Related
    private $conn;
    private $table = "users";

    // User Properties
    public $id;
    public $email;
    public $startdate;
    public $enddate;
    public $status;

    // Construct with Database
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get All Users
    public function read($email = null)
    {
        $query = "SELECT
        *
        FROM {$this->table} p

        ";

        if($email)  $query = $query."WHERE p.email LIKE '%$email%'";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Get a Single User
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
            // Get the User
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
           if($user){
                $this->email = $user["email"];
                $this->startdate = $user["startdate"];
                $this->enddate = $user["enddate"];
                $this->status = $user["status"];
                return true;
            }else{
                throw new Exception("no user found");
            }
            
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Create a User
    public function create()
    {
        $query = "INSERT INTO {$this->table} 
        SET 
        email = :email,
        startdate= :startdate, 
        enddate= :enddate, 
        status= :status";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->email = htmlspecialchars(strip_tags(trim($this->email)));
        $this->startdate = htmlspecialchars(strip_tags(trim($this->startdate)));
        $this->enddate = htmlspecialchars(strip_tags(trim($this->enddate)));
        $this->status = htmlspecialchars(strip_tags(trim($this->status)));

        // Bind Data
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":startdate", $this->startdate);
        $stmt->bindParam(":enddate", $this->enddate);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }


    // Update a User
    public function update()
    {
        $query = "UPDATE {$this->table} 
        SET 
        email = :email,
        startdate= :startdate, 
        enddate= :enddate, 
        status= :status
        WHERE id = :id";

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->id = htmlspecialchars(strip_tags(trim($this->id)));
        $this->email = htmlspecialchars(strip_tags(trim($this->email)));
        $this->startdate = htmlspecialchars(strip_tags(trim($this->startdate)));
        $this->enddate = htmlspecialchars(strip_tags(trim($this->enddate)));
        $this->status = htmlspecialchars(strip_tags(trim($this->status)));

        // Bind Data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":startdate", $this->startdate);
        $stmt->bindParam(":enddate", $this->enddate);
        $stmt->bindParam(":status", $this->status);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Database Error: %s\n", $stmt->error);
            return false;
        }
    }

    // Delete a User
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
