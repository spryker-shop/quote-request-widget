<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Widget;

use Spryker\Yves\Kernel\Widget\AbstractWidget;

/**
 * @method \SprykerShop\Yves\QuoteRequestWidget\QuoteRequestWidgetFactory getFactory()
 */
class QuoteRequestMenuItemWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_IS_VISIBLE = 'isVisible';

    /**
     * @var string
     */
    protected const PARAMETER_IS_ACTIVE_PAGE = 'isActivePage';

    /**
     * @var string
     */
    protected const PAGE_KEY_QUOTE_REQUEST = 'quoteRequest';

    public function __construct(string $activePage)
    {
        $this->addIsVisibleParameter();
        $this->addIsActivePageParameter($activePage);
    }

    public static function getName(): string
    {
        return 'QuoteRequestMenuItemWidget';
    }

    public static function getTemplate(): string
    {
        return '@QuoteRequestWidget/views/quote-request-menu-item/quote-request-menu-item.twig';
    }

    protected function addIsVisibleParameter(): void
    {
        $this->addParameter(static::PARAMETER_IS_VISIBLE, $this->isWidgetVisible());
    }

    /**
     * @param string $activePage
     *
     * @return void
     */
    protected function addIsActivePageParameter(string $activePage)
    {
        $this->addParameter(static::PARAMETER_IS_ACTIVE_PAGE, $this->isQuoteRequestPageActive($activePage));
    }

    protected function isQuoteRequestPageActive(string $activePage): bool
    {
        return $activePage === static::PAGE_KEY_QUOTE_REQUEST;
    }

    protected function isWidgetVisible(): bool
    {
        return (bool)$this->getFactory()
            ->getCompanyUserClient()
            ->findCompanyUser();
    }
}
