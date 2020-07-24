<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class QuoteRequestWidgetRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @deprecated Use {@link \SprykerShop\Yves\QuoteRequestWidget\Plugin\Router\QuoteRequestWidgetRouteProviderPlugin::ROUTE_NAME_QUOTE_REQUEST_SAVE_CART} instead.
     */
    protected const ROUTE_QUOTE_REQUEST_SAVE_CART = 'quote-request/cart/save';
    public const ROUTE_NAME_QUOTE_REQUEST_SAVE_CART = 'quote-request/cart/save';
    /**
     * @deprecated Use {@link \SprykerShop\Yves\QuoteRequestWidget\Plugin\Router\QuoteRequestWidgetRouteProviderPlugin::ROUTE_NAME_QUOTE_REQUEST_CLEAR_CART} instead.
     */
    protected const ROUTE_QUOTE_REQUEST_CLEAR_CART = 'quote-request/cart/clear';
    public const ROUTE_NAME_QUOTE_REQUEST_CLEAR_CART = 'quote-request/cart/clear';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addQuoteRequestSaveCartRoute($routeCollection);
        $routeCollection = $this->addQuoteRequestClearCartRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\QuoteRequestWidget\Controller\QuoteRequestCartController::indexAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addQuoteRequestSaveCartRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quote-request/cart/save', 'QuoteRequestWidget', 'QuoteRequestCart', 'saveAction');
        $routeCollection->add(static::ROUTE_NAME_QUOTE_REQUEST_SAVE_CART, $route);

        return $routeCollection;
    }

    /**
     * @uses \SprykerShop\Yves\QuoteRequestWidget\Controller\QuoteRequestCartController::clearAction()
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addQuoteRequestClearCartRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/quote-request/cart/clear', 'QuoteRequestWidget', 'QuoteRequestCart', 'clearAction');
        $routeCollection->add(static::ROUTE_NAME_QUOTE_REQUEST_CLEAR_CART, $route);

        return $routeCollection;
    }
}
