<?php
require_once 'DbConnect.php';

$response = array();
if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
        case 'signup':
            $email = $_POST['email'];
            $fname = $_POST['fname'];
            $sname = $_POST['sname'];
            $phone = $_POST['phone'];
            $postcode = $_POST['postcode'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
//            password_hash("GFG@123", PASSWORD_DEFAULT);
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            /*$stmt->store_result();*/
            $count = $stmt->rowCount();
            if ($count > 0) {
                $response['error'] = true;
                $response['message'] = 'User already registered';
            } else {
                $query = "INSERT INTO users (fname, sname, email, phone, password, postcode, city, address) VALUES (:fname, :sname, :email, :phone, :password, :postcode, :city, :address)";
                $statement = $conn->prepare($query);
                $statement->bindParam(":email", $email, PDO::PARAM_STR);
                $statement->bindParam(":fname", $fname, PDO::PARAM_STR);
                $statement->bindParam(":sname", $sname, PDO::PARAM_STR);
                $statement->bindParam(":phone", $phone, PDO::PARAM_STR);
                $statement->bindParam(":postcode", $postcode, PDO::PARAM_STR);
                $statement->bindParam(":city", $city, PDO::PARAM_STR);
                $statement->bindParam(":address", $address, PDO::PARAM_STR);
                $statement->bindParam(":password", $password, PDO::PARAM_STR);

                if ($statement->execute()) {
                    $stmt = $conn->prepare("SELECT id, fname, sname, email, phone, postcode, city, address FROM users WHERE email = :email");
                    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                    $stmt->execute();
                    $user = $stmt->fetch();
                    /*$user = array(
                    'id'=>$row['id'],
                    'username'=>$row['username'],
                    'email'=>$row['$email'],
                    'gender'=>$row['gender']
                    );*/
                    $response['error'] = false;
                    $response['message'] = 'Login successfull';
                    $response['user'] = $user;
                }
            }
            break;
        case 'login':
            if (isTheseParametersAvailable(array('email', 'password'))) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $stmt = $conn->prepare("SELECT id,fname,sname,email,password,phone,city,postcode,address FROM users WHERE email = :email");
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
//                $stmt->bindParam(":password", $password, PDO::PARAM_STR);
                $stmt->execute();
                /*$stmt->store_result();*/
                $count = $stmt->rowCount();
                $user = $stmt->fetch(PDO::FETCH_OBJ);
                if($count > 0){
                    //$stmt->bind_result($id, $username, $email, $gender);
                    if(password_verify($password,$user->password)) {
                        /*$user = array(
                            'id'=>$id,
                            'username'=>$username,
                            'email'=>$email,
                            'gender'=>$gender
                        );*/
                        $response['error'] = false;
                        $response['message'] = 'Login successfull';
                        $response['user'] = $user;
                    } else{
                        $response['error'] = true;
                        $response['message'] = 'Invalid username or password';
                    }
                }else{
                    $response['error'] = true;
                    $response['message'] = 'Invalid username or password';
                }
            }
            break;
        case 'changedata':
            if (isTheseParametersAvailable(array('id','fname','sname','phone','email','postcode','city','address'))) {
                $email = $_POST['email'];
                $id = $_POST['id'];
                $fname = $_POST['fname'];
                $sname = $_POST['sname'];
                $phone = $_POST['phone'];
                $postcode = $_POST['postcode'];
                $city = $_POST['city'];
                $address = $_POST['address'];

                $stmt = $conn->prepare("UPDATE users SET email= :email, fname= :fname, sname= :sname, phone= :phone, postcode= :postcode, city= :city, address= :address WHERE id= :id");

                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $stmt->bindParam(":fname", $fname, PDO::PARAM_STR);
                $stmt->bindParam(":sname", $sname, PDO::PARAM_STR);
                $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
                $stmt->bindParam(":postcode", $postcode, PDO::PARAM_STR);
                $stmt->bindParam(":city", $city, PDO::PARAM_STR);
                $stmt->bindParam(":address", $address, PDO::PARAM_STR);

                $stmt->execute();

                $response['error'] = false;
                $response['message'] = 'Change data successfull';
            }
            break;
        case 'changepassword':
            if (isTheseParametersAvailable(array('id','oldpassword','newpassword'))) {
                $oldpassword = $_POST['oldpassword'];
                $newpassword = password_hash($_POST['newpassword'],PASSWORD_BCRYPT);
                $id = $_POST['id'];

                $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
//                $stmt->bindParam(":password", $password, PDO::PARAM_STR);
                $stmt->execute();
                /*$stmt->store_result();*/
                $user = $stmt->fetch(PDO::FETCH_OBJ);
                if(password_verify($oldpassword,$user->password)) {

                    $stmt = $conn->prepare("UPDATE users SET password= :password WHERE id= :id");
                    $stmt->bindParam(":password", $newpassword, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                    $stmt->execute();

                    $response['error'] = false;
                    $response['message'] = 'Change password successfull';
                } else {
                    $response['error'] = true;
                    $response['message'] = 'Change password failed';
                }
            }
            break;
        default:
            $response['error'] = true;
            $response['message'] = 'Invalid Operation Called';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
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