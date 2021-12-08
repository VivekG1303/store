<?php

class cart {

    public function addToCart($id, $value, $unique)
    {
        if(isset($_SESSION['customer_firstname'])) {
            if(!isset($_SESSION['cart'][$unique][$id])) {
                $_SESSION['cart'][$unique][$id] = array('id'=>$id, 'qty'=>$value);
            } else {
                $value1 = $_SESSION['cart'][$unique][$id]['qty'] + $value;
                $_SESSION['cart'][$unique][$id] = array('id'=>$id, 'qty'=>$value1);
            }
        }
    }

    public function deleteCartItem($id, $unique)
    {
        unset($_SESSION['cart'][$unique][$id]);
    }

    public function updateCartItem($id, $value, $unique)
    {
        $_SESSION['cart'][$unique][$id] = array('id'=>$id, 'qty'=>$value);
    }

    public function clearCart($unique)
    {
        unset($_SESSION['coupen']);
        unset($_SESSION['cart'][$unique]);
    }

    public function coupenCart($discount, $unique, $name)
    {
        $_SESSION['coupen'][$unique] = array('discount'=>$discount, 'name'=>$name);;
    }

    public function removeCoupenCart($unique)
    {
        unset($_SESSION['coupen']);
    }

}

?>