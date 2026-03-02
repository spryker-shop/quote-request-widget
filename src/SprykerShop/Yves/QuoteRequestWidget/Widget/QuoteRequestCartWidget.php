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
class QuoteRequestCartWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_IS_VISIBLE = 'isVisible';

    /**
     * @var string
     */
    protected const PARAMETER_FORM = 'form';

    public function __construct(QuoteTransfer $quoteTransfer)
    {
        $this->addIsVisibleParameter($quoteTransfer);
        $this->addFormParameter();
    }

    public static function getName(): string
    {
        return 'QuoteRequestCartWidget';
    }

    public static function getTemplate(): string
    {
        return '@QuoteRequestWidget/views/quote-request-update/quote-request-update.twig';
    }

    protected function addIsVisibleParameter(QuoteTransfer $quoteTransfer): void
    {
        $this->addParameter(static::PARAMETER_IS_VISIBLE, $this->isWidgetVisible($quoteTransfer));
    }

    protected function addFormParameter(): void
    {
        $this->addParameter(static::PARAMETER_FORM, $this->getFactory()->getQuoteRequestCartForm()->createView());
    }

    protected function isWidgetVisible(QuoteTransfer $quoteTransfer): bool
    {
        return $this->getFactory()->getQuoteRequestClient()->isEditableQuoteRequestVersion($quoteTransfer);
    }
}
