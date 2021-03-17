<?php
ini_set('display_errors', 'On');
/*
 Request:
 Methods - https://localhost/DT173G_Projekt/rest/api/education.php
*/

require '../classes/database.class.php';
require '../classes/education.class.php';

// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Typ, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// variable for request method
$method = $_SERVER['REQUEST_METHOD']; //store set method

// check if ID is sent in url
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

// db connection
$database = new Database();
$db = $database->connect();

// set new instance of Education class
$education = new Education();

// switch statement returns different data based on type of method
switch($method) {

    case 'GET': // gets all stored data from database table
        if(isset($id)) {
            $result = $education->getOne($id); // if specific id is sent, get only that post from db
        } else {
            $result = $education->getAll(); // if no id is sent get all data from db table
            if (count($result) > 0) {
                http_response_code(200); //OK
            } else {
                http_response_code(400); //Not found
                $result = array('message' => 'No educations found'); // error message
            }
        }
        break;

    case 'POST' : // add post to db
        $d = json_decode(file_get_contents('php://input'));

        $education->university = $d->university;
        $education->eduName = $d->eduName;
        $education->eDescription = $d->eDescription;
        $education->start_date = $d->start_date;
        $education->end_date = $d->end_date;

        if($education->addPost()) {
            http_response_code(200); //OK
            $result = array('message' => 'Post added.'); //Success message
        } else {
            http_response_code(503); //Not found
            $result = array('message' => 'Could not add post.'); //Error message
        }

        break;

    case 'PUT' : // update post in db
        if(!isset($id)) {
            http_resonse_code(510);
            $result = array('message' => 'No id found.'); //Error message
        } else {
            $input = json_decode(file_get_contents("php://input"));

            $education->university = $input->university;
            $education->eduName = $input->eduName;
            $education->eDescription = $input->eDescription;
            $education->start_date = $input->start_date;
            $education->end_date = $input->end_date;

            if(!$education->updatePost($id)) {
                http_response_code(503);
                $result = array('message' => 'Could not update post.'); //Error message
            } else {
                http_response_code(200);
                $result = array('message' => 'Post updated.'); //Error message 
            }
        }
        break;


    case 'DELETE' : // delete post from db
        if(isset($id)) {
            if($education->deletePost($id)) {
                http_response_code(200);
                $result = array('message' => 'Post deleted.'); //Success message
            } else {
                http_response_code(503);
                $result = array('message' => 'Could not delete post.'); //Error message
            } 
        } else {
                http_response_code(510);
                $result = array('message' => 'No id found.'); //Error message
            }
            break;
}// end of switch statement

// return result in JSON-format
echo json_encode($result);

// close db connection
$db = $database->close();