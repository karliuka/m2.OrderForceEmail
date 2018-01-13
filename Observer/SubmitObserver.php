<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\OrderForceEmail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;
use Faonni\OrderForceEmail\Helper\Data as OrderEmailHelper;

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
     * Helper
     *
     * @var \Faonni\OrderForceEmail\Helper\Data
     */
    protected $_helper;    
    
    /**
     * Initialize Observer
     *
     * @param OrderSender $orderSender
     * @param LoggerInterface $logger 
     * @param OrderEmailHelper $helper     
     */
    public function __construct(
		OrderSender $orderSender,
		LoggerInterface $logger,
		OrderEmailHelper $helper
	) {
        $this->_orderSender = $orderSender;
        $this->_logger = $logger;
        $this->_helper = $helper;        
    }
    
    /**
     * Send Order Email
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var  \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        if (!$this->_helper->isForce()) {
			/** @var  \Magento\Quote\Model\Quote $quote */
			$quote = $observer->getEvent()->getQuote();
			/**
			* a flag to set that there will be redirect to third party after confirmation
			*/
			$redirectUrl = $quote->getPayment()->getOrderPlaceRedirectUrl();
			if ($redirectUrl || !$order->getCanSendNewEmailFlag()) {
				return;
			}
        }        
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
