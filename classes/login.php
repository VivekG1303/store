<?php

class login extends database {

    public function __construct()
	{
		parent::__construct();
	}

    public function adminLogin($id, $password){

        $sql = "SELECT * FROM admin_login WHERE userid='".$id."' and password='".md5($password)."'";
    
        $select = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($select) > 0) {

            $_SESSION['admin_userid'] = $id;
            $_SESSION['admin_password'] = md5($password);

            header("Location: admin_panel.php");

        } else {

            $message = 'Please enter the valid details';

        }

        return $message;
    }

    public function signUpLogin($post)
    {
        $sql = "SELECT customer_email FROM customer WHERE customer_email='".$post['customer_email']."'";

        $select = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($select) > 0) {

            $message = 'Email already registered!';

        } else {
            
            //Create Time
            $created_at = date("d-m-Y");

            // Insert image file name into database
            $sql = "INSERT INTO customer(customer_firstname, customer_lastname, customer_email, customer_mobilenumber, customer_address, customer_password, created_at) VALUES ('".$post['customer_firstname']."', '".$post['customer_lastname']."', '".$post['customer_email']."',  '".$post['customer_mobilenumber']."', '".$post['customer_address']."', '".md5($post['customer_password'])."', '".$created_at."')";

            $insert = mysqli_query($this->conn, $sql);

            if ($insert) {
                if($_POST['status'] !=='backend') {
                $_SESSION['customer_firstname'] = $post['customer_firstname'];
                $_SESSION['customer_lastname'] = $post['customer_lastname'];
                $_SESSION['customer_password'] = $post['customer_password'];
                $_SESSION['customer_address'] = $post['customer_address'];
                $_SESSION['customer_mobilenumber'] = $post['customer_mobilenumber'];
                $_SESSION['customer_email'] = $post['customer_email'];
                    header('Location: index.php');
                }
            }

            $message = "New Customer Added";

        }

        return $message;
    }

    public function customerlogin($post)
    {
        $sql = "SELECT customer_firstname,customer_lastname, customer_password, customer_address, customer_email, customer_mobilenumber FROM customer WHERE customer_email='".$post['customer_email']."' AND customer_password='".md5($post['customer_password'])."'";

        $select = mysqli_query($this->conn, $sql);

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

    public function detailsCustomer($id = '')
    {
        if(!empty($id)) {
            $sql = "SELECT * FROM customer WHERE customer_id=".$id;

            $select = mysqli_query($this->conn, $sql);

            while ($row = mysqli_fetch_assoc($select)) {
                $data = $row;
            }
            return $data;

        } else {
            $sql = "SELECT * FROM customer";

            $select = mysqli_query($this->conn, $sql);

            $data = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $data[] = $row;
            }
            return $data;
        }   
    }

    public function updateCustomer($id, $customer_firstname, $customer_lastname, $customer_email, $customer_mobilenumber, $customer_address)
    {
        $updated_at = date('d-m-Y');
        $sql = "UPDATE customer SET customer_firstname='".$customer_firstname."', customer_lastname='".$customer_lastname."', customer_email='".$customer_email."', customer_mobilenumber='".$customer_mobilenumber."', customer_address='".$customer_address."', updated_at='".$updated_at."' WHERE customer_id=".$id;

        $update = mysqli_query($this->conn, $sql);

        if ($update) {
            return true;
        }
    }

    public function deleteCustomer($id)
    {

        $sql = "DELETE FROM customer WHERE customer_id=".$id;

        $delete = mysqli_query($this->conn, $sql);

        if ($delete) {
            return true;
        }

    }

}

?>