<?php
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

        $id = $_POST['id'];

        $product = new product();
        $delete = $product->deleteProduct($id);

        if ($delete) {
            echo 1;
        }
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

if ($_POST['action'] == 'product_search') {

    $name = $_POST['name'];

    $search = new product();
    $data = $search->searchProduct($name);

    echo json_encode($data);

}

?>