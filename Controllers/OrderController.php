<?php

require_once "../config/autoload.php";

class OrderController extends Order
{
    public function getOrdersController()
    {
        return $this->getOrders();
    }

    public function deleteOrdersController($orderIds)
    {
        
        return $this->deleteOrders($orderIds);
    }

    public function editOrderController($orderId, $address, $paymentMethod, $orderStatus)
    {
       
        return $this->editOrder($orderId, $address, $paymentMethod, $orderStatus);
    }

    public function addOrderController($orderData)
    {
        ;
        return $this->addOrder($orderData);
    }

    public function getOrderByOrderIdController($orderId)
    {
       
        return $this->getOrderByOrderId($orderId);
    }

    public function createOrderController($userId, $address, $paymentMethod, $orderStatus)
    {
        
        return $this->createOrder($userId, $address, $paymentMethod, $orderStatus);
    }
}
?>