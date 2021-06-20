<?php

class ApiAppointement
{
    public $user_reference;

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

    public function createAnAppointement()
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

        // instantiate Appointment object
        $Appointement = new Appointements($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        $Appointement->userId_fk = $data->userId_fk;
        $Appointement->timeslot_id_fk = $data->timeslot_id_fk;
        $Appointement->user_subject = $data->user_subject;
        $Appointement->c_date = $data->c_date;

        if ($Appointement->createAnAppointement()) {

            echo json_encode(
                array('message' => 'Appointment iserted')
            );
        } else {
            echo json_encode(
                array('message' => 'Appointment is not inserted')
            );
        }
    }

    public function deleteAnAppointment($id)
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
        $Appointement = new Appointements($db);

        //get raw posted data 
        $data = json_decode(file_get_contents("php://input"));

        $Appointement->appointement_id = $id;

        if ($Appointement->deleteAnAppointement()) {

            echo json_encode(
                array('message' => 'Appointment deleted')
            );
        } else {
            echo json_encode(
                array('message' => 'Appointment is not deleted')
            );
        }
    }

    public function updateAnAppointement($id)
    {

        // headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods:PUT');
        header('Access-Control-Allow-Headers: content-type');
        header('Content-Type: application/json');

        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate Appointment object
        $Appointement = new Appointements($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        // get The Appointement ID
        $Appointement->appointement_id = $id;

        $Appointement->timeslot_id_fk = $data->timeslot_id_fk;
        $Appointement->user_subject = $data->user_subject;
        $Appointement->c_date = $data->c_date;

        if ($Appointement->updateAnAppointement()) {

            echo json_encode(
                array('message' => 'Appointment Updated')
            );
        } else {
            echo json_encode(
                array('message' => 'Appointment is not Updated')
            );
        }
    }
}
