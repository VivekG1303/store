<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include_once 'classes/inc/autoload.php';
session_start();
if(isset($_POST['action'])) {
    $action_id = $_POST['action'];
} else {
    $action_id = '';
}

class action {

    public function getAction($action_id)
    {
        switch ($action_id) {
            case "category_register":
                return $this->insertCategoryDetails();
                break;
            case "category_details":
                return $this->getCategoryDetails();
                break;
            case "category_update":
                return $this->updateCategoryDetails();
                break;
            case "category_delete":
                return $this->deleteCategoryDetails();
                break;
            case "product_register":
                return $this->insertProductDetails();
                break;
            case "product_details":
                return $this->getProductDetails();
                break;
            case "single_image_delete":
                return $this->deleteSingleProductImage();
                break;
            case "product_update":
                return $this->updateProductDetails();
                break;
            case "product_delete":
                return $this->deleteProductDetails();
                break;
            case "product_search":
                return $this->searchProductDetails();
                break;
            case "product_quantity_check":
                return $this->quantityProductDetails();
                break;
            case "product_quantity_check2":
                return $this->quantityProductDetails2();
                break;
            case "add_to_cart":
                return $this->addCartDetails();
                break;
            case "delete_from_cart":
                return $this->deleteCartDetails();
                break;
            case "update_cart_item":
                return $this->updateCartDetails();
                break;
            case "clear_cart":
                return $this->clearCartDetails();
                break;
            case "apply_coupen":
                return $this->applyCoupenDetails();
                break;
            case "remove_coupen":
                return $this->removeCoupenDetails();
                break;
            case "coupen_register":
                return $this->insertCoupenDetails();
                break;
            case "coupen_details":
                return $this->getCoupenDetails();
                break;
            case "coupen_update":
                return $this->updateCoupenDetails();
                break;
            case "coupen_delete":
                return $this->deleteCoupenDetails();
                break;
            case "carousel_register":
                return $this->insertCarouselDetails();
                break;
            case "carousel_details":
                return $this->getCarouselDetails();
                break;
            case "carousel_update":
                return $this->updateCarouselDetails();
                break;
            case "carousel_delete":
                return $this->deleteCarouselDetails();
                break;
            case "customer_register":
                return $this->insertCustomerDetails();
                break;
            case "customer_details":
                return $this->getCustomerDetails();
                break;
            case "customer_update":
                return $this->updateCustomerDetails();
                break;
            case "customer_delete":
                return $this->deleteCustomerDetails();
                break;
            case "customer_signin":
                return $this->signinCustomerDetails();
                break;
            case "admin_login":
                return $this->signinAdminDetails();
                break;
            case "customer_delete":
                return $this->deleteCustomerDetails();
                break;
            default:
                break;
        }
    }

    public function insertCategoryDetails()
    {
        if ($_POST['category_name'] !== ''&&  $_FILES['category_image']['name'] !== '' && $_POST['category_description'] !== '') {
            $category_name = $_POST['category_name'];
            $category = new category();
            $check = $category->checkCategory($category_name);
            if ($check) {
                $message = 'Category already added!';
                return $message;
            } else {            
                $files = $_FILES;
                $category_name = $_POST['category_name'];
                $category_description = $_POST['category_description'];
                $created_at = date("d-m-Y");

                $insert = $category->insertCategory($files, $category_name, $category_description, $created_at);
                if ($insert) {
                $success = "New Category Added";
                return $success;
                }
            }
        }
    }

    public function getCategoryDetails()
    {
        $id = $_POST['id'];

        $category = new category();
        $data = $category->detailsCategory($id);

        echo json_encode($data);
    }

    public function updateCategoryDetails()
    {
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

    public function deleteCategoryDetails()
    {
        $id = $_POST['id'];

        $category = new category();
        $delete = $category->deleteCategory($id);

        if ($delete) {
            echo 1;
        }
    }

    public function insertProductDetails()
    {
        if ($_POST['product_name'] !== '' && $_POST['product_category'] !== '' && $_POST['product_sku'] !== ''  && $_POST['product_description'] !== ''  && $_POST['product_price'] !== '' &&  $_FILES['product_image']['name'] !== ''  &&  $_FILES['product_video']['name'] !== '' && $_POST['product_quantity'] !== '' && $_POST['product_status'] !== '') {   
            $product_name = $_POST['product_name'];   
            $product = new product();
            $check = $product->checkProduct($product_name);
            if ($check) {
                $message = 'Product already added!';
                return $message;
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
                    $success = "New Product Added";
                    return $success;
                }
            }
        }
    }

    public function getProductDetails()
    {
        $id = $_POST['id'];

        $product = new product();

        list($image, $data) = $product->detailsProduct($id);
        
        echo json_encode(array("image" => $image, "detail" => $data));
    }

    public function deleteSingleProductImage()
    {
        $id = $_POST['id'];
        $image = $_POST['image'];

        $product = new product();
        $delete = $product->imageDeleteProduct($id, $image);

        if ($delete) {
            echo 1;
        }
    }

    public function updateProductDetails()
    {
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

    public function deleteProductDetails()
    {
        $id = $_POST['id'];

        $product = new product();
        $delete = $product->deleteProduct($id);

        if ($delete) {
            echo 1;
        }
    }

    public function searchProductDetails()
    {
        $name = $_POST['name'];

        $search = new product();
        $data = $search->searchProduct($name);

        echo json_encode($data);
    }

    public function quantityProductDetails()
    {
        $id = $_POST['id'];
        $value = $_POST['value'];

        if(isset($_SESSION['cart'][$_SESSION['customer_email']][$id])){
            $value += $_SESSION['cart'][$_SESSION['customer_email']][$id]['qty'];
        }

        $check = new product();
        $data = $check->quantityCheckProduct($id, $value);

        if($data) {
            echo $data;
        }
    }

    public function quantityProductDetails2()
    {
        $id = $_POST['id'];
        $value = $_POST['value'];

        $check = new product();
        $data = $check->quantityCheckProduct($id, $value);

        if($data) {
            echo $data;
        }
    }

    public function addCartDetails()
    {
        $id = $_POST['id'];
        $value = $_POST['value'];
        $unique = $_SESSION['customer_email'];
        
        $addToCart = new cart();
        $add = $addToCart->addToCart($id, $value, $unique);

        if ($add) {
            echo 1;
        }
    }

    public function deleteCartDetails()
    {
        $id = $_POST['id'];
        $unique = $_SESSION['customer_email'];

        $deleteFromCart = new cart();
        $add = $deleteFromCart->deleteCartItem($id, $unique);
    }

    public function updateCartDetails()
    {
        $id = $_POST['id'];
        $value = $_POST['value'];
        $unique = $_SESSION['customer_email'];

        $updateCartItem = new cart();
        $add = $updateCartItem->updateCartItem($id, $value, $unique);
    }

    public function clearCartDetails()
    {
        $unique = $_SESSION['customer_email'];

        $clearCart = new cart();
        $clear = $clearCart->clearCart($unique);

        echo 1;
    }

    public function applyCoupenDetails()
    {
        $id = $_POST['id'];
        $name = 'Try';

        $coupen = new coupen();
        $data = $coupen->detailsCoupen($id, $name);
        if(!empty($data['coupen_name'])) {

            $unique = $_SESSION['customer_email'];
            $discount = $data['coupen_discount'];
            $name = $data['coupen_name'];

            $coupenCart = new cart();
            $apply = $coupenCart->coupenCart($discount, $unique, $name);
         
            echo 1;
        } else {
            echo 2;
        }
        
    }

    public function removeCoupenDetails()
    {
        $unique = $_SESSION['customer_email'];
        $coupenCart = new cart();
        $apply = $coupenCart->removeCoupenCart($unique);
    }

    public function insertCoupenDetails()
    {
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

    public function getCoupenDetails()
    {
        $id = $_POST['id'];
        $name = 'Name';

        $coupen = new coupen();
        $data = $coupen->detailsCoupen($id, $name);

        echo json_encode($data);
    }

    public function updateCoupenDetails()
    {
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

    public function deleteCoupenDetails()
    {
        $id = $_POST['id'];

        $coupen = new coupen();
        $delete = $coupen->deleteCoupen($id);

        if ($delete) {
            echo 1;
        }
    }

    public function insertCarouselDetails()
    {
        if (!empty($_POST['carousel_link'])) {  
            $files = $_FILES;
            $carousel_link = $_POST['carousel_link'];    
            $carousel = new carousel();
            $insert = $carousel->insertCarousel($files, $carousel_link);   
        }
    }

    public function getCarouselDetails()
    {
        $id = $_POST['id'];

        $carousel = new carousel();
        $data = $carousel->detailsCarousel($id);

        echo json_encode($data);
    }

    public function updateCarouselDetails()
    {
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

    public function deleteCarouselDetails()
    {
        $id = $_POST['id'];

        $carousel = new carousel();
        $delete = $carousel->deleteCarousel($id);

        if ($delete) {
            echo 1;
        }
    }

    public function insertCustomerDetails()
    {
        if ($_POST['customer_firstname'] !== '' && $_POST['customer_lastname'] !== '' && $_POST['customer_email'] !== ''  && $_POST['customer_mobilenumber'] !== ''  && $_POST['customer_address'] !== ''  && $_POST['customer_password'] !== '') {      
            $post = $_POST;
            $customer = new login();
            $signup = $customer->signUpLogin($post);
            $message = $signup;
        }
    }

    public function getCustomerDetails()
    {
        $id = $_POST['id'];

        $customer = new login();
        $data = $customer->detailsCustomer($id);

        echo json_encode($data);
    }

    public function updateCustomerDetails()
    {
         $id = $_POST['id'];
        $customer_firstname = $_POST['customer_firstname'];
        $customer_lastname = $_POST['customer_lastname'];
        $customer_email = $_POST['customer_email'];
        $customer_mobilenumber = $_POST['customer_mobilenumber'];
        $customer_address = $_POST['customer_address'];
            
        $customer = new login();
        $update = $customer->updateCustomer($id, $customer_firstname, $customer_lastname, $customer_email, $customer_mobilenumber, $customer_address);

        if ($update) {
            echo 1;
        }
    }

    public function deleteCustomerDetails()
    {
        $id = $_POST['id'];

        $customer = new login();
        $delete = $customer->deleteCustomer($id);

        if ($delete) {
            echo 1;
        }
    }

    public function signinCustomerDetails()
    {
        if (!empty($_POST['customer_email'])) {    
            $post = $_POST;
            $customer = new login();
            $login = $customer->customerlogin($post);
        }
    }

    public function signinAdminDetails()
    {
        if ($_POST['userid'] !== '' && $_POST['password'] !== '') {
            $id = $_POST['userid'];
            $password = $_POST['password'];
            $admin = new login();
            $login = $admin->adminLogin($id, $password);
            $message = $login;
        } else {
            $message = 'Please enter the valid details';
        }
    }

}

$action = new action();
$message = $action->getAction($action_id);


?>