<?php

namespace app\controller;

use app\entity\Order;
use App\Factory\OrderFactory;
use App\Repository\OrderRepository;
use App\Service\BillGenerator;
use App\Service\BillMicroserviceClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController
{
    /** @var OrderFactory */
    protected OrderFactory $orderFactory;

    /** @var OrderRepository */
    protected OrderRepository $orderRepository;

    public function __construct(OrderFactory $orderFactory, OrderRepository $orderRepository)
    {
        $this->orderFactory = $orderFactory;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $orderData = json_decode($request->getContent(), true);
        $orderId = $this->orderFactory->generateOrderId();

        try {
            $order = $this->orderFactory->createOrder($orderData, $orderId);
            $this->orderRepository->save($order);

            if ($order->contractorType === Order::CONTRACTOR_TYPE_PERSON) {
                return new RedirectResponse($order->getPayUrl());
            }

            if ($order->contractorType === Order::CONTRACTOR_TYPE_LEGAL) {
                $order->setBillGenerator(new BillGenerator());
                return new RedirectResponse($order->getBillUrl());
            }
        } catch (\Exception $exception) {
            return new Response("Something went wrong");
        }
    }

    /**
     * @Route("/finish/{orderId}", methods={"GET"})
     */
    public function finish($orderId)
    {
        $order = $this->orderRepository->get($orderId);
        if ($order->contractorType == Order::CONTRACTOR_TYPE_LEGAL) {
            $order->setBillClient(new BillMicroserviceClient());
        }
        if ($order->isPaid()) {
            return new Response("Thank you");
        } else {
            return new Response("You haven't paid bill yet");
        }
    }

    /**
     * @Route("/last", methods={"GET"})
     */
    public function last(Request $request)
    {
        $limit = $request->get("limit");
        $orders = $this->orderRepository->last($limit);
        return new JsonResponse($orders);
    }
}