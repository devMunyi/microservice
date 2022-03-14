<?php
class Service
{
    //required db params 
    private $conn;
    private $table = 'tbl_services';

    //dynamic table properties

    public $id;
    public $service_address;
    public $r_timestamp;
    public $unit;
    public $frequency;
    public $is_executed;
    public $added_at; 
    public $updatd_at;
    public $status = 1;

    //other constraints
    public $offset = 0;
    public $rpp = 10;
    public $page_no = 1;
    public $orderby = "r_timestamp";
    public $dir = "DESC";
    public $search = "";

    //parameter for date filtering
    public $thisfulldate;  //=>date_format(r_timestamp, "%-%-% %:%")


    //Constructor with DB 
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Add service 
    public function add()
    {
        $data = []; //intialize data to bind as an empty array

        //create query 
        $query = "INSERT INTO " . $this->table .
            " SET
                service_address = :service_address,
                r_timestamp = :r_timestamp,
                unit = :unit,
                frequency = :frequency
            ";

        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //Clean data 
        $this->service_address = htmlspecialchars(strip_tags($this->service_address));
        $this->r_timestamp = htmlspecialchars(strip_tags($this->r_timestamp));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->frequency = htmlspecialchars(strip_tags($this->frequency));


        ////Set binding data
        $data = [
            "service_address" => $this->service_address,
            "r_timestamp" => $this->r_timestamp,
            "unit" => $this->unit,
            "frequency" => $this->frequency
        ];

        //Execute query 
        if ($stmt->execute($data)) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    //Update post 
    public function update()
    {
        $data = []; //intialize data to bind as an empty array 

        //update query 
        $query = "UPDATE " . $this->table .
            " SET
                service_address = :service_address,
                r_timestamp = :r_timestamp,
                unit = :unit,
                frequency = :frequency
              WHERE id = :id";

        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //Clean data 
        $this->service_address = htmlspecialchars(strip_tags($this->service_address));
        $this->r_timestamp = htmlspecialchars(strip_tags($this->r_timestamp));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->frequency = htmlspecialchars(strip_tags($this->frequency));
        $this->id = htmlspecialchars(strip_tags($this->id));


        ////Set binding data
        $data = [
            "service_address" => $this->service_address,
            "r_timestamp" => $this->r_timestamp,
            "unit" => $this->unit,
            "frequency" => $this->frequency,
            "id" => $this->id
        ];


        //Execute query 
        if ($stmt->execute($data)) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }


    //get all services 
    public function get_all()
    {
        $data = []; //intialize data to bind as an empty array
        //Create query 
        $query = "SELECT
            `id`, 
            `service_address`,
            `r_timestamp`, 
            `unit`, 
            `frequency`, 
            `is_executed`,
            `added_at`,
            `updated_at`, 
            `status`
            FROM
            " . $this->table . " 
            WHERE status = :status
            ORDER BY " . $this->orderby . " " . $this->dir . " 
            LIMIT " . $this->offset . ", " . $this->rpp;


        //prepare statement/query 
        $stmt = $this->conn->prepare($query);

        ////Set binding data
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



    //Get single service 
    public function get_one_byid()
    {
        $data = []; //intialize data to bind as an empty array

        //Create query 
        $query = "SELECT
            `id`, 
            `service_address`,
            `r_timestamp`, 
            `unit`, 
            `frequency`, 
            `is_executed`,
            `added_at`,
            `updated_at`,
            `status`
            FROM
            " . $this->table . "
            WHERE id = :id AND status = :status LIMIT 0,1";

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
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //set properties
            $this->id = $row['id'];
            $this->service_address = $row['service_address'];
            $this->r_timestamp = $row['r_timestamp'];
            $this->unit = $row['unit'];
            $this->is_executed = $row['is_executed'];
            $this->frequency = $row['frequency'];
            $this->added_at = $row['added_at'];
            $this->updated_at = $row['updated_at'];
            $this->status = $row['status'];

        } else {
            printf("Error: %s.\n", $stmt->error);
            return;
        }

    }


    //get all services to run 
    public function services_to_run()
    {
        $data = []; //intialize data to bind as an empty array
        //Create query 
        $query = "SELECT
            `id`, 
            `service_address`,
            `r_timestamp`, 
            `unit`, 
            `frequency`, 
            `is_executed`,
            `added_at`,
            `updated_at`, 
            `status`
            FROM
            " . $this->table . " 
            WHERE DATE_FORMAT(r_timestamp, '%Y-%m-%d %H:%i') = :thifulldate AND is_executed = 'No' AND status = :status
            ORDER BY
                id DESC";


        //prepare statement/query 
        $stmt = $this->conn->prepare($query);

        ////Set binding data
        $data = [
            "thifulldate" => $this->thisfulldate,
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



    public function update_next_r_timestamp($id, $r_timestamp)
    {
        $data = []; //intialize data to bind as an empty array 

        //update query 
        $query = "UPDATE " . $this->table .
            " SET
                r_timestamp = :r_timestamp
              WHERE id = :id";

        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //Clean data 
        $this->r_timestamp = htmlspecialchars(strip_tags($this->r_timestamp));
        $this->id = htmlspecialchars(strip_tags($this->id));


        ////Set binding data
        $data = [
            "r_timestamp" => $r_timestamp,
            "id" => $id
        ];


        //Execute query 
        if ($stmt->execute($data)) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    //Delete service 
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


    public function is_executed($id, $is_executed)
    {
        //intialize data to bind as an empty array 
        $data = [];

        //create query 
        $query = "UPDATE " . $this->table . " SET 
            is_executed = :is_executed WHERE id = :id AND status = :status";

        //prepare statement 
        $stmt = $this->conn->prepare($query);

        //Set binding data 
        $data = [
            "is_executed" => $is_executed,
            "id" => $id,
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
}
