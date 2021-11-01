<?php

class database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'Admin@123';
    private $db = 'store';

    protected $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db);

        return $this->conn;
    }

}

class category extends database {

    public function __construct()
	{
		parent::__construct();
	}

    public function checkCategory($category_name)
    {
        $sql = "SELECT category_name FROM category WHERE category_name='".$category_name."'";

        $select = mysqli_query($this->conn, $sql);

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

                    $update = mysqli_query($this->conn, $sql);

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

            $data = array();
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

class product extends database {

    public function __construct()
	{
		parent::__construct();
	}

    public function checkProduct($product_name)
    {
        $sql = "SELECT product_name FROM product WHERE product_name='".$product_name."'";

        $select = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($select) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insertProduct($files, $product_name, $product_category, $product_sku, $product_description, $product_price, $product_quantity, $product_status)
    {
        $filename = array();
        for ($i = 0; $i < count($files['product_image']); $i++) {

        // File upload path
        $imagetargetDir = "../upload/product_image/";
        $imagefileName = basename($files["product_image"]["name"][$i]);
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

                    move_uploaded_file($files["product_image"]["tmp_name"][$i], $imagetargetFilePath);

                }else{

                    //rename the file if another one exist
                    $new_dir= "$imagetargetDir".$imageName.time().".".$imagefileType;
                    $filename[] = $imageName.time().".".$imagefileType;
                    move_uploaded_file($files["product_image"]["tmp_name"][$i],$new_dir) ;	

                }
            }
        }

        $videotargetDir = "../upload/product_video/";
        $videofileName = basename($files["product_video"]["name"]);
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
                move_uploaded_file($files["product_video"]["tmp_name"],$new_dir) ;	
            }
        }
        
        //Create Time
        $created_at = date("d-m-Y");
        //Serializing Image Name array
        $serialized_array = serialize($filename); 

        // Insert image file name into database
        $sql = "INSERT INTO product(product_name, product_category, product_sku, product_description, product_price, product_image, product_video, product_quantity, product_status, created_at) VALUES ('".$product_name."', '".$product_category."', '".$product_sku."',  '".$product_description."',  '".$product_price."', '".$serialized_array."', '".$videofileName."', '".$product_quantity."', '".$product_status."', '".$created_at."')";

        $insert = mysqli_query($this->conn, $sql);

        if($insert) {
            return true;
        }

    }

    public function detailsProduct($id = '')
    {
        if(!empty($id)) {

            $sql = "SELECT * FROM product WHERE product_id=".$id;

            $select = mysqli_query($this->conn, $sql);

            $data = array();
            $image = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $unserialized = unserialize($row['product_image']);
                $image = $unserialized;
                $data = $row;
            }

            return array($image, $data);
        
        } else {

            $sql = "SELECT * FROM product";

            $select = mysqli_query($this->conn, $sql);

            $data = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function updateProduct($files, $id, $product_name, $product_category, $product_sku, $product_description, $product_price, $product_quantity, $product_status, $current_video)
    {
        if(!empty($files['product_image']['name'])) {

            $sql = "SELECT product_image FROM product WHERE product_id=".$id;

            $select = mysqli_query($this->conn, $sql);

            $image = array();

            while($row = mysqli_fetch_assoc($select)) {
                $image = $row['product_image'];
            }

            $image_array = unserialize($image);

            for ($i = 0; $i < count($files['product_image']); $i++) {

                // File upload path
                $imagetargetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/";
                $imagefileName = basename($files["product_image"]["name"][$i]);
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
    
                        move_uploaded_file($files["product_image"]["tmp_name"][$i], $imagetargetFilePath);
                        
                    }else{
    
                        //rename the file if another one exist
                        $new_dir= "$imagetargetDir".$imageName.time().".".$imagefileType;
                        $image_array[] = $imageName.time().".".$imagefileType;
                        move_uploaded_file($files["product_image"]["tmp_name"][$i],$new_dir) ;	
                        
                    }  
                }
            }

            $image_new = serialize($image_array);
            //Create Time
            $updated_at = date("d-m-Y");

            $sql = "UPDATE product SET product_image='".$image_new."', updated_at='".$updated_at."' WHERE product_id=".$id;

            $update = mysqli_query($this->conn, $sql);

        }

        if (!empty($files['product_video']['name'])) {
            
            // File upload path
            $videotargetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/";
            $videofileName = basename($files["product_video"]["name"]);
            $videotargetFilePath = $videotargetDir . $videofileName;
            $videofileType = pathinfo($videotargetFilePath,PATHINFO_EXTENSION);

            $videoallowTypes = array('mp4','3gp','webm');

            if(in_array($videofileType, $videoallowTypes)){

                // Upload file to server
                if(move_uploaded_file($files["product_video"]["tmp_name"], $videotargetFilePath)){

                    unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/".$current_video);
                    //Create Time
                    $updated_at = date("d-m-Y");

                    $sql = "UPDATE product SET product_video='".$videofileName."', updated_at='".$updated_at."' WHERE product_id=".$id;

                    $update = mysqli_query($this->conn, $sql);

                }
            }
        }

        //Create Time
        $updated_at = date("d-m-Y");

        $sql = "UPDATE product SET product_name='".$product_name."', product_category='".$product_category."', product_sku='".$product_sku."', product_description='".$product_description."', product_price='".$product_price."', product_quantity='".$product_quantity."', product_status='".$product_status."', updated_at='".$updated_at."' WHERE product_id=".$id;

        $update = mysqli_query($this->conn, $sql);

        if($update) {
            return true;
        }
    }

    public function imageDeleteProduct($id, $current_image)
    {
        $sql = "SELECT product_image FROM product WHERE product_id=". $id;

        $select = mysqli_query($this->conn, $sql);

        $image = array();

        while($row = mysqli_fetch_assoc($select)) {
            $image = $row['product_image'];
        }

        $image_array = unserialize($image);

        if (!empty($image)) {

            unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/".$current_image);

            if (($key = array_search($_POST['image'], $image_array)) !== false) {
                unset($image_array[$key]);
            }

        }
        $image_array = array_values($image_array);
        $image_new = serialize($image_array);
        //Create Time
        $updated_at = date("d-m-Y");

        $sql = "UPDATE product SET product_image='".$image_new."', updated_at='".$updated_at."' WHERE product_id=".$id;

        $delete = mysqli_query($this->conn, $sql);

        if($delete) {
            return true;
        }

    }

}


?>