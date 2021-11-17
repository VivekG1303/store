<?php

class coupen extends database {

    public function __construct()
	{
		parent::__construct();
	}

    public function insertCoupen($coupen_name, $coupen_discount)
    {
     
        $sql = "INSERT INTO coupen(coupen_name, coupen_discount) VALUES ('".$coupen_name."', '".$coupen_discount."')";

        $insert = mysqli_query($this->conn, $sql);

        if ($insert) {
            return true;
        }
    }

    public function updateCoupen($id, $coupen_name, $coupen_discount)
    {

        $sql = "UPDATE coupen SET coupen_name='".$coupen_name."', coupen_discount='".$coupen_discount."' WHERE coupen_id=".$id;

        $update = mysqli_query($this->conn, $sql);

        if ($update) {
            return true;
        }

    }

    public function deleteCoupen($id)
    {

        $sql = "DELETE FROM coupen WHERE coupen_id=".$id;

        $delete = mysqli_query($this->conn, $sql);

        if ($delete) {
            return true;
        }

    }

    public function detailsCoupen($id, $name)
    {
        if(!empty($id) && $name == 'Name') {
            
            $sql = "SELECT * FROM coupen WHERE coupen_id=".$id;

            $select = mysqli_query($this->conn, $sql);

            while ($row = mysqli_fetch_assoc($select)) {
                $data = $row;
            }
            return $data;

        } elseif(!empty($id)) {

            $sql = "SELECT * FROM coupen WHERE coupen_name='".$id."'";

            $select = mysqli_query($this->conn, $sql);

            while ($row = mysqli_fetch_assoc($select)) {
                $data = $row;
            }
            return $data;

        } else {

            $sql = "SELECT * FROM coupen";

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