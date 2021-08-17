<?php

class ApiAppointement
{
    public $user_reference;
    public $user_id;

    public function index(){
       /*  return  */
    }

    public function checkUser()
    {


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
                array('message' => 'Appointment iserted',
                    'status' => true)
            );
        } else {
            echo json_encode(
                array('message' => 'Appointment is not inserted',
                    'status' => false)
            );
        }
    }

    public function deleteAnAppointment($id)
    {


        
        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate User object
        $Appointement = new Appointements($db);

        // //get raw posted data 
        // $data = json_decode(file_get_contents("php://input"));

        $Appointement->appointement_id = $id;

        // $Appointement->appointement_id = $data->appointement_id;

        if ($Appointement->deleteAnAppointement()) {

            echo json_encode(
                array('message' => 'Appointment deleted',
                        'status' => true   )
            );
        } else {
            echo json_encode(
                array('message' => 'Appointment is not deleted',
                        'status' => false)
            );
        }
    }

    public function updateAnAppointement($id)
    {



        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate Appointment object
        $Appointement = new Appointements($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        // get The Appointement ID
        $Appointement->appointement_id = $id;

        // get the other data
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

    public function showMyAppointments($id)
    {


        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate User object
        $user = new Users($db);

        $user->userId = $id;

        $result = $user->read_single();

        $userInfo = array();
        $myInfo = array();
        
        $user = array();
        $user['personal_infos'] = array();
        $user['appointements'] = array();
        
        if ($result) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $user['personal_infos'] = array(
                'userId' => $userId,
                'userFirstName' => $userFirstName,
                'userLastName' => $userLastName,
                'userCIN' => $userCIN,
                'userEmail' => $userEmail,
                'Reference' => $Reference
            );
        }

        $Appointement = new Appointements($db);
        //get the user_id_fk
        $Appointement->userId_fk = $id;

        $appointement_result = $Appointement->getAppointements();

        $num = $appointement_result->rowCount();

        if ($num > 0) {
            // Appointement array
            $myAppointments = array();
            // $posts_arr['data'] = array();
            $i=0;

            while ($row = $appointement_result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $user['appointements'][$i] = array(
                    'appointement_id' => $appointement_id,
                    'userId_fk' => $userId_fk,
                    'timeslot_id_fk' => $timeslot_id_fk,
                    'user_subject' => html_entity_decode($user_subject),
                    'c_date' => $c_date,
                    'start_at' => $start_at,
                    'end_at' => $end_at
                );
                $i++;
            }

            $user['status'] = true;
            // Turn to JSON & output
            echo json_encode($user);
        } else {
            // No Appointements
            $message = array("message" => "you dont have any appointements",
                        "status" => false);
            array_push($userInfo, $message);
            echo json_encode($userInfo);
        }
    }

    public function checkAvailableTimes()
    {


        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate Appointment object
        $Appointement = new Appointements($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        // get the inserted date
        $Appointement->c_date = $data->c_date;

        // sending inserted date as paramater
        $result = $Appointement->checkAvailableTimes();

        $num = $result->rowCount();
        
        $All_available_reservations = array();
        $All_available_reservations['data'] = array();
        
        if ($num > 0) {

            while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                $available_reservations = array(
                    'timeslot_id' => $rows["timeslot_id"],
                    'start_at' => $rows["start_at"],
                    'end_at' => $rows["end_at"]
                );            
                // Push to "data"
                array_push($All_available_reservations['data'], $available_reservations);
        }
        $All_available_reservations['status'] = true;
        echo json_encode($All_available_reservations);
        
        }else{
            
            $msg = array("message" => "you dont have any appointements",
                        "status" => false);
            echo json_encode($msg);
        }
    }
}
