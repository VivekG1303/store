<?php

//coupen Section
if ($_POST['action'] == 'coupen_register') {

    if ($_POST['coupen_name'] !== '' && $_POST['coupen_discount'] !== '') {

        $coupen_name = $_POST['coupen_name'];
        $coupen_discount = $_POST['coupen_discount'];

        $coupen = new coupen();
        $insert = $coupen->insertCoupen($coupen_name, $coupen_discount);
        if ($insert) {
        $message = "New coupen Added";
        }

    }
}

if ($_POST['action'] == 'coupen_details') {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $coupen = new coupen();
        $data = $coupen->detailsCoupen($id);

        echo json_encode($data);

    }
}

if ($_POST['action'] == 'coupen_update') {

    if (!empty($_POST['id'])) {
        $files = $_FILES;
        $id = $_POST['id'];
        $coupen_name = $_POST['coupen_name'];
        $coupen_discount = $_POST['coupen_discount'];
            
        $coupen = new coupen();
        $update = $coupen->updateCoupen($id, $coupen_name, $coupen_discount);

        if ($update) {
            echo 1;
        }

    }
}

if ($_POST['action'] == 'coupen_delete') {

    if (!empty($_POST['id'])) {

        $id = $_POST['id'];

        $coupen = new coupen();
        $delete = $coupen->deleteCoupen($id);

        if ($delete) {
            echo 1;
        }
    }
}


?>