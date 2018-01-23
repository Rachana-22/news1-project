<?php
session_start();
if(!(isset($_SESSION['uid']) && ($_SESSION['uid'] == "admin"))){
    header("Location:login.php");
}else{
    $message = "";
    if(isset($_POST['addmoney'])){
        if(isset($_POST['uid'])&&isset($_POST['amt'])){
            require "database.php";
            $sql = "UPDATE `useraccnt` SET `balance`=`balance`+'".$_POST['amt']."' WHERE 
            `uid` = '".$_POST['uid']."';";
            if($mysqli->query($sql)){
                $message = "Transaction Successful!";
            }else{
                $message = "Transaction Unsuccessful!";
            }
            $mysqli->close();
        }else{
            $message = "Transaction Unsuccessful!";
        }
    }
    ?>
    <form method="post" action="">
        <label>Username : </label>
        <input name="uid" type="text"><br>
        <label>Amount : </label>
        <input name="amt" type="text"><br>
        <label><?php echo $message;?></label><br>
        <button name="addmoney" type="submit">Add Money</button>
    </form>
    <table align="center" class="table">
        <thead>
        <tr>
            <th>Item</th>
            <th>Rate</th>
            <th>Quantity</th>
            <th>Cost</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require "database.php";
        $i = 0;
        $sql = "SELECT DISTINCT `billno`,`uid` FROM `queue`;";
        if($result = $mysqli->query($sql)){
            while($bills = $result->fetch_assoc()) {
                $sql = "SELECT * FROM `queue` WHERE `billno`='".$bills['billno']."';";
                echo "<tr><td><b> Bill No : ".$bills['billno']." User ID: ".$bills['uid']."</b></td>
                        <td></td>
                        <td></td>
                        <td></td></tr>";
                if($items = $mysqli->query($sql)){
                    while($item = $items->fetch_assoc()){
                        echo "<tr>";
                        echo "<td><label>".$item['itemid']."</label></td>";
                        echo "<td><label>".$item['rate']."</label></td>";
                        echo "<td><label>".$item['quantity']."</label></td>";
                        echo "<td><label>".$item['cost']."</label></td>";
                        echo "</tr>";
                    }
                }else{
                    die("Item Not Cooked!!!");
                }
            }
        }else{
            die ("Facing Issues!!!");
        }
        $mysqli->close();
        ?>
        </tbody>
    </table>

    <?php

}
?>
