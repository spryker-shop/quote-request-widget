<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Controller;

use Generated\Shared\Transfer\QuoteRequestResponseTransfer;
use Generated\Shared\Transfer\QuoteRequestTransfer;
use SprykerShop\Yves\QuoteRequestWidget\Form\QuoteRequestCartForm;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\QuoteRequestWidget\QuoteRequestWidgetFactory getFactory()
 */
class QuoteRequestCartController extends AbstractController
{
    protected const GLOSSARY_KEY_QUOTE_REQUEST_UPDATED = 'quote_request_page.quote_request.updated';

    /**
     * @uses \SprykerShop\Yves\CartPage\Plugin\Provider\CartControllerProvider::ROUTE_CART
     */
    protected const ROUTE_CART = 'cart';

    /**
     * @uses \SprykerShop\Yves\QuoteRequestPage\Plugin\Provider\QuoteRequestPageControllerProvider::ROUTE_QUOTE_REQUEST_EDIT
     */
    protected const ROUTE_QUOTE_REQUEST_EDIT = 'quote-request/edit';

    /**
     * @uses \SprykerShop\Yves\AgentQuoteRequestPage\Plugin\Provider\AgentQuoteRequestPageControllerProvider::PARAM_QUOTE_REQUEST_REFERENCE
     */
    protected const PARAM_QUOTE_REQUEST_REFERENCE = 'quoteRequestReference';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $quoteRequestCartForm = $this->getFactory()
            ->getQuoteRequestCartForm()
            ->handleRequest($request);

        if ($quoteRequestCartForm->isSubmitted()) {
            $quoteRequestResponseTransfer = $this->getFactory()
                ->createQuoteRequestCartHandler()
                ->updateQuoteRequestQuote();

            if ($quoteRequestResponseTransfer->getIsSuccessful()) {
                $this->addSuccessMessage(static::GLOSSARY_KEY_QUOTE_REQUEST_UPDATED);
            }

            $this->handleResponseErrors($quoteRequestResponseTransfer);

            if ($request->get(QuoteRequestCartForm::SUBMIT_BUTTON_SAVE_AND_BACK) !== null) {
                $this->clearCustomerQuote($quoteRequestResponseTransfer->getQuoteRequest());

                return $this->redirectResponseInternal(static::ROUTE_QUOTE_REQUEST_EDIT, [
                    static::PARAM_QUOTE_REQUEST_REFERENCE => $quoteRequestResponseTransfer->getQuoteRequest()->getQuoteRequestReference(),
                ]);
            }
        }

        return $this->redirectResponseInternal(static::ROUTE_CART);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteRequestResponseTransfer $quoteRequestResponseTransfer
     *
     * @return void
     */
    protected function handleResponseErrors(QuoteRequestResponseTransfer $quoteRequestResponseTransfer): void
    {
        foreach ($quoteRequestResponseTransfer->getMessages() as $messageTransfer) {
            $this->addErrorMessage($messageTransfer->getValue());
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteRequestTransfer $quoteRequestTransfer
     *
     * @return void
     */
    protected function clearCustomerQuote(QuoteRequestTransfer $quoteRequestTransfer): void
    {
        $this->getFactory()
            ->getCartClient()
            ->clearQuote();

        $this->getFactory()
            ->getPersistentCartClient()
            ->reloadQuoteForCustomer($quoteRequestTransfer->getCompanyUser()->getCustomer());
    }
}
