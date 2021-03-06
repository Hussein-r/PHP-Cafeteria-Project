<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <?php require_once '../config.php'; ?>
    <link href="../public/css/bootstrap.css" rel="stylesheet" />
    <link href="../public/css/font-awesome.css" rel="stylesheet" />
    <link href="../public/css/userOrders.css" rel="stylesheet" />
</head>
<body>
    <!------------- Navbar ------------->
    <?php include './userNavbar.php' ?>
    <!----------- Title -------------->
    <div>
        <h1 class="alert bg-light text-center text-primary">My Orders</h1>
    </div>
    <!----------- Content ------------->
    <div class="container">
        <div class="h5 mt-4">
            <form action="" method="POST">
                <label for="date">Date From</label>
                <input type="date" name="from" />
                <label for="date">Date To</label>
                <input type="date" name="to" />
                <input id="listOrder" type="submit" class="btn btn-success" value="showOrders" name="showOrders" />
            </form>
        </div>
        <!--------------Orders Table --------------->
        <div>
            <table class="table rounded table-hover  mt-3">
                <thead class="bg-info">
                    <tr>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                <?php
                //List Order within Days
                if(isset($_POST["showOrders"])){
                    $userSelectedOrder = new Order();
                    $userSelectedOrder->setUserId($_SESSION['userId']);
                    $result = $userSelectedOrder->listDatedOrders($_POST["from"],$_POST["to"]);
                    if(!$result || intval(mysqli_num_rows($result)) == 0){ ?>
                        <tr><td colspan="4" class="text-center" style="font-weight: bold">There is No Order Between This Date</td></tr>
                    <?php
                    }else
                    {
                        while ($row = mysqli_fetch_assoc($result)) {?>
                        <tr>
                            <th><?php echo $row['order_date']; ?>
                                <a class="btn btn-primary showOrder" onclick="showOrder(<?php echo $row['id']; ?>,this)">+</a>
                            </th>
                            <td>
                                <?php 
                                    echo ($row['status'] == "1" ) ? "Processing " : (($row['status'] == "2") ? "Out Of Deliver" : "Done"); 
                                ?>
                            </td>
                            <td><?php echo $row['amount']; ?></td>
                            <td>
                                <?php 
                                    if(($row['status'] == "1" )){ ?>
                                        <a href="#" class="btn btn-success btn-sm">Cancel Order</a>
                                <?php }?>
                            </td>
                        </tr>
                <?php   }
                    } ?>
                <?php }
                else{ 
                    $userOrder = new Order();
                    $userOrder->setUserId($_SESSION['userId']);
                    $result = $userOrder->listOrders();
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <th><?php echo $row['order_date']; ?>
                                <a class="btn btn-primary showOrder" onclick="showOrder(<?php echo $row['id']; ?>,this)">+</a>
                            </th>
                            <td>
                                <?php 
                                    echo ($row['status'] == "1" ) ? "Processing " : (($row['status'] == "2") ? "Out Of Deliver" : "Done"); 
                                ?>
                            </td>
                            <td><?php echo $row['amount']; ?></td>
                            <td>
                                <?php 
                                    if(($row['status'] == "1" )){ ?>
                                        <a href="#" class="btn btn-success btn-sm">Cancel Order</a>
                                <?php }?>
                            </td>
                        </tr>
                <?php } ?>
                </tbody>
                <?php }?>
            </table>
        </div>
        <div class="row text-center">
            <div class="orderImages">
                
            </div>
        </div>
    </div>
    <script src="../public/js/JQuery-3.3.1.min.js"></script>
    <script src="../public/js/popper.js"></script>
    <script src="../public/js/bootstrap.js"></script>
    <script src="../public/js/moveOrders.js"></script>
</body>

</html>