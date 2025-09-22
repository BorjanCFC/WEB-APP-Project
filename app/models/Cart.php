<?php
class Cart
{
    public function __construct()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function getItems()
    {
        return $_SESSION['cart'];
    }

    public function addItem($item)
    {
        $id = $item['id'];

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $item['name'],
                'price' => $item['price'],
                'image' => $item['image'],
                'quantity' => 1
            ];
        }
    }

    public function updateQuantity($id, $quantity)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = max(1, intval($quantity));
        }
    }

    public function removeItem($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
