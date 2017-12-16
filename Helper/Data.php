<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\OrderForceEmail\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * OrderForceEmail Helper
 */
class Data extends AbstractHelper 
{
    /**
     * Force Email Config Path
     */	
    const XML_CONFIG_EMAIL_FORCE = 'sales_email/order/force';
    
    /**
     * Checks Force Email Functionality Should be Enabled
     *
     * @param int|Store $store     
     * @return string|null
     */
    public function isForce($store = null)
    {
        return $this->_getConfig(self::XML_CONFIG_EMAIL_FORCE, $store);
    }
    
    /**
     * Retrieve Store Configuration Data
     *
     * @param string $path
     * @param int|Store $store	 
     * @return string|null
     */
    protected function _getConfig($path, $store = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $store);
    }
}
