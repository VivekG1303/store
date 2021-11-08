<?php

include_once 'dbconn.php';
include_once 'classes/inc/autoload.php';
session_start();

if(!empty($_POST)) {

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

    if ($_POST['action'] == 'category_register') {

        if ($_POST['category_name'] !== ''&&  $_FILES['category_image']['name'] !== '' && $_POST['category_description'] !== '') {

            $category_name = $_POST['category_name'];

            $category = new category();

            $check = $category->checkCategory($category_name);

            if ($check) {
    
                $message = 'Category already added!';
    
            } else {
                
                    $files = $_FILES;
                    $category_name = $_POST['category_name'];
                    $category_image = $fileName;
                    $category_description = $_POST['category_description'];
                    $created_at = date("d-m-Y");

                    $insert = $category->insertCategory($files, $category_name, $category_description, $created_at);
                    if ($insert) {
                    $message = "New Category Added";
                    }

    
            }
        }
    }

    if ($_POST['action'] == 'product_register') {

        if ($_POST['product_name'] !== '' && $_POST['product_category'] !== '' && $_POST['product_sku'] !== ''  && $_POST['product_description'] !== ''  && $_POST['product_price'] !== '' &&  $_FILES['product_image']['name'] !== ''  &&  $_FILES['product_video']['name'] !== '' && $_POST['product_quantity'] !== '' && $_POST['product_status'] !== '') {
            
            $product_name = $_POST['product_name'];

            $product = new product();

            $check = $product->checkProduct($product_name);

            if ($check) {
    
                $message = 'Product already added!';
    
            } else {
                $files = $_FILES;
                $product_name = $_POST['product_name'];
                $product_category= implode(' , ', $_POST['product_category']);
                $product_sku = $_POST['product_sku'];
                $product_description = $_POST['product_description'];
                $product_price = $_POST['product_price'];
                $product_quantity = $_POST['product_quantity'];
                $product_status = $_POST['product_status']; 

                $product = new product();
                $insert = $product->insertProduct($files, $product_name, $product_category, $product_sku, $product_description, $product_price, $product_quantity, $product_status);

                if ($insert) {
                    $message = "New Product Added";
                }
    
            }
        }
    }

    //Category Update Section
    if ($_POST['action'] == 'category_details') {

        if (!empty($_POST['id'])) {

            $id = $_POST['id'];

            $category = new category();
            $data = $category->detailsCategory($id);

            echo json_encode($data);

        }
    }

    if ($_POST['action'] == 'category_update') {

        if (!empty($_POST['id'])) {
            $files = $_FILES;
            $id = $_POST['id'];
            $category_name = $_POST['category_name'];
            $category_description = $_POST['category_description'];
            $current_image = $_POST['current_image'];
             
            $category = new category();
            $update = $category->updateCategory($files, $id, $category_name, $category_description, $current_image);

            if ($update) {
                echo 1;
            }

        }
    }

    if ($_POST['action'] == 'category_delete') {

        if (!empty($_POST['id'])) {

            $id = $_POST['id'];

            $category = new category();
            $delete = $category->deleteCategory($id);

            if ($delete) {
                echo 1;
            }
        }
    }

    //Product Update Section
    if ($_POST['action'] == 'product_details') {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];

            $product = new product();

            list($image, $data) = $product->detailsProduct($id);
            
            echo json_encode(array("image" => $image, "detail" => $data));

        }
    }

    if ($_POST['action'] == 'product_update') {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $files = $_FILES;
            $product_name = $_POST['product_name'];
            $product_category= implode(' , ', $_POST['product_category']);
            $product_sku = $_POST['product_sku'];
            $product_description = $_POST['product_description'];
            $product_price = $_POST['product_price'];
            $product_quantity = $_POST['product_quantity']; 
            $product_status = $_POST['product_status']; 
            $current_video = $_POST['current_video'];

            $product = new product();
            $update = $product->updateProduct($files, $id, $product_name, $product_category, $product_sku, $product_description, $product_price, $product_quantity, $product_status, $current_video);

            if ($update) {
            echo 1;
            }
        }
    }

    if ($_POST['action'] == 'single_image_delete') {

        if (!empty($_POST['id'])) {



            echo 1;

        }

    }

    if ($_POST['action'] == 'single_image_delete') {

        if(!empty($_POST['id'])) {

            $id = $_POST['id'];
            $image = $_POST['image'];

            $product = new product();
            $delete = $product->imageDeleteProduct($id, $image);

            if ($delete) {
                echo 1;
            }
        } 

    }

    if ($_POST['action'] == 'product_delete') {

        if (!empty($_POST['id'])) {

            $sql = "SELECT product_image, product_video FROM product WHERE product_id=". $_POST['id'];

            $select = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($select)) {

                $image = $row['product_image'];
                $video = $row['product_video'];

            }

            $image_array = unserialize($image);

            for($i=0; $i<count($image_array); $i++) {

                unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/".$image_array[$i]);

            }

            unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/".$video);

            $sql = "DELETE FROM product WHERE product_id=".$_POST['id'];

            $delete = mysqli_query($conn, $sql);

            echo 1;

        }

    }

    if ($_POST['action'] == 'product_quantity_check') {

        if (!empty($_POST['id'])) {

            $id = $_POST['id'];
            $value = $_POST['value'];

            $check = new product();
            $data = $check->quantityCheckProduct($id, $value);

            if($data) {
                echo $data;
            }

        }

    }

    //Customer Section
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

    if ($_POST['action'] == 'carousel_register') {

        if (!empty($_POST['carousel_link'])) {

            $files = $_FILES;
            $carousel_link = $_POST['carousel_link'];

            $carousel = new carousel();
            $insert = $carousel->insertCarousel($files, $carousel_link);

        }

    }

    if ($_POST['action'] == 'carousel_details') {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];

            $carousel = new carousel();
            $data = $carousel->detailsCarousel($id);

            echo json_encode($data);
        }
    
    }

    if ($_POST['action'] == 'carousel_update') {

        if (!empty($_POST['id'])) {
            $files = $_FILES;
            $id = $_POST['id'];
            $carousel_link = $_POST['carousel_link'];
            $current_image = $_POST['current_image'];

            $carousel = new carousel();
            $update = $carousel->updateCarousel($files, $id, $carousel_link, $current_image);
            if($update) {
                echo 1;
            }
        }
    }

    if ($_POST['action'] == 'carousel_delete') {

        if (!empty($_POST['id'])) {

            $id = $_POST['id'];

            $carousel = new carousel();
            $delete = $carousel->deleteCarousel($id);

            if ($delete) {
                echo 1;
            }
        }
    }

    //Add To Cart Section
    if ($_POST['action'] == 'add_to_cart') {

        if (!empty($_POST['id'])) {

            $id = $_POST['id'];
            $value = $_POST['value'];
            $unique = $_SESSION['customer_email'];

            $addToCart = new cart();
            $add = $addToCart->addToCart($id, $value, $unique);

            if ($add) {
                echo 1;
            }
        }
    }

    if ($_POST['action'] == 'delete_from_cart') {

        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $unique = $_SESSION['customer_email'];

            $deleteFromCart = new cart();
            $add = $deleteFromCart->deleteCartItem($id, $unique);
        }
    }

    if ($_POST['action'] == 'update_cart_item') {
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $value = $_POST['value'];
            $unique = $_SESSION['customer_email'];

            $updateCartItem = new cart();
            $add = $updateCartItem->updateCartItem($id, $value, $unique);
        }
    }

    if ($_POST['action'] == 'clear_cart') {
            $unique = $_SESSION['customer_email'];

            $clearCart = new cart();
            $clear = $clearCart->clearCart($unique);

            echo 1;
    }
    
    
}


?>