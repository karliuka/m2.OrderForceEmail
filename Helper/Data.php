<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\OrderForceEmail\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Order force email helper
 */
class Data extends AbstractHelper
{
    /**
     * Force email config path
     */
    const XML_EMAIL_FORCE = 'sales_email/order/force';

    /**
     * Checks force email functionality should be enabled
     *
     * @param string|null $storeId
     * @return bool
     */
    public function isForce($storeId = null)
    {
        return $this->isSetFlag(self::XML_EMAIL_FORCE, $storeId);
    }

    /**
     * Retrieve config flag
     *
     * @param string $path
     * @param string|null $storeId
     * @return bool
     */
    private function isSetFlag($path, $storeId = null)
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
