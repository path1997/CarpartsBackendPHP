<?php
require_once 'DbConnect.php';
$response = array();

if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
        case 'confirmorder':
            $payment = $_POST['payment'];
            $user_id = $_POST['user_id'];
            $sum = $_POST['sum'];
            $stmt = $conn->prepare("SELECT max(id) as maxid from orders");
            $stmt->execute();
            $result = $stmt->fetchAll();
            if($result[0]['maxid']==null){
                $number=1;
            } else {
                $number=$result[0]['maxid'];
                $number=$number+1;
            }
            date_default_timezone_set("Europe/Warsaw");
            $act_date=date("Y-m-d").' '.date("H:i");
            $stmt = $conn->prepare("INSERT INTO orders(date_of_order,user_id,payment, totalcost) VALUES ( :act_date, :user_id, :payment, :sum)");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->bindParam(":act_date", $act_date, PDO::PARAM_STR);
            $stmt->bindParam(":payment", $payment, PDO::PARAM_STR);
            $stmt->bindParam(":sum", $sum, PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $conn->prepare("select c.id from cart c,product p, users u where u.id=c.user_id and c.user_id= :user_id and c.product_id=p.id and c.active=1 and p.visible=0");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $result5 = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($result5 as $row1) {
                $stmt = $conn->prepare("DELETE FROM cart WHERE id= :id");
                $stmt->bindParam(":id", $row1->id, PDO::PARAM_STR);
                $stmt->execute();
            }

            $stmt = $conn->prepare("UPDATE cart set active=0, orders_id= :orders_id where active=1 and user_id= :user_id");
            $stmt->bindParam(":orders_id", $number, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();

            $response['error'] = false;
            $response['message'] = 'The order has been submitted for implementation';
            break;
        case 'getmyorder':
            $user_id = $_POST['user_id'];
            $stmt = $conn->prepare("SELECT id, date_of_order, totalcost from orders where user_id= :user_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $order = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'Add to cart successfull';
            $response['orders'] = $order;
            break;
        case 'getmyorderdetail':
            $order_id = $_POST['order_id'];
            $stmt = $conn->prepare("SELECT c.id as cid,o.payment,o.totalcost,o.date_of_order, p.id,p.name,p.price,r.path, c.quantity from orders o, product p, photo r, cart c where r.product_id=p.id and r.position=1 and o.id=c.orders_id and c.product_id=p.id and o.id= :order_id");
            $stmt->bindParam(":order_id", $order_id, PDO::PARAM_STR);
            $stmt->execute();
            $order = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'Add to cart successfull';
            $response['orderdetail'] = $order;
            break;
        case 'addreservation':
            $user_id = $_POST['user_id'];
            $stmt = $conn->prepare("SELECT product_id,quantity from cart where user_id= :user_id and active=1");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $set=0;
            foreach ($result as $row => $link) {
                $stmt = $conn->prepare("SELECT name,quantity from product where id= :product_id");
                $stmt->bindParam(":product_id", $link['product_id'], PDO::PARAM_STR);
                $stmt->execute();
                $resultquantity=$stmt->fetchAll(PDO::FETCH_ASSOC);
                $availablequantity = (int)$resultquantity[0]['quantity'];
                if($link['quantity']> $availablequantity){
                    $response['error'] = true;
                    $response['message'] = 'We only have '.$resultquantity[0]['quantity'].' pieces of '.$resultquantity[0]['name'];
                    $set=$set+1;
                    break;
                }
            }
            if($set==0) {
                foreach ($result as $row => $link) {
                    $stmt = $conn->prepare("SELECT name,quantity from product where id= :product_id");
                    $stmt->bindParam(":product_id", $link['product_id'], PDO::PARAM_STR);
                    $stmt->execute();
                    $resultquantity = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $availablequantity = (int)$resultquantity[0]['quantity'];

                    $qt = (int)$availablequantity - (int)$link['quantity'];

                    $stmt = $conn->prepare("UPDATE product set quantity= :quantity where id= :product_id");
                    $stmt->bindParam(":product_id", $link['product_id'], PDO::PARAM_STR);
                    $stmt->bindParam(":quantity", $qt, PDO::PARAM_STR);
                    $stmt->execute();

                }
                $response['error'] = false;
                $response['message'] = 'successfull';
            }
            break;
        case 'removereservation':
            $user_id = $_POST['user_id'];
            $stmt = $conn->prepare("SELECT product_id,quantity from cart where user_id= :user_id and active=1");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row => $link) {
                $stmt = $conn->prepare("SELECT name,quantity from product where id= :product_id");
                $stmt->bindParam(":product_id", $link['product_id'], PDO::PARAM_STR);
                $stmt->execute();
                $resultquantity=$stmt->fetchAll(PDO::FETCH_ASSOC);
                $availablequantity = (int)$resultquantity[0]['quantity'];
                    $qt=(int)$availablequantity+(int)$link['quantity'];
                    $stmt = $conn->prepare("UPDATE product set quantity= :quantity where id= :product_id");
                    $stmt->bindParam(":product_id", $link['product_id'], PDO::PARAM_STR);
                    $stmt->bindParam(":quantity", $qt, PDO::PARAM_STR);
                    $stmt->execute();

            }
            $response['error'] = false;
            $response['message'] = 'successfull';
            break;
    }
}
echo json_encode($response);
