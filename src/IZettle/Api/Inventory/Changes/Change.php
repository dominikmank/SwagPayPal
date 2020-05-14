<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\IZettle\Api\Inventory\Changes;

use Swag\PayPal\IZettle\Api\Common\IZettleStruct;

class Change extends IZettleStruct
{
    /**
     * @var string
     */
    protected $productUuid;

    /**
     * @var string
     */
    protected $variantUuid;

    /**
     * @var string
     */
    protected $fromLocationUuid;

    /**
     * @var string
     */
    protected $toLocationUuid;

    /**
     * @var int
     */
    protected $change;

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function setProductUuid(string $productUuid): void
    {
        $this->productUuid = $productUuid;
    }

    public function getVariantUuid(): string
    {
        return $this->variantUuid;
    }

    public function setVariantUuid(string $variantUuid): void
    {
        $this->variantUuid = $variantUuid;
    }

    public function setFromLocationUuid(string $fromLocationUuid): void
    {
        $this->fromLocationUuid = $fromLocationUuid;
    }

    public function setToLocationUuid(string $toLocationUuid): void
    {
        $this->toLocationUuid = $toLocationUuid;
    }

    public function setChange(int $change): void
    {
        $this->change = $change;
    }
}
