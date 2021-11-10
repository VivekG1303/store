<?php
if ($_POST['action'] == 'admin_login') {
        
        if ($_POST['userid'] !== '' && $_POST['password'] !== '') {

            $sql = "SELECT * FROM admin_login WHERE userid='".$_POST['userid']."' and password='".md5($_POST['password'])."'";
    
            $select = mysqli_query($conn, $sql);
    
            if (mysqli_num_rows($select) > 0) {

                $_SESSION['admin_userid'] = $_POST['userid'];
                $_SESSION['admin_password'] = md5($_POST['password']);
    
                header("Location: admin_panel.php");
    
            } else {
    
                $message = 'Please enter the valid details';
    
            }
    
        } else {
    
            $message = 'Please enter the valid details2';
    
        }
    }

if ($_POST['action'] == 'customer_register') {

    if ($_POST['customer_firstname'] !== '' && $_POST['customer_lastname'] !== '' && $_POST['customer_email'] !== ''  && $_POST['customer_mobilenumber'] !== ''  && $_POST['customer_address'] !== ''  && $_POST['customer_password'] !== '') {
        
        $sql = "SELECT customer_email FROM customer WHERE customer_email='".$_POST['customer_email']."'";

        $select = mysqli_query($conn, $sql);

        if (mysqli_num_rows($select) > 0) {

            $message = 'Email already registered!';

        } else {
            
            //Create Time
            $created_at = date("d-m-Y");

            //Serializing Image Name array
            $serialized_array = serialize($filename); 

            // Insert image file name into database
            $sql = "INSERT INTO customer(customer_firstname, customer_lastname, customer_email, customer_mobilenumber, customer_address, customer_password, created_at) VALUES ('".$_POST['customer_firstname']."', '".$_POST['customer_lastname']."', '".$_POST['customer_email']."',  '".$_POST['customer_mobilenumber']."', '".$_POST['customer_address']."', '".md5($_POST['customer_password'])."', '".$created_at."')";

            $insert = mysqli_query($conn, $sql);

            if ($insert) {
                $_SESSION['customer_firstname'] = $_POST['customer_firstname'];
                $_SESSION['customer_firstname'] = $_POST['customer_lastname'];
                $_SESSION['customer_password'] = $_POST['customer_password'];
                $_SESSION['customer_address'] = $_POST['customer_address'];
                $_SESSION['customer_mobilenumber'] = $_POST['customer_mobilenumber'];
                $_SESSION['customer_email'] = $_POST['customer_email'];
                header('Location: index.php');
            }

            $message = "New Customer Added";

        }
    }
}

if ($_POST['action'] == 'customer_signin') {

    if (!empty($_POST['customer_email'])) {
        
        $sql = "SELECT customer_firstname,customer_lastname, customer_password, customer_address, customer_email, customer_mobilenumber FROM customer WHERE customer_email='".$_POST['customer_email']."' AND customer_password='".md5($_POST['customer_password'])."'";

        $select = mysqli_query($conn, $sql);

        if (mysqli_num_rows($select) > 0) {
            while ($row = mysqli_fetch_assoc($select)) {
            $_SESSION['customer_firstname'] = $row['customer_firstname'];
            $_SESSION['customer_lastname'] = $row['customer_lastname'];
            $_SESSION['customer_password'] = $row['customer_password'];
            $_SESSION['customer_address'] = $row['customer_address'];
            $_SESSION['customer_mobilenumber'] = $row['customer_mobilenumber'];
            $_SESSION['customer_email'] = $row['customer_email'];
            header('Location: index.php');
            }
        } 
    }
}
?>     