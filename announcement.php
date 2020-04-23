<?php
require_once 'DbConnect.php';
$response = array();

if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
        case 'addannouncement':
            if(isTheseParametersAvailable(array('title', 'description','price','name_photo','user_id'))) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $name_photo = $_POST['name_photo'];
                $user_id = $_POST['user_id'];
                $amount_month = $_POST['amount_month'];

                $stmt = $conn->prepare("SELECT max(id) as maxid FROM announcement");
                $stmt->execute();
                $announcement_id = $stmt->fetchAll();
                $number = $announcement_id[0]['maxid'];
                $number=$number+1;

                $photo_name = 'photo'.$number.'.jpg';

                date_default_timezone_set("Europe/Warsaw");
                $date = date('Y-m-d');
                $date = strtotime(date('Y-m-d', strtotime($date)) . "+$amount_month months");
                $date = date('Y-m-d',$date);
//                $old_date = date( 'y-m-d' );
//                $new_date = date( 'y-m-d', strtotime( $old_date .' +$amount_month month' ));


                $query = "INSERT INTO announcement (title, description, price,path,userid, endannouncement) VALUES (:title, :description, :price, :name_photo, :user_id, :new_date)";
                $statement = $conn->prepare($query);
                $statement->bindParam(":title", $title, PDO::PARAM_STR);
                $statement->bindParam(":description", $description, PDO::PARAM_STR);
                $statement->bindParam(":price", $price, PDO::PARAM_STR);
                $statement->bindParam(":name_photo", $photo_name, PDO::PARAM_STR);
                $statement->bindParam(":user_id", $user_id, PDO::PARAM_STR);
                $statement->bindParam(":new_date", $date, PDO::PARAM_STR);
                //ponizej nie wiem czy git ---------------------------------------------------------------------------
//                $statement->bindParam(":act_date", $act_date, PDO::PARAM_STR);


//            if ($statement->execute()) {
//                $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE username = :username");
//                $stmt->bindParam(":username", $username, PDO::PARAM_STR);

                $statement->execute();
//            $announcement = $statement->fetch();
                /*$user = array(
                'id'=>$row['id'],
                'username'=>$row['username'],
                'email'=>$row['$email'],
                'gender'=>$row['gender']
                );*/
                $response['error'] = false;
                $response['message'] = 'Add announcement successfull';
            } else {
                $response['error'] = true;
                $response['message'] = 'errorkjahkjfsahkasfa';
            }
//            $response['announcement'] = $announcement;
//            }
//        }
            break;
        case 'allannouncement':
            $stmt = $conn->prepare("SELECT id, title, path, price FROM announcement");
            $stmt->execute();
            $allannouncement = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'All announcement successfull';
            $response['allannouncement'] = $allannouncement;
            break;
        case 'announcementdetail':
            $announcementid = $_POST['announcementid'];

            $stmt = $conn->prepare("SELECT a.title, a.price, a.description, a.path, u.phone, u.fname, u.city from announcement a, users u where a.userid = u.id and a.id = :announcementid");
            $stmt->bindParam(":announcementid", $announcementid, PDO::PARAM_STR);
            $stmt->execute();
            $announcementdetail = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'Detail announcement successfull';
            $response['announcementdetail'] = $announcementdetail;
            break;
        case 'myannouncement' :
            $user_id = $_POST['user_id'];
//            echo $user_id;
            $stmt = $conn->prepare("SELECT id, title, price, path, endannouncement from announcement where userid= :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $myannouncement = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'My announcement successfull';
            $response['myannouncement'] = $myannouncement;
            break;
        case 'deleteannouncement' :
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM announcement WHERE id= :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $response['error'] = false;
            $response['message'] = 'Delete Announcement';
            break;
        case 'getmyannouncement' :
            $myannouncementid = $_POST['myannouncementid'];
            $stmt = $conn->prepare("SELECT title, price, description from announcement where id= :myannouncementid");
            $stmt->bindParam(":myannouncementid", $myannouncementid, PDO::PARAM_STR);
            $stmt->execute();
            $getmyannouncement = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'My getmyannouncement successfull';
            $response['getmyannouncement'] = $getmyannouncement;
            break;
        case 'editmyannouncement' :
            $myannouncementid = $_POST['myannouncementid'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $description = $_POST['description'];

            $stmt = $conn->prepare("UPDATE announcement SET title= :title, price= :price, description= :description WHERE id= :myannouncementid");

            $stmt->bindParam(":myannouncementid", $myannouncementid, PDO::PARAM_STR);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":price", $price, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);

            $stmt->execute();

            $response['error'] = false;
            $response['message'] = 'Edit announcement successfull';
            break;
    }
}
echo json_encode($response);

function isTheseParametersAvailable($params)
{
    foreach ($params as $param) {
        if (!isset($_POST[$param])) {
            return false;
        }
    }

    return true;
}