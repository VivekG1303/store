<?php
//Category Section
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

?>