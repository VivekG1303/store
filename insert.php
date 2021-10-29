<?php

include_once 'dbconn.php';
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

            
            $sql = "SELECT category_name FROM category WHERE category_name='".$_POST['category_name']."'";

            $select = mysqli_query($conn, $sql);

            if (mysqli_num_rows($select) > 0) {
    
                $message = 'Category already added!';
                
    
            } else {

                // File upload path
                $targetDir = "../upload/category_image/";
                $fileName = basename($_FILES["category_image"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                // Removing Extension
                $imageName = basename($fileName, ".".$fileType);
                // Allow certain file formats
                $allowTypes = array('jpg','png','jpeg');

                if(in_array($fileType, $allowTypes)){
                        // Upload file to server
                        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/"  . $fileName)==false){
    
                            move_uploaded_file($_FILES["category_image"]["tmp_name"], $targetFilePath);
    
                        }else{
    
                            //rename the file if another one exist
                            $new_dir= "$targetDir".$imageName.time().".".$fileType;
                            $fileName = $imageName.time().".".$fileType;
                            move_uploaded_file($_FILES["category_image"]["tmp_name"],$new_dir) ;	
    
                         }

                        //Create Time
                        $created_at = date("d-m-Y");

                        // Insert image file name into database
                        $sql = "INSERT INTO category(category_name, category_image, category_description, created_at) VALUES ('".$_POST['category_name']."', '".$fileName."', '".$_POST['category_description']."', '".$created_at."')";

                        $insert = mysqli_query($conn, $sql);

                        $message = "New Category Added";

                } else {

                    $message = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                }
    
    
            }
        }

    }

    if ($_POST['action'] == 'product_register') {

        if ($_POST['product_name'] !== '' && $_POST['product_category'] !== '' && $_POST['product_sku'] !== ''  && $_POST['product_description'] !== ''  && $_POST['product_price'] !== '' &&  $_FILES['product_image']['name'] !== ''  &&  $_FILES['product_video']['name'] !== '' && $_POST['product_quantity'] !== '' && $_POST['product_status'] !== '') {
            
            $sql = "SELECT product_name FROM product WHERE product_name='".$_POST['product_name']."'";

            $select = mysqli_query($conn, $sql);

            if (mysqli_num_rows($select) > 0) {
    
                $message = 'Product already added!';
    
            } else {
                $filename = array();
                for ($i = 0; $i < count($_FILES['product_image']); $i++) {

                // File upload path
                $imagetargetDir = "../upload/product_image/";
                $imagefileName = basename($_FILES["product_image"]["name"][$i]);
                $imagetargetFilePath = $imagetargetDir . $imagefileName;
                $imagefileType = pathinfo($imagetargetFilePath,PATHINFO_EXTENSION);

                // Removing Extension
                $imageName = basename($imagefileName, ".".$imagefileType);

                // Allow certain file formats
                $imageallowTypes = array('jpg','png','jpeg');

                if(in_array($imagefileType, $imageallowTypes)){
                    // Upload file to server
                    if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/"  . $imagefileName)==false){
                        $filename[] = $imagefileName;

                        move_uploaded_file($_FILES["product_image"]["tmp_name"][$i], $imagetargetFilePath);

                    }else{

                        //rename the file if another one exist
                        $new_dir= "$imagetargetDir".$imageName.time().".".$imagefileType;
                        $filename[] = $imageName.time().".".$imagefileType;
                        move_uploaded_file($_FILES["product_image"]["tmp_name"][$i],$new_dir) ;	

                     }
                    
                }

                }

                $videotargetDir = "../upload/product_video/";
                $videofileName = basename($_FILES["product_video"]["name"]);
                $videotargetFilePath = $videotargetDir . $videofileName;
                $videofileType = pathinfo($videotargetFilePath,PATHINFO_EXTENSION);

                
                $videoName = basename($videofileName, ".".$videofileType);

                $videoallowTypes = array('mp4','3gp','webm');

                //Video upload
                if(in_array($videofileType, $videoallowTypes)){

                    // Upload file to server
                    if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/"  . $videofileName)==false){

                        move_uploaded_file($_FILES["product_video"]["tmp_name"], $videotargetFilePath);

                    }else{

                        //rename the file if another one exist
                        $new_dir= "$videotargetDir".$videoName.time().".".$videofileType;
                        $videofileName = $videoName.time().".".$videofileType;
                        move_uploaded_file($_FILES["product_video"]["tmp_name"],$new_dir) ;	

                     }
                }

                //Create Time
                $created_at = date("d-m-Y");

                //Serializing Image Name array
                $serialized_array = serialize($filename); 

                // Insert image file name into database
                $sql = "INSERT INTO product(product_name, product_category, product_sku, product_description, product_price, product_image, product_video, product_quantity, product_status, created_at) VALUES ('".$_POST['product_name']."', '".$_POST['product_category']."', '".$_POST['product_sku']."',  '".$_POST['product_description']."',  '".$_POST['product_price']."', '".$serialized_array."', '".$videofileName."', '".$_POST['product_quantity']."', '".$_POST['product_status']."', '".$created_at."')";

                $insert = mysqli_query($conn, $sql);

                $message = "New Product Added";
    
            }
        }

    }

    if ($_POST['action'] == 'customer_register') {

        if ($_POST['customer_firstname'] !== '' && $_POST['customer_lastname'] !== '' && $_POST['customer_email'] !== ''  && $_POST['customer_mobilenumber'] !== ''  && $_POST['customer_address'] !== '') {
            
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
                $sql = "INSERT INTO customer(customer_firstname, customer_lastname, customer_email, customer_mobilenumber, customer_address, created_at) VALUES ('".$_POST['customer_firstname']."', '".$_POST['customer_lastname']."', '".$_POST['customer_email']."',  '".$_POST['customer_mobilenumber']."',  '".$_POST['customer_address']."', '".$created_at."')";

                $insert = mysqli_query($conn, $sql);

                $message = "New Customer Added";
    
            }
        }
    }

    //Category Update Section
    if ($_POST['action'] == 'category_details') {

        if (!empty($_POST['id'])) {

            $sql = "SELECT category_name, category_image, category_description FROM category WHERE category_id=". $_POST['id'];

            $imageselect = mysqli_query($conn, $sql);

            $data = array();
            while ($row = mysqli_fetch_assoc($imageselect)) {
                $data = $row;
            }
            echo json_encode($data);

        }

    }

    if ($_POST['action'] == 'category_update') {

        if (!empty($_POST['id'])) {

            if (!empty($_FILES['category_image_update']['name'])) {
                
                // File upload path
                $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/";
                $fileName = basename($_FILES["category_image_update"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                // Allow certain file formats
                $allowTypes = array('jpg','png','jpeg');

                if(in_array($fileType, $allowTypes)){

                    // Upload file to server
                    if(move_uploaded_file($_FILES["category_image_update"]["tmp_name"], $targetFilePath)){

                            unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/".$_POST['current_image']);
                        //Create Time
                        $updated_at = date("d-m-Y");

                        // Insert image file name into database
                        $sql = "UPDATE category SET category_image='".$fileName."', updated_at='".$updated_at."' WHERE category_id=".$_POST['id'];

                        $insert = mysqli_query($conn, $sql);

                        echo 1;

                    }

                }

            }

            //Create Time
            $updated_at = date("d-m-Y");

            $sql = "UPDATE category SET category_name='".$_POST['category_name']."', category_description='".$_POST['category_description']."', updated_at='".$updated_at."' WHERE category_id=".$_POST['id'];

            $update = mysqli_query($conn, $sql);

        }

    }

    if ($_POST['action'] == 'category_delete') {

        if (!empty($_POST['id'])) {

            $sql = "SELECT category_image FROM category WHERE category_id=". $_POST['id'];

            $select = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($select)) {

            unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/".$row['category_image']);

            }

            $sql = "DELETE FROM category WHERE category_id=".$_POST['id'];

            $delete = mysqli_query($conn, $sql);

            echo 1;

        }

    }

    //Product Update Section
    if ($_POST['action'] == 'product_details') {

        if (!empty($_POST['id'])) {

            $sql = "SELECT * FROM product WHERE product_id=". $_POST['id'];

            $imageselect = mysqli_query($conn, $sql);

            $data = array();
            $image = array();
            while ($row = mysqli_fetch_assoc($imageselect)) {
                $unserialized = unserialize($row['product_image']);
                $image = $unserialized;
                $data = $row;
            }
            echo json_encode(array("image" => $image, "detail" => $data));

        }

    }

    if ($_POST['action'] == 'product_update') {

        if (!empty($_POST['id'])) {

            if(!empty($_FILES['product_image']['name'])) {

                $sql = "SELECT product_image FROM product WHERE product_id=". $_POST['id'];
    
                $select = mysqli_query($conn, $sql);
    
                $image = array();
    
                while($row = mysqli_fetch_assoc($select)) {
                    $image = $row['product_image'];
                }
    
                $image_array = unserialize($image);
    
                for ($i = 0; $i < count($_FILES['product_image']); $i++) {
    
                    // File upload path
                    $imagetargetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/";
                    $imagefileName = basename($_FILES["product_image"]["name"][$i]);
                    $imagetargetFilePath = $imagetargetDir . $imagefileName;
                    $imagefileType = pathinfo($imagetargetFilePath,PATHINFO_EXTENSION);
        
                    // Removing Extension
                    $imageName = basename($imagefileName, ".".$imagefileType);
        
                    // Allow certain file formats
                    $imageallowTypes = array('jpg','png','jpeg');
                    
                    if(in_array($imagefileType, $imageallowTypes)){
                        // Upload file to server
                        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/"  . $imagefileName)==false){
                            $image_array[] = $imagefileName;
        
                            move_uploaded_file($_FILES["product_image"]["tmp_name"][$i], $imagetargetFilePath);
                            
                        }else{
        
                            //rename the file if another one exist
                            $new_dir= "$imagetargetDir".$imageName.time().".".$imagefileType;
                            $image_array[] = $imageName.time().".".$imagefileType;
                            move_uploaded_file($_FILES["product_image"]["tmp_name"][$i],$new_dir) ;	
                            
                            }
                        
                    }
        
                }
    
                $image_new = serialize($image_array);
                //Create Time
                $updated_at = date("d-m-Y");
    
                $sql = "UPDATE product SET product_image='".$image_new."', updated_at='".$updated_at."' WHERE product_id=".$_POST['id'];
    
                $update = mysqli_query($conn, $sql);

            }

            if (!empty($_FILES['product_video']['name'])) {
                
                // File upload path
                $videotargetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/";
                $videofileName = basename($_FILES["product_video"]["name"]);
                $videotargetFilePath = $videotargetDir . $videofileName;
                $videofileType = pathinfo($videotargetFilePath,PATHINFO_EXTENSION);

                $videoallowTypes = array('mp4','3gp','webm');

                if(in_array($videofileType, $videoallowTypes)){

                    // Upload file to server
                    if(move_uploaded_file($_FILES["product_video"]["tmp_name"], $videotargetFilePath)){

                        unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/".$_POST['current_video']);
                        //Create Time
                        $updated_at = date("d-m-Y");

                        $sql = "UPDATE product SET product_video='".$videofileName."', updated_at='".$updated_at."' WHERE product_id=".$_POST['id'];

                        $insert = mysqli_query($conn, $sql);

                    }

                }

            }

            //Create Time
            $updated_at = date("d-m-Y");

            $sql = "UPDATE product SET product_name='".$_POST['product_name']."', product_category='".$_POST['product_category']."', product_sku='".$_POST['product_sku']."', product_description='".$_POST['product_description']."', product_price='".$_POST['product_price']."', product_quantity='".$_POST['product_quantity']."', product_status='".$_POST['product_status']."', updated_at='".$updated_at."' WHERE product_id=".$_POST['id'];

            $update = mysqli_query($conn, $sql);

            echo 1;

        }

    }

    if ($_POST['action'] == 'single_image_delete') {

        if (!empty($_POST['id'])) {

            $sql = "SELECT product_image FROM product WHERE product_id=". $_POST['id'];

            $select = mysqli_query($conn, $sql);

            $image = array();

            while($row = mysqli_fetch_assoc($select)) {
                $image = $row['product_image'];
            }

            $image_array = unserialize($image);

            if (!empty($_POST['image'])) {

                unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/".$_POST['image']);

                if (($key = array_search($_POST['image'], $image_array)) !== false) {
                    unset($image_array[$key]);
                }

            }
            $image_array = array_values($image_array);
            $image_new = serialize($image_array);
            //Create Time
            $updated_at = date("d-m-Y");

            $sql = "UPDATE product SET product_image='".$image_new."', updated_at='".$updated_at."' WHERE product_id=".$_POST['id'];

            $delete = mysqli_query($conn, $sql);

            echo 1;

        }

    }

    if ($_POST['action'] == 'image_update') {

        if(!empty($_POST['id'])) {

            $sql = "SELECT product_image FROM product WHERE product_id=". $_POST['id'];

            $select = mysqli_query($conn, $sql);

            $image = array();

            while($row = mysqli_fetch_assoc($select)) {
                $image = $row['product_image'];
            }

            $image_array = unserialize($image);

            for ($i = 0; $i < count($_FILES['product_image']); $i++) {

                // File upload path
                $imagetargetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/";
                $imagefileName = basename($_FILES["product_image"]["name"][$i]);
                $imagetargetFilePath = $imagetargetDir . $imagefileName;
                $imagefileType = pathinfo($imagetargetFilePath,PATHINFO_EXTENSION);
    
                // Removing Extension
                $imageName = basename($imagefileName, ".".$imagefileType);
    
                // Allow certain file formats
                $imageallowTypes = array('jpg','png','jpeg');
                
                if(in_array($imagefileType, $imageallowTypes)){
                    // Upload file to server
                    if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/"  . $imagefileName)==false){
                        $image_array[] = $imagefileName;
    
                        move_uploaded_file($_FILES["product_image"]["tmp_name"][$i], $imagetargetFilePath);
                        
                    }else{
    
                        //rename the file if another one exist
                        $new_dir= "$imagetargetDir".$imageName.time().".".$imagefileType;
                        $image_array[] = $imageName.time().".".$imagefileType;
                        move_uploaded_file($_FILES["product_image"]["tmp_name"][$i],$new_dir) ;	
                        
                     }
                    
                }
    
            }

            $image_new = serialize($image_array);
            //Create Time
            $updated_at = date("d-m-Y");

            $sql = "UPDATE product SET product_image='".$image_new."', updated_at='".$updated_at."' WHERE product_id=".$_POST['id'];

            $update = mysqli_query($conn, $sql);
            echo 1;
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
    
}


?>