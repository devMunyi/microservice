<?php
class Logs
{
    //required db params 
    private $conn;
    private $table = "tbl_logs";

    //Logs properties
    public $text;
    public $service_id;
    public $status = 1;


    //Constructor with DB 
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function addlogs()
    {
        //intialize data to bind as an empty array 
        $data = [];

        //create query 
        //create query 
        $query = "INSERT INTO " . $this->table . " SET 
        `text` = :text_, 
        `service_id` = :service_id";

        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //Set binding data 
        $data = [
            "text_" => $this->text,
            "service_id" => $this->service_id
        ];

        //Execute query 
        if ($stmt->execute($data)) {
            return $stmt;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return;
        }
    }



    //Get all logs 
    public function get_all()
    {
        $data = []; //intialize data to bind as an empty array

        //Create query 
        $query = "SELECT
             tl.id,
             ts.service_address, 
             tl.text AS response, 
             tl.logged_date, 
             tl.status
             FROM " . $this->table . " tl 
             LEFT JOIN 
                 tbl_services ts ON tl.service_id = ts.id
             WHERE tl.status = :status
             ORDER BY
             tl.id DESC";


        //prepare statement/query 
        $stmt = $this->conn->prepare($query);

        ///Set binding data
        $data = [
            "status" => $this->status
        ];

        //Execute query 
        if ($stmt->execute($data)) {
            return $stmt;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return;
        }
    }

    //Get single log 
    public function get_one_byid()
    {
        //Create query 
        $query = "SELECT
             tl.id,
             ts.service_address, 
             tl.text AS response, 
             tl.logged_date, 
             tl.status
                FROM
                " . $this->table . " tl 
                LEFT JOIN 
                    tbl_services ts ON tl.service_id = ts.id
                WHERE tl.id = :id AND tl.status = :status LIMIT 0,1";


        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //prepare statement/query 
        $stmt = $this->conn->prepare($query);

        ////Set binding data 
        $data = [
            "id" => $this->id,
            "status" => $this->status
        ];

        //Execute query 
        if ($stmt->execute($data)) {
            return $stmt;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return;
        }
    }


    //Delete log 
    public function delete()
    {
        $data = []; //intialize data to bind as an empty array

        //create query 
        $query = "UPDATE " . $this->table . " SET
                    status = :status
                    WHERE
                    id = :id";

        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->status = htmlspecialchars(strip_tags($this->status));

        ////Set binding data 
        $data = [
            "status" => $this->status,
            "id" => $this->id,
        ];

        //Execute query 
        if ($stmt->execute($data)) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
