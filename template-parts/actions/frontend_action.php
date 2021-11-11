<?php
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

if ($_POST['action'] == 'apply_coupen') {

    $id = $_POST['id'];
    $unique = $_SESSION['customer_email'];

    $coupen = new coupen();
    $data = $coupen->detailsCoupen($id);

    $discount = $data['coupen_discount'];
    $name = $data['coupen_name'];

    $coupenCart = new cart();
    $apply = $coupenCart->coupenCart($discount, $unique, $name);

}

if ($_POST['action'] == 'remove_coupen') {

    $unique = $_SESSION['customer_email'];
    $coupenCart = new cart();
    $apply = $coupenCart->removeCoupenCart($unique);

}

?>