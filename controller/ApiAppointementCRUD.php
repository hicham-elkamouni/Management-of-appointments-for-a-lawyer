<?php

class ApiAppointementCRUD
{
    public $tt;

    public function checkUser()
    {

        // headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods:POST,GET');
        header('Access-Control-Allow-Headers: content-type');
        header('Content-Type: application/json');


        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate User object
        $users = new Users($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));
    }

    public function create()
    {

        // headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods:POST,GET');
        header('Access-Control-Allow-Headers: content-type');
        header('Content-Type: application/json');

        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate User object
        $Appointment = new Appointments($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        $Appointment->userId_fk = $data->userId_fk;
        $Appointment->timeslot_id_fk = $data->timeslot_id_fk;
        $Appointment->user_subject = $data->user_subject;
        $Appointment->c_date = $data->c_date;

        if ($Appointment->createAnAppointment());
    }
}
