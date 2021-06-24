<?php

namespace MK\Module\Validator;

use Magento\Framework\Exception\ValidatorException;
use Magento\Quote\Api\Data\CartInterface;

class MultisourceValidator
{
    /** @var MultiSourceService */
    private $multisourceService;

    /**
     * MultisourceValidator constructor.
     * @param MultiSourceService $multisourceService
     */
    public function __construct(MultiSourceService $multisourceService)
    {
        $this->multisourceService = $multisourceService;
    }

    public function validate(CartInterface $quote): void
    {
        if ($this->multisourceService->isMultisource($quote)) {
            throw new ValidatorException(
                __('Cart has multisource items')
            );
        }
    }
}
