<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\QuoteRequestWidget\Dependency\Client\QuoteRequestWidgetToCompanyUserClientInterface;
use SprykerShop\Yves\QuoteRequestWidget\Dependency\Client\QuoteRequestWidgetToCustomerClientInterface;
use SprykerShop\Yves\QuoteRequestWidget\Dependency\Client\QuoteRequestWidgetToPersistentCartClientInterface;
use SprykerShop\Yves\QuoteRequestWidget\Dependency\Client\QuoteRequestWidgetToQuoteClientInterface;
use SprykerShop\Yves\QuoteRequestWidget\Dependency\Client\QuoteRequestWidgetToQuoteRequestClientInterface;
use SprykerShop\Yves\QuoteRequestWidget\Form\QuoteRequestCartForm;
use SprykerShop\Yves\QuoteRequestWidget\Handler\QuoteRequestCartHandler;
use SprykerShop\Yves\QuoteRequestWidget\Handler\QuoteRequestCartHandlerInterface;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @method \SprykerShop\Yves\QuoteRequestWidget\QuoteRequestWidgetConfig getConfig()
 */
class QuoteRequestWidgetFactory extends AbstractFactory
{
    public function createQuoteRequestCartHandler(): QuoteRequestCartHandlerInterface
    {
        return new QuoteRequestCartHandler(
            $this->getQuoteClient(),
            $this->getQuoteRequestClient(),
            $this->getCompanyUserClient(),
        );
    }

    public function createRedirectResponse(string $targetUrl): RedirectResponse
    {
        return new RedirectResponse($targetUrl);
    }

    public function getQuoteRequestClient(): QuoteRequestWidgetToQuoteRequestClientInterface
    {
        return $this->getProvidedDependency(QuoteRequestWidgetDependencyProvider::CLIENT_QUOTE_REQUEST);
    }

    public function getQuoteRequestCartForm(): FormInterface
    {
        return $this->getFormFactory()->create(QuoteRequestCartForm::class);
    }

    public function getFormFactory(): FormFactory
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    public function getPersistentCartClient(): QuoteRequestWidgetToPersistentCartClientInterface
    {
        return $this->getProvidedDependency(QuoteRequestWidgetDependencyProvider::CLIENT_PERSISTENT_CART);
    }

    public function getQuoteClient(): QuoteRequestWidgetToQuoteClientInterface
    {
        return $this->getProvidedDependency(QuoteRequestWidgetDependencyProvider::CLIENT_QUOTE);
    }

    public function getCompanyUserClient(): QuoteRequestWidgetToCompanyUserClientInterface
    {
        return $this->getProvidedDependency(QuoteRequestWidgetDependencyProvider::CLIENT_COMPANY_USER);
    }

    public function getCustomerClient(): QuoteRequestWidgetToCustomerClientInterface
    {
        return $this->getProvidedDependency(QuoteRequestWidgetDependencyProvider::CLIENT_CUSTOMER);
    }

    public function getRouterService(): ChainRouterInterface
    {
        return $this->getProvidedDependency(QuoteRequestWidgetDependencyProvider::SERVICE_ROUTER);
    }
}
