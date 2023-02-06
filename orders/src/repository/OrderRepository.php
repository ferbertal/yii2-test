<?php

namespace app\repository;

use app\entity\Item;
use app\entity\Order;

class OrderRepository
{
    /** @var \PDO */
    protected $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param Order $order
     * @return void
     */
    public function save(Order $order): void
    {
        $sql
            = "INSERT INTO order (id, sum, contractor_type) VALUES ({$order->id}, {$order->sum}, {$order->contractorType})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        foreach ($order->items as $item) {
            $sql = "INSERT 
                INTO orders_products (order_id,product_id,price,quantity) 
                VALUES ({$order->id},{$item->getProductId()},{$item->getPrice()}, {$item->getQuantity()})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
    }

    /** @return Order */
    public function get($orderId)
    {
        $sql = "SELECT * FROM order WHERE id={$orderId} LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $data = $stmt->fetch();

        $order = new Order($data['id']);
        $order->contractorType = $data['contractor_type'];
        $order->isPaid = $data['is_paid'];
        $order->sum = $data['sum'];
        $order->items = $this->getOrderItems($data['id']);

        return $order;
    }

    /** @return Order[] */
    public function last($limit = 10): array
    {
        $sql = "SELECT * FROM order ORDER BY created_at DESC LIMIT {$limit}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $orders = [];
        foreach ($data as $item) {
            $order = new Order($item['id']);
            $order->contractorType = $item['contractor_type'];
            $order->isPaid = $item['is_paid'];
            $order->sum = $item['sum'];
            $order->items = $this->getOrderItems($item['id']);
            $orders[] = $order;
        }
        return $orders;
    }

    /**
     * @param $orderId
     * @return array
     */
    public function getOrderItems($orderId): array
    {
        $sql = "SELECT * FROM orders_products WHERE order_id={$orderId}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $items = [];
        foreach ($data as $item) {
            $items[] = new Item($item['order_id'], $item['product_id'], $item['price'], $item['quantity']);
        }
        return $items;
    }
}
