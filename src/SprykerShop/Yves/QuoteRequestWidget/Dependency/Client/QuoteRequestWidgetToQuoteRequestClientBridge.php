<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\QuoteRequestWidget\Dependency\Client;

use Generated\Shared\Transfer\QuoteRequestFilterTransfer;
use Generated\Shared\Transfer\QuoteRequestResponseTransfer;
use Generated\Shared\Transfer\QuoteRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteRequestWidgetToQuoteRequestClientBridge implements QuoteRequestWidgetToQuoteRequestClientInterface
{
    /**
     * @var \Spryker\Client\QuoteRequest\QuoteRequestClientInterface
     */
    protected $quoteRequestClient;

    /**
     * @param \Spryker\Client\QuoteRequest\QuoteRequestClientInterface $quoteRequestClient
     */
    public function __construct($quoteRequestClient)
    {
        $this->quoteRequestClient = $quoteRequestClient;
    }

    public function isQuoteApplicableForQuoteRequest(QuoteTransfer $quoteTransfer): bool
    {
        return $this->quoteRequestClient->isQuoteApplicableForQuoteRequest($quoteTransfer);
    }

    public function isQuoteRequestEditable(QuoteRequestTransfer $quoteRequestTransfer): bool
    {
        return $this->quoteRequestClient->isQuoteRequestEditable($quoteRequestTransfer);
    }

    public function updateQuoteRequest(QuoteRequestTransfer $quoteRequestTransfer): QuoteRequestResponseTransfer
    {
        return $this->quoteRequestClient->updateQuoteRequest($quoteRequestTransfer);
    }

    public function getQuoteRequest(QuoteRequestFilterTransfer $quoteRequestFilterTransfer): QuoteRequestResponseTransfer
    {
        return $this->quoteRequestClient->getQuoteRequest($quoteRequestFilterTransfer);
    }

    public function isQuoteRequestCancelable(QuoteRequestTransfer $quoteRequestTransfer): bool
    {
        return $this->quoteRequestClient->isQuoteRequestCancelable($quoteRequestTransfer);
    }

    public function isEditableQuoteRequestVersion(QuoteTransfer $quoteTransfer): bool
    {
        return $this->quoteRequestClient->isEditableQuoteRequestVersion($quoteTransfer);
    }
}
