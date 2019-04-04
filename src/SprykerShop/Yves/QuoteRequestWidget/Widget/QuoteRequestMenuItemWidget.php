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
    protected const PARAMETER_IS_VISIBLE = 'isVisible';
    protected const PARAMETER_IS_ACTIVE_PAGE = 'isActivePage';

    /**
     * @see \SprykerShop\Yves\QuoteRequestPage\Plugin\Provider\QuoteRequestPageControllerProvider::ROUTE_QUOTE_REQUEST
     */
    protected const ROUTE_QUOTE_REQUEST = 'quote-request';

    /**
     * @param string $activePage
     */
    public function __construct(string $activePage)
    {
        $this->addIsVisibleParameter();
        $this->addIsActivePageParameter($activePage);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'QuoteRequestMenuItemWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@QuoteRequestWidget/views/quote-request/quote-request-menu-item/quote-request-menu-item.twig';
    }

    /**
     * @return void
     */
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

    /**
     * @param $activePage string
     *
     * @return bool
     */
    protected function isQuoteRequestPageActive(string $activePage): bool
    {
        return $activePage === static::ROUTE_QUOTE_REQUEST;
    }

    /**
     * @return bool
     */
    protected function isWidgetVisible(): bool
    {
        return (bool)$this->getFactory()
            ->getCompanyUserClient()
            ->findCompanyUser();
    }
}
