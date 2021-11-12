<?php
if ($_POST['action'] == 'admin_login') {
        
        if ($_POST['userid'] !== '' && $_POST['password'] !== '') {

            $id = $_POST['userid'];
            $password = $_POST['password'];

            $admin = new login();
            $login = $admin->adminLogin($id, $password);

            $message = $login;
    
        } else {
    
            $message = 'Please enter the valid details';
    
        }
    }

if ($_POST['action'] == 'customer_register') {

    if ($_POST['customer_firstname'] !== '' && $_POST['customer_lastname'] !== '' && $_POST['customer_email'] !== ''  && $_POST['customer_mobilenumber'] !== ''  && $_POST['customer_address'] !== ''  && $_POST['customer_password'] !== '') {
        
        $post = $_POST;

        $customer = new login();
        $signup = $customer->signUpLogin($post);
        $message = $signup;
    }
}

if ($_POST['action'] == 'customer_signin') {

    if (!empty($_POST['customer_email'])) {
        
        $post = $_POST;
        $customer =  new login();
        $login = $customer->customerlogin($post);

    }
}

if ($_POST['action'] == 'customer_details') {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $customer = new login();
        $data = $customer->detailsCustomer($id);

        echo json_encode($data);

    }
}

if ($_POST['action'] == 'customer_update') {

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $customer_firstname = $_POST['customer_firstname'];
        $customer_lastname = $_POST['customer_lastname'];
        $customer_email = $_POST['customer_email'];
        $customer_mobilenumber = $_POST['customer_mobilenumber'];
        $customer_address = $_POST['customer_address'];
            
        $customer = new login();
        $update = $customer->updateCustomer($id, $customer_firstname, $customer_lastname, $customer_email, $customer_mobilenumber, $customer_address);

        if ($update) {
            echo 1;
        }

    }
}

if ($_POST['action'] == 'customer_delete') {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $customer = new login();
        $delete = $customer->deleteCustomer($id);

        if ($delete) {
            echo 1;
        }
    }
}

?>     