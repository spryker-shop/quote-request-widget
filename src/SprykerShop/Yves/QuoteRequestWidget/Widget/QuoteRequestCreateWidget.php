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
class QuoteRequestCreateWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_IS_VISIBLE = 'isVisible';

    public function __construct(QuoteTransfer $quoteTransfer)
    {
        $this->addIsVisibleParameter($quoteTransfer);
    }

    public static function getName(): string
    {
        return 'QuoteRequestCreateWidget';
    }

    public static function getTemplate(): string
    {
        return '@QuoteRequestWidget/views/quote-request-create/quote-request-create.twig';
    }

    protected function addIsVisibleParameter(QuoteTransfer $quoteTransfer): void
    {
        $isVisible = $this->getFactory()
            ->getQuoteRequestClient()
            ->isQuoteApplicableForQuoteRequest($quoteTransfer);

        $this->addParameter(static::PARAMETER_IS_VISIBLE, $isVisible);
    }
}
