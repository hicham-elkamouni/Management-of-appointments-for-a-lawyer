<?php

class Appointments
{


    // db stuff
    private $conn;
    private $table = 'appointments';

    // users properties
    public $userId_fk;
    public $timeslot_id_fk;
    public $user_subject;
    public $c_date;

    public function createAnAppointment()
    {

        $query = "INSERT INTO appointements (userId_fk, timeslot_id_fk, user_subject, 	c_date)
        VALUES (:userId_fk, :timeslot_id_fk, :user_subject, :c_date ) ";


        // Clean data
        $this->timeslot_id_fk = htmlspecialchars($this->timeslot_id_fk);
        $this->user_subject = htmlspecialchars(strip_tags($this->user_subject));
        $this->c_date = htmlspecialchars($this->c_date);

        // Bind data
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId_fk', $this->userId_fk);
        $stmt->bindParam(':timeslot_id_fk', $this->timeslotId_fk);
        $stmt->bindParam(':user_subject', $this->user_subject);
        $stmt->bindParam(':c_date', $this->c_date);


        if ($stmt->execute()) {
            return true;
        }

        // print error if something goes wrong
        printf("Error %s.\n", $stmt->error);
        return false;
    }
}
