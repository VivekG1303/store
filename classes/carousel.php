<?php

class carousel extends database {

    public function __construct()
	{
		parent::__construct();
	}

    public function insertCarousel($files, $carousel_link)
    {
        // File upload path
        $targetDir = "../upload/carousel_image/";
        $fileName = basename($files["carousel_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        // Removing Extension
        $imageName = basename($fileName, ".".$fileType);
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg');

        if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/store/upload/carousel_image/"  . $fileName)==false){

                    move_uploaded_file($files["carousel_image"]["tmp_name"], $targetFilePath);

                }else{

                    //rename the file if another one exist
                    $new_dir= "$targetDir".$imageName.time().".".$fileType;
                    $fileName = $imageName.time().".".$fileType;
                    move_uploaded_file($files["carousel_image"]["tmp_name"],$new_dir) ;	

                }
        }
        $carousel_image = $fileName;
        // Insert image file name into database
        $sql = "INSERT INTO carousel(carousel_image, carousel_link) VALUES ('".$carousel_image."', '".$carousel_link."')";

        $insert = mysqli_query($this->conn, $sql);

        if ($insert) {
            return true;
        }
    }

    public function updateCarousel($files, $id, $carousel_link, $current_image)
    {
        if (!empty($files['carousel_image']['name'])) {    
            // File upload path
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/store/upload/carousel_image/";
            $fileName = basename($files["carousel_image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('jpg','png','jpeg');

            if(in_array($fileType, $allowTypes)){

                // Upload file to server
                if(move_uploaded_file($files["carousel_image"]["tmp_name"], $targetFilePath)){
                    //delete current image
                    unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/carousel_image/".$current_image);

                    // Insert image file name into database
                    $sql = "UPDATE carousel SET carousel_image='".$fileName."' WHERE carousel_id=".$id;

                    $update = mysqli_query($this->conn, $sql);

                }
            }
        }

        $sql = "UPDATE carousel SET carousel_link='".$carousel_link."' WHERE carousel_id=".$id;

        $update = mysqli_query($this->conn, $sql);

        if ($update) {
            return true;
        }
    }

    public function detailsCarousel($id)
    {
        if(!empty($id)) {

            $sql = "SELECT * FROM carousel WHERE carousel_id=".$id;

            $select = mysqli_query($this->conn, $sql);

            while ($row = mysqli_fetch_assoc($select)) {
                $data = $row;
            }
            return $data;
        
        } else {

            $sql = "SELECT * FROM carousel";

            $select = mysqli_query($this->conn, $sql);

            $data = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function deleteCarousel($id)
    {
        $sql = "SELECT carousel_image FROM carousel WHERE carousel_id=". $id;

        $select = mysqli_query($this->conn, $sql);

        while($row = mysqli_fetch_assoc($select)) {

        unlink($_SERVER['DOCUMENT_ROOT'] . "/store/upload/carousel_image/".$row['carousel_image']);

        }

        $sql = "DELETE FROM carousel WHERE carousel_id=".$id;

        $delete = mysqli_query($this->conn, $sql);

        if ($delete) {
            return true;
        }
    }
}

?>