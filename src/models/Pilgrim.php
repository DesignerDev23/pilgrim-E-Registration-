<?php
class Pilgrim {
    private $conn;
    private $table_name = "pilgrims";

    public $id;
    public $pil_name;
    public $pil_lga;
    public $pil_nin;
    public $pil_bvn;
    public $passport_no;
    public $gender;
    public $dob;
    public $phone_number;
    public $email;
    public $password;
    public $account_number;
    public $account_reference; // Add this property

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to create a new pilgrim
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (pil_name, pil_lga, pil_nin, pil_bvn, passport_no, gender, dob, phone_number, email, password, account_number, account_reference) VALUES (:pil_name, :pil_lga, :pil_nin, :pil_bvn, :passport_no, :gender, :dob, :phone_number, :email, :password, :account_number, :account_reference)";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->pil_name = htmlspecialchars(strip_tags($this->pil_name));
        $this->pil_lga = htmlspecialchars(strip_tags($this->pil_lga));
        $this->pil_nin = htmlspecialchars(strip_tags($this->pil_nin));
        $this->pil_bvn = htmlspecialchars(strip_tags($this->pil_bvn));
        $this->passport_no = htmlspecialchars(strip_tags($this->passport_no));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->account_number = htmlspecialchars(strip_tags($this->account_number));
        $this->account_reference = htmlspecialchars(strip_tags($this->account_reference));

        // bind values
        $stmt->bindParam(":pil_name", $this->pil_name);
        $stmt->bindParam(":pil_lga", $this->pil_lga);
        $stmt->bindParam(":pil_nin", $this->pil_nin);
        $stmt->bindParam(":pil_bvn", $this->pil_bvn);
        $stmt->bindParam(":passport_no", $this->passport_no);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":account_number", $this->account_number);
        $stmt->bindParam(":account_reference", $this->account_reference);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method to update the account reference
    public function updateAccountReference() {
        $query = "UPDATE " . $this->table_name . " SET account_reference = :account_reference WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->account_reference = htmlspecialchars(strip_tags($this->account_reference));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":account_reference", $this->account_reference);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Method to get a pilgrim by email
    public function getPilgrimByEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind value
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // set values to object properties
            $this->id = $row['id'];
            $this->pil_name = $row['pil_name'];
            $this->pil_lga = $row['pil_lga'];
            $this->pil_nin = $row['pil_nin'];
            $this->pil_bvn = $row['pil_bvn'];
            $this->passport_no = $row['passport_no'];
            $this->gender = $row['gender'];
            $this->dob = $row['dob'];
            $this->phone_number = $row['phone_number'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->account_number = $row['account_number'];
            $this->account_reference = $row['account_reference']; // Set account reference
            return true;
        }

        return false;
    }

    // Method to get a pilgrim by ID
    public function getPilgrimById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind value
        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // set values to object properties
            $this->id = $row['id'];
            $this->pil_name = $row['pil_name'];
            $this->pil_lga = $row['pil_lga'];
            $this->pil_nin = $row['pil_nin'];
            $this->pil_bvn = $row['pil_bvn'];
            $this->passport_no = $row['passport_no'];
            $this->gender = $row['gender'];
            $this->dob = $row['dob'];
            $this->phone_number = $row['phone_number'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->account_number = $row['account_number'];
            $this->account_reference = $row['account_reference']; // Set account reference
            return true;
        }

        return false;
    }
}

?>
