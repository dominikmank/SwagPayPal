<?php declare(strict_types=1);

namespace Swag\PayPal\Util;

use Shopware\Core\Checkout\Payment\PaymentMethodCollection;
use Shopware\Core\Checkout\Payment\PaymentMethodEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Swag\PayPal\Payment\PayPalPaymentHandler;
use Swag\PayPal\Payment\PayPalPuiPaymentHandler;

class PaymentMethodUtil
{
    /**
     * @var EntityRepositoryInterface
     */
    private $paymentRepository;

    /**
     * @var EntityRepositoryInterface
     */
    private $salesChannelRepository;

    public function __construct(EntityRepositoryInterface $paymentRepository, EntityRepositoryInterface $salesChannelRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->salesChannelRepository = $salesChannelRepository;
    }

    public function getPayPalPaymentMethodId(Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('handlerIdentifier', PayPalPaymentHandler::class));

        $result = $this->paymentRepository->searchIds($criteria, $context);
        if ($result->getTotal() === 0) {
            return null;
        }

        $paymentMethodIds = $result->getIds();

        return array_shift($paymentMethodIds);
    }

    public function getPayPalPuiPaymentMethodId(Context $context): ?string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('handlerIdentifier', PayPalPuiPaymentHandler::class));

        $result = $this->paymentRepository->searchIds($criteria, $context);
        if ($result->getTotal() === 0) {
            return null;
        }

        $paymentMethodIds = $result->getIds();

        return array_shift($paymentMethodIds);
    }

    public function getPaypalPaymentMethodInSalesChannel(SalesChannelContext $salesChannelContext): bool
    {
        $context = $salesChannelContext->getContext();
        $paypalPaymentMethodId = $this->getPayPalPaymentMethodId($context);
        if (!$paypalPaymentMethodId) {
            return false;
        }

        $paymentMethods = $this->getSalesChannelPaymentMethods($salesChannelContext->getSalesChannel(), $context);
        if (!$paymentMethods) {
            return false;
        }

        if ($paymentMethods->get($paypalPaymentMethodId) instanceof PaymentMethodEntity) {
            return true;
        }

        return false;
    }

    private function getSalesChannelPaymentMethods(SalesChannelEntity $salesChannelEntity, Context $context): ?PaymentMethodCollection
    {
        $salesChannelId = $salesChannelEntity->getId();
        $criteria = new Criteria([$salesChannelId]);
        $criteria->addAssociation('paymentMethods');
        /** @var SalesChannelEntity|null $result */
        $result = $this->salesChannelRepository->search($criteria, $context)->get($salesChannelId);

        if (!$result) {
            return null;
        }

        return $result->getPaymentMethods();
    }
}
