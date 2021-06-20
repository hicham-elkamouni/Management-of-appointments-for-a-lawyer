<?php

class Appointements
{

    // db stuff
    private $conn;
    private $table = 'appointements';

    // users properties
    public $userId_fk;
    public $timeslot_id_fk;
    public $user_subject;
    public $c_date;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createAnAppointement()
    {

        $query = "INSERT INTO appointements 
        (userId_fk, timeslot_id_fk, user_subject, c_date)
        VALUES 
        (:userId_fk, :timeslot_id_fk, :user_subject, :c_date ) ";

        // Clean data
        $this->timeslot_id_fk = htmlspecialchars($this->timeslot_id_fk);
        $this->user_subject = htmlspecialchars(strip_tags($this->user_subject));
        $this->c_date = htmlspecialchars($this->c_date);
        // prepare the query
        $stmt = $this->conn->prepare($query);
        // Bind data
        $stmt->bindParam(':userId_fk', $this->userId_fk);
        $stmt->bindParam(':timeslot_id_fk', $this->timeslot_id_fk);
        $stmt->bindParam(':user_subject', $this->user_subject);
        $stmt->bindParam(':c_date', $this->c_date);


        if ($stmt->execute()) {
            return true;
        }

        // print error if something goes wrong
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    public function deleteAnAppointement()
    {

        $query = "DELETE FROM appointements WHERE appointement_id = :appointement_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':appointement_id', $this->appointement_id);

        if ($stmt->execute()) {
            return true;
        }
        // print error if something goes wrong
        printf("Error %s.\n", $stmt->error);
        return false;
    }

    // get one user informations
    public function read()
    {
        $query = 'SELECT * FROM appointements WHERE appointement_id = :appointement_id';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // execute statement
        $stmt->execute();
        return $stmt;
    }

    public function UpdateAnAppointement()
    {

        $query = "UPDATE appointements
        SET timeslot_id_fk = :timeslot_id_fk , user_subject = :user_subject, c_date = :c_date
        WHERE appointement_id = :appointement_id";

        // Clean data
        $this->appointement_id = htmlspecialchars(strip_tags($this->appointement_id));
        $this->timeslot_id_fk = htmlspecialchars(strip_tags($this->timeslot_id_fk));
        $this->user_subject = htmlspecialchars(strip_tags($this->user_subject));
        $this->c_date = htmlspecialchars(strip_tags($this->c_date));

        // prepare the query
        $stmt = $this->conn->prepare($query);
        // Bind data
        $stmt->bindParam(':appointement_id', $this->appointement_id);
        $stmt->bindParam(':timeslot_id_fk', $this->timeslot_id_fk);
        $stmt->bindParam(':user_subject', $this->user_subject);
        $stmt->bindParam(':c_date', $this->c_date);


        // execute the query
        if ($stmt->execute()) {
            return true;
        }
        // print error if something goes wrong
        printf("Error %s.\n", $stmt->error);
        return false;
    }
}
