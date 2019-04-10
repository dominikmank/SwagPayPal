<?php declare(strict_types=1);

namespace Swag\PayPal\PayPal\Resource;

use Shopware\Core\Framework\Context;
use Swag\PayPal\PayPal\Api\Refund;
use Swag\PayPal\PayPal\Client\PayPalClientFactory;
use Swag\PayPal\PayPal\RequestUri;

class CaptureResource
{
    /**
     * @var PayPalClientFactory
     */
    private $payPalClientFactory;

    public function __construct(PayPalClientFactory $payPalClientFactory)
    {
        $this->payPalClientFactory = $payPalClientFactory;
    }

    public function refund(string $captureId, Refund $refund, Context $context): Refund
    {
        $response = $this->payPalClientFactory->createPaymentClient($context)->sendPostRequest(
            RequestUri::CAPTURE_RESOURCE . '/' . $captureId . '/refund',
            $refund
        );

        $refund->assign($response);

        return $refund;
    }
}