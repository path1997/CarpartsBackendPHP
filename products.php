<?php
require_once 'DbConnect.php';
$response = array();

if (isset($_GET['apicall'])) {
    switch ($_GET['apicall']) {
        case 'category':
            $stmt = $conn->prepare("SELECT name,id FROM category");
            $stmt->execute();
            $category = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'Category successfull';
            $response['category'] = $category;
            break;
        case 'productlist':
                $id = $_POST['id'];

                $stmt = $conn->prepare("SELECT p.id,p.name,p.price,p.description,r.path FROM product p,photo r where p.visible=1 and category_id= :categoryida and p.id=r.product_id and r.position=1");
                $stmt->bindParam(":categoryida", $id, PDO::PARAM_STR);
                $stmt->execute();
                $products_list = $stmt->fetchAll(PDO::FETCH_OBJ);

                $response['error'] = false;
                $response['products'] = $products_list;
                //echo $category_id[0];
                break;
            //}
        case 'productlistforhome':
            $stmt = $conn->prepare("SELECT p.id,p.name,p.price,p.description,r.path FROM product p,photo r where p.visible=1 and p.id=r.product_id and r.position=1 ORDER BY p.id DESC LIMIT 10");
            $stmt->execute();
            $productlistforhome = $stmt->fetchAll(PDO::FETCH_OBJ);
            $response['error'] = false;
            $response['message'] = 'Home successfull';
            $response['productlistforhome'] = $productlistforhome;
            break;

        case 'productdetail':
            $product_id = $_POST['productid'];
            $stmt = $conn->prepare("SELECT name,price,description,quantity FROM product where id= :id");
            $stmt->bindParam(":id", $product_id, PDO::PARAM_STR);
            $stmt->execute();
            $productdetail = $stmt->fetchAll(PDO::FETCH_OBJ);

            $stmt = $conn->prepare("SELECT path,position FROM photo where product_id= :id");
            $stmt->bindParam(":id", $product_id, PDO::PARAM_STR);
            $stmt->execute();
            $productphotos = $stmt->fetchAll(PDO::FETCH_OBJ);

            $response['error'] = false;
            $response['message'] = 'Home successfull';
            $response['productdetail'] = $productdetail;
            $response['productphotos'] = $productphotos;
            break;
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}
echo json_encode($response);
function isTheseParametersAvailable($params)
{
    if (!isset($_POST[$params])) {
        return false;
    }
    return true;
}
