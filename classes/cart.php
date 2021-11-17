<?php

class cart {

    public function addToCart($id, $value, $unique)
    {
        if(isset($_SESSION['customer_firstname'])) {
            if(!array_key_exists($id, $_SESSION['cart'])) {
                $_SESSION['cart'][$unique][$id] = array('id'=>$id, 'qty'=>$value);
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