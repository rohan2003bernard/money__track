<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money</title>
    <link rel="stylesheet" href="style.css">
</head>
<body> 
    <div>
        <div id="top_bar">
            <label id="label"></label>
        </div>
        <nav class="active" id="nav">
            <div id='ul'>
                <a <?php if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/add_send.php?page=receive") echo 'class="active"'; ?> id="receive" href="http://localhost/money_track/add_send.php?page=receive">Money Received</a>
                <a id="total" href="http://localhost/money_track/display.php">Total</a>
                <a <?php if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/add_send.php?page=send") echo 'class="active"'; ?> id="spent" href="http://localhost/money_track/add_send.php?page=send">Money Spent</a>
    
                </div>
        </nav>
        <div id="main_body">
            <div id="container">
                <form method="post">
                    <label id="amount_label">Amount :</label>
                    <input name="amount" id="amount" type="number" placeholder="Enter amount">

                    <label id="source_label"></label>
                    <input name="source" id="source" type="text" placeholder="Enter Source or Sender">

                    <label id="reason_label">Reason :</label>
                    <textarea name="reason" id="reason" cols="30" rows="5" placeholder="Enter Reason"></textarea>

                    <input  id="submit" name="submit" type="submit">
                    <button id="clr_btn" onclick=clr_fields()>Clear</button>

                    <div id="message">
            <label id="mes"></label>
            <button id="ok" onclick=hide()>Ok</button>
        </div>
                </form>
                
    </div>
<!------------------------------------------------------------------------------------------------------------------------------------>
    <?php

    $dbHost = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "track";
    $con = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/add_send.php?page=send"){
        echo"<script>document.getElementById('label').textContent='Spent Money';
        document.getElementById('source_label').textContent='Receiver Name';
        document.getElementById('message').style.visibility='hidden';        
        </script>";
    if (isset($_POST['submit'])){
        $amount=$_POST['amount'];
        $source=$_POST["source"];
        $reason=$_POST["reason"];
        
        $date=date("Y-m-d");
        date_default_timezone_set("Asia/Kolkata");
        $time=date("h:i a");

        $sql="insert into info(amount,status,reason,source,date,time) values ($amount,'spent','$reason','$source','$date','$time')";

        $con->query($sql);
        
        echo "<script>
        document.getElementById('message').style.visibility='visible';
        document.getElementById('mes').textContent='You have sent ₹$amount to $source for $reason';
        setTimeout(() => {
            document.getElementById('message').style.visibility='hidden';            
        }, 3000);        
    </script>";
    
    }
    
}elseif ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" == "http://localhost/money_track/add_send.php?page=receive"){
    echo"<script>document.getElementById('label').textContent='Received Money';
    document.getElementById('source_label').textContent='Sender Name';
    document.getElementById('message').style.visibility='hidden';
    </script>";
if (isset($_POST['submit'])){
    $amount=$_POST['amount'];
    $source=$_POST["source"];
    $reason=$_POST["reason"];

    $date=date("Y-m-d");
    date_default_timezone_set("Asia/Kolkata");
    $time=date("h:ia");

    $sql="insert into info(amount,status,reason,source,date,time) values ($amount,'received','$reason','$source','$date','$time')";

    $con->query($sql);
    
    echo "<script>
    document.getElementById('message').style.visibility='visible';
        document.getElementById('mes').textContent='You have recevied ₹$amount from $source for $reason';
        setTimeout(() => {
            document.getElementById('message').style.visibility='hidden';            
        }, 3000);

</script>";

}}
    ?>

    <script>
        function hide(){
        document.getElementById('mes').textContent='';
        document.getElementById('message').style.visibility='hidden';
    }

    function clr_fields(){
        document.getElementById("amount").value='';
        document.getElementById("reason").value='';
        document.getElementById("source").value='';
    }
    </script>
</body>
</html>