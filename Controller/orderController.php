<?php 
    require_once '..' . DIRECTORY_SEPARATOR . 'config.php';
    if(isset($_POST['addOrder']))
    {
        $newOrder = new Order();
        $newOrder->setTotalPrice($_POST["totalPrice"]);
        $newOrder->setOrderNotes($_POST["Notes"]);
        $newOrder->setUserId($_SESSION['userId']);
        $newOrder->setRoomNumber($_POST['room_no']);
        $orderId =  $newOrder->addOrder();
        //Getting All Products And Compare it to Current Order if exist Inser it
        $product = new Products();
        $result = $product->listAllProducts();
        while ($row = mysqli_fetch_assoc($result)) {
            $productName = $row['name'];
            if(isset($_POST[$productName]))
            {
                $productId = Products::GetProductIdByName($productName);
                if (Order::addRelated_Order_Product($orderId,$productId,$_POST[$productName]))
                    header("Location:../Views/userhome.php");
            }
        }
    }    
    //Response Will all Specified Order Info
    elseif(isset($_POST["orderId"]))
    {
        $orderInfo = new Order();
        $orderInfo->setOrderId($_POST['orderId']);
        $result = $orderInfo->listAllOrder_Related_Info();
        $allProduct = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $product = array(
                "quantity" => $row["quantity"],
                "name" => $row['name'],
                "price" => $row['price'],
                "product_picture" => $row['product_picture']
            );
            $allProduct[] = $product;
        }
        echo json_encode($allProduct);
    }
?>