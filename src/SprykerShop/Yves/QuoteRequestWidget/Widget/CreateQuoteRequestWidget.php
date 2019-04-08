<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Widget;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\PermissionAwareTrait;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\QuoteRequestWidget\QuoteRequestWidgetFactory getFactory()
 */
class CreateQuoteRequestWidget extends AbstractWidget
{
    use PermissionAwareTrait;

    protected const PARAMETER_IS_VISIBLE = 'isVisible';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     */
    public function __construct(QuoteTransfer $quoteTransfer)
    {
        $this->addIsVisibleParameter($quoteTransfer);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'CreateQuoteRequestWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@QuoteRequestWidget/views/quote-request/quote-request-create/quote-request-create.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function addIsVisibleParameter(QuoteTransfer $quoteTransfer): void
    {
        $this->addParameter(static::PARAMETER_IS_VISIBLE, $this->isWidgetVisible($quoteTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isWidgetVisible(QuoteTransfer $quoteTransfer): bool
    {
        $companyUserTransfer = $this->getFactory()
            ->getCompanyUserClient()
            ->findCompanyUser();

        if (!$companyUserTransfer) {
            return false;
        }

        if ($quoteTransfer->getQuoteRequestVersionReference() || $quoteTransfer->getQuoteRequestReference()) {
            return false;
        }

        return $quoteTransfer->getCustomerReference() === $quoteTransfer->getCustomer()->getCustomerReference()
            || $this->can('WriteSharedCartPermissionPlugin', $quoteTransfer->getIdQuote());
    }
}
