<?php

class category extends database {

    public function __construct()
	{
		parent::__construct();
	}

    public function checkCategory($category_name)
    {
        $sql = "SELECT category_name FROM category WHERE category_name='".$category_name."'";

        $select = mysqli_query($this->getConnection(), $sql);

        if (mysqli_num_rows($select) > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function insertCategory($files, $category_name, $category_description, $created_at)
    {
        // File upload path
        $targetDir = "../upload/category_image/";
        $fileName = basename($files["category_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        // Removing Extension
        $imageName = basename($fileName, ".".$fileType);
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg');

        if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/"  . $fileName)==false){

                    move_uploaded_file($files["category_image"]["tmp_name"], $targetFilePath);

                }else{

                    //rename the file if another one exist
                    $new_dir= "$targetDir".$imageName.time().".".$fileType;
                    $fileName = $imageName.time().".".$fileType;
                    move_uploaded_file($files["category_image"]["tmp_name"],$new_dir) ;	

                }
        }
        $category_image = $fileName;
        // Insert image file name into database
        $sql = "INSERT INTO category(category_name, category_image, category_description, created_at) VALUES ('".$category_name."', '".$category_image."', '".$category_description."', '".$created_at."')";

        $insert = mysqli_query($this->conn, $sql);

        if ($insert) {
            return true;
        }
    }

    public function updateCategory($files, $id, $category_name, $category_description, $current_image)
    {
        if (!empty($files['category_image_update']['name'])) {    
            // File upload path
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/";
            $fileName = basename($files["category_image_update"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg');

            if(in_array($fileType, $allowTypes)){

                // Upload file to server
                if(move_uploaded_file($files["category_image_update"]["tmp_name"], $targetFilePath)){
                    //delete current image
                    unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/".$current_image);
                    //Create Time
                    $updated_at = date("d-m-Y");

                    // Insert image file name into database
                    $sql = "UPDATE category SET category_image='".$fileName."', updated_at='".$updated_at."' WHERE category_id=".$_POST['id'];

                    $update = mysqli_query($this->getConnection(), $sql);

                }
            }
        }

        //Create Time
        $updated_at = date("d-m-Y");

        $sql = "UPDATE category SET category_name='".$category_name."', category_description='".$category_description."', updated_at='".$updated_at."' WHERE category_id=".$id;

        $update = mysqli_query($this->conn, $sql);

        if ($update) {
            return true;
        }

    }

    public function deleteCategory($id)
    {
        $sql = "SELECT category_image FROM category WHERE category_id=". $id;

        $select = mysqli_query($this->conn, $sql);

        while($row = mysqli_fetch_assoc($select)) {

        unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/category_image/".$row['category_image']);

        }

        $sql = "DELETE FROM category WHERE category_id=".$id;

        $delete = mysqli_query($this->conn, $sql);

        if ($delete) {
            return true;
        }

    }

    public function detailsCategory($id = '')
    {
        if(!empty($id)) {

            $sql = "SELECT * FROM category WHERE category_id=".$id;

            $select = mysqli_query($this->conn, $sql);

            while ($row = mysqli_fetch_assoc($select)) {
                $data = $row;
            }
            return $data;

        } else {

            $sql = "SELECT * FROM category";

            $select = mysqli_query($this->conn, $sql);

            $data = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $data[] = $row;
            }
            return $data;

        }
    }

}

?>