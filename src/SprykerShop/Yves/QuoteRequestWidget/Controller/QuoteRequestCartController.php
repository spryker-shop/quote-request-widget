<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Controller;

use Generated\Shared\Transfer\QuoteRequestResponseTransfer;
use SprykerShop\Yves\QuoteRequestWidget\Form\QuoteRequestCartForm;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\QuoteRequestWidget\QuoteRequestWidgetFactory getFactory()
 */
class QuoteRequestCartController extends AbstractController
{
    /**
     * @var string
     */
    protected const GLOSSARY_KEY_QUOTE_REQUEST_UPDATED = 'quote_request_page.quote_request.updated';

    /**
     * @uses \SprykerShop\Yves\CartPage\Plugin\Router\CartPageRouteProviderPlugin::ROUTE_NAME_CART
     *
     * @var string
     */
    protected const ROUTE_CART = 'cart';

    /**
     * @uses \SprykerShop\Yves\QuoteRequestPage\Plugin\Router\QuoteRequestPageRouteProviderPlugin::ROUTE_NAME_QUOTE_REQUEST_EDIT
     *
     * @var string
     */
    protected const ROUTE_QUOTE_REQUEST_EDIT = 'quote-request/edit';

    /**
     * @var string
     */
    protected const PARAM_QUOTE_REQUEST_REFERENCE = 'quoteRequestReference';

    public function saveAction(Request $request): RedirectResponse
    {
        $response = $this->executeSaveAction($request);

        return $response;
    }

    public function clearAction(): RedirectResponse
    {
        $response = $this->executeClearAction();

        return $response;
    }

    protected function executeSaveAction(Request $request): RedirectResponse
    {
        $quoteRequestResponseTransfer = $this->getFactory()
            ->createQuoteRequestCartHandler()
            ->updateQuoteRequestQuote();

        if ($quoteRequestResponseTransfer->getIsSuccessful()) {
            $this->addSuccessMessage(static::GLOSSARY_KEY_QUOTE_REQUEST_UPDATED);
        }

        $this->handleResponseErrors($quoteRequestResponseTransfer);

        if (
            $request->get(QuoteRequestCartForm::SUBMIT_BUTTON_SAVE) === null
            && $quoteRequestResponseTransfer->getIsSuccessful()
        ) {
            $this->reloadQuoteForCustomer();

            return $this->redirectResponseInternal(static::ROUTE_QUOTE_REQUEST_EDIT, [
                static::PARAM_QUOTE_REQUEST_REFERENCE => $quoteRequestResponseTransfer->getQuoteRequest()->getQuoteRequestReference(),
            ]);
        }

        return $this->redirectResponseInternal(static::ROUTE_CART);
    }

    protected function executeClearAction(): RedirectResponse
    {
        $quoteTransfer = $this->getFactory()->getQuoteClient()->getQuote();

        if (!$quoteTransfer->getQuoteRequestReference()) {
            return $this->redirectResponseInternal(static::ROUTE_CART);
        }

        $this->reloadQuoteForCustomer();

        return $this->redirectResponseInternal(static::ROUTE_QUOTE_REQUEST_EDIT, [
            static::PARAM_QUOTE_REQUEST_REFERENCE => $quoteTransfer->getQuoteRequestReference(),
        ]);
    }

    protected function reloadQuoteForCustomer(): void
    {
        $customerTransfer = $this->getFactory()->getCustomerClient()->getCustomer();

        if (!$customerTransfer) {
            return;
        }

        $this->getFactory()
            ->getPersistentCartClient()
            ->reloadQuoteForCustomer($customerTransfer);
    }

    protected function handleResponseErrors(QuoteRequestResponseTransfer $quoteRequestResponseTransfer): void
    {
        foreach ($quoteRequestResponseTransfer->getMessages() as $messageTransfer) {
            $this->addErrorMessage($messageTransfer->getValue());
        }
    }
}
