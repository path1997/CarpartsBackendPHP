<?php
require_once 'DbConnect.php';
$response = array();

if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
        case 'addproduct':
            $quantity = $_POST['quantity'];
            $id_product = $_POST['id_product'];
            $id_user = $_POST['id_user'];
            $stmt = $conn->prepare("SELECT c.quantity from users u, product p,cart c where active=1 and p.id=c.product_id and u.id=c.user_id and c.user_id= :id_user and c.product_id= :id_product");
            $stmt->bindParam(":id_product", $id_product, PDO::PARAM_STR);
            $stmt->bindParam(":id_user", $id_user, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $quantity1 = $stmt->fetchAll();
                $quantity4=(int)$quantity;
                $quantity2 = (int)$quantity1[0]['quantity'];
                $stmt = $conn->prepare("SELECT quantity from product where id= :id_product");
                $stmt->bindParam(":id_product", $id_product, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll();
                $quantity5=(int)$result[0]['quantity'];
                $quantity3=$quantity4+$quantity2;
                $quantity3 = strval($quantity3);
                if($quantity5>=$quantity3) {
                    $stmt = $conn->prepare("UPDATE cart set quantity= :quantity where product_id= :id_product and user_id= :id_user");
                    $stmt->bindParam(":quantity", $quantity3, PDO::PARAM_STR);
                    $stmt->bindParam(":id_product", $id_product, PDO::PARAM_STR);
                    $stmt->bindParam(":id_user", $id_user, PDO::PARAM_STR);
                    $stmt->execute();
                    $response['error'] = false;
                    $response['message'] = 'Add to cart successfull';
                } else {
                    $response['error'] = true;
                    $response['message'] = 'We can not add, because you have '.$quantity5.' pieces in cart';
                }
            } else {
                $stmt = $conn->prepare("INSERT INTO cart(product_id, user_id,active,quantity) VALUES (:id_product, :id_user,'1', :quantity)");
                $stmt->bindParam(":quantity", $quantity, PDO::PARAM_STR);
                $stmt->bindParam(":id_product", $id_product, PDO::PARAM_STR);
                $stmt->bindParam(":id_user", $id_user, PDO::PARAM_STR);
                $stmt->execute();
                $response['error'] = false;
                $response['message'] = 'Add to cart successfull';
            }
            break;

        case 'getcart':
            $user_id = $_POST['user_id'];
            $stmt = $conn->prepare("SELECT c.id as cid,p.id,p.name,p.price,r.path, c.quantity from product p, cart c,photo r where p.visible=1 and r.product_id=p.id and r.position=1 and active=1 and c.product_id=p.id and c.user_id= :user_id group by c.product_id");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            $stmt->execute();
            $cart = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'Add to cart successfull';
            $response['cart'] = $cart;
            break;
        case 'minusitem':
            $id = $_POST['id'];
            $stmt = $conn->prepare("SELECT quantity from cart where id= :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $quantity1 = $stmt->fetchAll();
            $quantity2 = (int)$quantity1[0]['quantity'];
            $quantity2=$quantity2-1;
            $quantity2=strval($quantity2);
            $stmt = $conn->prepare("UPDATE cart set quantity= :quantity where id= :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->bindParam(":quantity", $quantity2, PDO::PARAM_STR);
            $stmt->execute();
            $response['error'] = false;
            $response['message'] = 'Minus';
            break;
        case 'plusitem':
            $id = $_POST['id'];
            $idp = $_POST['idp'];
            $stmt = $conn->prepare("SELECT quantity from product where id= :idp");
            $stmt->bindParam(":idp", $idp, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $available = (int)$result[0]['quantity'];

            $stmt = $conn->prepare("SELECT quantity from cart where id= :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $quantity1 = $stmt->fetchAll();
            $quantity2 = (int)$quantity1[0]['quantity'];

            if($available>$quantity2) {
                $quantity2 = $quantity2 + 1;
                $quantity2 = strval($quantity2);
                $stmt = $conn->prepare("UPDATE cart set quantity= :quantity where id= :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_STR);
                $stmt->bindParam(":quantity", $quantity2, PDO::PARAM_STR);
                $stmt->execute();
                $response['error'] = false;
            } else {
                $response['error'] = true;
                $response['message'] = 'We have no more pieces for this product';
            }
            break;
        case 'removeitem':
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM cart WHERE id= :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            $response['error'] = false;
            $response['message'] = 'Plus';
            break;
    }
}
echo json_encode($response);