<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\OrderForceEmail\Observer;

use Psr\Log\LoggerInterface;
use Magento\Sales\Model\Order;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Faonni\OrderForceEmail\Helper\Data as Helper;

/**
 * Submit Observer
 */
class SubmitObserver implements ObserverInterface
{
    /**
     * @var OrderSender
     */
    private $sender;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * Initialize Observer
     *
     * @param OrderSender $orderSender
     * @param LoggerInterface $logger
     * @param Helper $helper
     */
    public function __construct(
        OrderSender $orderSender,
        LoggerInterface $logger,
        Helper $helper
    ) {
        $this->sender = $orderSender;
        $this->logger = $logger;
        $this->helper = $helper;
    }

    /**
     * Send order email
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getData('order');
        if (!$this->helper->isForce()) {
            /** @var \Magento\Quote\Model\Quote $quote */
            $quote = $observer->getEvent()->getData('quote');
            /** a flag to set that there will be redirect to third party after confirmation */
            $redirectUrl = $quote->getPayment()->getOrderPlaceRedirectUrl();
            if ($redirectUrl || !$order->getCanSendNewEmailFlag()) {
                return;
            }
        }
        $order->setCanSendNewEmailFlag(false);
        $this->send($order);
    }

    /**
     * Send order confirmation email to the customer
     *
     * @param Order $order
     * @return void
     */
    private function send(Order $order)
    {
        try {
            $this->sender->send($order);
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }
}
