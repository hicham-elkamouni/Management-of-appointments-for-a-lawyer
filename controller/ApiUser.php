<?php


class ApiUser
{


    public function read()
    {

        // headers
        header('Access-Control-Allow-Origin:*');
        header('Content-Type: application/json');

        // instantiate Database
        $database = new Database();
        $db = $database->connect();

        // instantiate User object
        $user = new Users($db);

        // user read query
        $result = $user->read();

        // get row count 
        $num = $result->rowCount();

        // check if there is a user 
        if ($num > 0) {
            // user array
            $users_arr = array();
            $users_arr['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $user_arr = array(
                    'userId' => $userId,
                    'userFirstName' => $userFirstName,
                    'userLastName' => $userLastName,
                    'userEmail' => $userEmail,
                    'userCIN' => $userCIN
                );
                array_push($users_arr['data'], $user_arr);
            }
            // Turn to JSON & output
            echo json_encode($users_arr);
        } else {
            // No Users
            echo json_encode(
                array('message' => 'No Users found')
            );
        }
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
        $user = new Users($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        $user->userFirstName = $data->userFirstName;
        $user->userLastName = $data->userLastName;
        $user->userCIN = $data->userCIN;
        $user->userEmail = $data->userEmail;
        /* $user->userPassword = $data->userPassword; */

        // split string
        $arr1 = str_split($data->userFirstName, 2);
        $arr2 = str_split($data->userLastName, 2);
        $arr3 = str_split($data->userCIN, 2);

        //Generate a random string.
        $token = openssl_random_pseudo_bytes(10);

        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        // generate custom token
        $user->Reference = $arr1[0] . $arr2[0] . $arr3[0] . $token;


        if ($user->create()) {
            echo json_encode(
                array('message' => 'user iserted')
            );
        } else {
            echo json_encode(
                array('message' => 'user not inserted')
            );
        }
    }

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
        $user = new Users($db);

        // get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        $user->Reference = $data->Reference;

        $userId = $user->checkUserExistence();

        if ($userId != false) {
            echo json_encode($userId);
        } else {
            echo json_encode("there's no id");
        }
    }
}