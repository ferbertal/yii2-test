<?php

namespace app\factory;

use app\entity\Item;
use app\entity\Order;

class OrderFactory
{
    /** @var \PDO */
    protected \PDO $pdo;

    /**
     * OrderFactory constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return string
     */
    public function generateOrderId(): string
    {
        $sql = "SELECT id FROM order ORDER BY created_at DESC LIMIT 1";
        $result = $this->pdo->query($sql)->fetch();
        return (new \DateTime())->format("Y-m") . "-" . $result['id'] + 1;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Order
     */
    public function createOrder(array $data, int $id): Order
    {
        $order = new Order($id);
        foreach ($data as $key => $value) {
            if ($key == 'items') {
                foreach ($value as $itemValue) {
                    $order->items[] = new Item($id, $itemValue['productId'], $itemValue['price'],
                        $itemValue['quantity']);
                }
                continue;
            }
            $order->{$key} = $value;
        }
        return $order;
    }
}
