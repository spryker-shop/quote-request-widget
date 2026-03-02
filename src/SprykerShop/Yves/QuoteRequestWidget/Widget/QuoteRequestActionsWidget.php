<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Widget;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\QuoteRequestWidget\QuoteRequestWidgetFactory getFactory()
 */
class QuoteRequestActionsWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_IS_VISIBLE = 'isVisible';

    /**
     * @var string
     */
    protected const PARAMETER_BACK_URL = 'backUrl';

    public function __construct(QuoteTransfer $quoteTransfer, string $backUrl)
    {
        $this->addIsVisibleParameter($quoteTransfer);
        $this->addBackUrlParameter($backUrl);
    }

    public static function getName(): string
    {
        return 'QuoteRequestActionsWidget';
    }

    public static function getTemplate(): string
    {
        return '@QuoteRequestWidget/views/quote-request-checkout/quote-request-checkout.twig';
    }

    protected function addIsVisibleParameter(QuoteTransfer $quoteTransfer): void
    {
        $this->addParameter(
            static::PARAMETER_IS_VISIBLE,
            $this->getFactory()->getQuoteRequestClient()->isEditableQuoteRequestVersion($quoteTransfer),
        );
    }

    protected function addBackUrlParameter(string $backUrl): void
    {
        $this->addParameter(static::PARAMETER_BACK_URL, $backUrl);
    }
}
