<?php

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

    public function deleteProduct($id){

        $sql = "SELECT product_image, product_video FROM product WHERE product_id=". $id;

        $select = mysqli_query($this->conn, $sql);

        while($row = mysqli_fetch_assoc($select)) {

            $image = $row['product_image'];
            $video = $row['product_video'];

        }

        $image_array = unserialize($image);

        for($i=0; $i<count($image_array); $i++) {

            unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_image/".$image_array[$i]);

        }

        unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/product_video/".$video);

        $sql = "DELETE FROM product WHERE product_id=".$id;

        $delete = mysqli_query($this->conn, $sql);

        if($delete) {
            return true;
        }

    }

    public function categoryProduct($id)
    {

        $sql = "SELECT * FROM product WHERE product_category LIKE '%". $id ." %' OR product_category LIKE '%". $id ."'";

        $select = mysqli_query($this->conn, $sql);

        $data = array();
        while ($row = mysqli_fetch_assoc($select)) {
            $data[] = $row;
        }
       
        return $data;
        
    }

    public function singleProduct($id)
    {
        $sql = "SELECT * FROM product WHERE product_id=".$id;

        $select = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($select)) {
            $data = $row;
        }
       if(isset($data)) {
            return $data;
        }
    }

    public function quantityCheckProduct($id, $value)
    {
        $sql = "SELECT product_quantity FROM product WHERE product_id=".$id;

        $select = mysqli_query($this->conn, $sql);

        $row = mysqli_fetch_assoc($select);

        if($value<=$row['product_quantity']) {
            return 4;
        } else {
            return 5;
        }
    }

    public function searchProduct($name)
    {
        $sql = "SELECT product_id FROM product WHERE product_name='".$name."'";

        $select = mysqli_query($this->conn, $sql);

        $row = mysqli_fetch_assoc($select);
        $pid = '';
        if(isset($row['product_id'])){
        $pid = $row['product_id'];
        }
        $sql1 = "SELECT category_id FROM category WHERE category_name='".$name."'";

        $select1 = mysqli_query($this->conn, $sql1);

        $row1 = mysqli_fetch_assoc($select1);
        $cid = '';
        if(isset($row1['category_id'])){
        $cid = $row1['category_id'];
        }
        $data = array('pid'=>$pid, 'cid'=>$cid);

        return $data;

    }

    public function countProduct($id)
    {
        $sql = "SELECT * FROM product WHERE product_category LIKE '%". $id ." %' OR product_category LIKE '%". $id ."'";

        $select = mysqli_query($this->conn, $sql);

        $row = mysqli_num_rows($select);
        $limit = 20;
        $number = ceil($row/$limit);

        return $number;
    }

    public function pageProduct($id, $page, $order)
    {
        if($order == '') {
            $limit=20;
            if($page == 1) {
                $number = 0;
            } else {
                $number = $limit*($page-1);
            }
            $sql = "SELECT * FROM product WHERE product_category LIKE '%". $id ." %' OR product_category LIKE '%". $id ."'  LIMIT ". $number .",". $limit;
    
            $select = mysqli_query($this->conn, $sql);
    
            $data = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $data[] = $row;
            }
           
            return $data;
        } elseif($order == 'NAME_ASC' || $order == 'NAME_DESC') {

            $limit=20;
            if($page == 1) {
                $number = 0;
            } else {
                $number = $limit*($page-1);
            }

            if($order == 'NAME_ASC' ) {
                $sql = "SELECT * FROM product WHERE product_category LIKE '%". $id ." %' OR product_category LIKE '%". $id ."' ORDER BY product_name ASC LIMIT ". $number .",". $limit;
            } else {
                $sql = "SELECT * FROM product WHERE product_category LIKE '%". $id ." %' OR product_category LIKE '%". $id ."' ORDER BY product_name DESC LIMIT ". $number .",". $limit;
            }
    
            $select = mysqli_query($this->conn, $sql);
    
            $data = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $data[] = $row;
            }
           
            return $data;

        } else {

            $limit=20;
            if($page == 1) {
                $number = 0;
            } else {
                $number = $limit*($page-1);
            }
            $sql = "SELECT * FROM product WHERE product_category LIKE '%". $id ." %' OR product_category LIKE '%". $id ."' ORDER BY product_price ".$order." LIMIT ". $number .",". $limit;
    
            $select = mysqli_query($this->conn, $sql);
    
            $data = array();
            if(!empty($select)) {
                while ($row = mysqli_fetch_assoc($select)) {
                    $data[] = $row;
                }
            }
           
            return $data;

        }

    }

}
?>