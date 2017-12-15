<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\OrderForceEmail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

/**
 * Submit Observer
 */
class SubmitObserver implements ObserverInterface
{
    /**
     * Order Sender
     *
     * @var \Magento\Sales\Model\Order\Email\Sender\OrderSender
     */
    protected $_orderSender;
    
    /**
     * Logger
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;    
    
    /**
     * Initialize Observer
     *
     * @param OrderSender $orderSender
     * @param LoggerInterface $logger     
     */
    public function __construct(
		OrderSender $orderSender,
		LoggerInterface $logger 
	) {
        $this->_orderSender = $orderSender;
        $this->_logger = $logger;        
    }
    
    /**
     * Add Location Meta Tag
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var  \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        $order->setCanSendNewEmailFlag(false);
        
        $this->send($order);
    }
    
    /**
     * Send Order Confirmation Email To The Customer
     *
     * @param Order $order
     * @return void
     */
    public function send(Order $order)
    {
		try {
			$this->_orderSender->send($order);
		} catch (\Exception $e) {
			$this->_logger->critical($e);
		}
    }    
}  
