<?php

namespace MK\Module\Service;

use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote;

class MultiSourceService
{
    /**
     * @param Quote $quote
     * @return bool
     */
    public function isMultiSource(CartInterface $quote): bool
    {
        return true;
    }
}
