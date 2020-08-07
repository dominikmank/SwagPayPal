<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\PayPal\Api\Plan;

use Swag\PayPal\PayPal\Api\Common\PayPalStruct;

class Taxes extends PayPalStruct
{
    /**
     * @var string
     */
    protected $percentage;

    /**
     * @var bool
     */
    protected $inclusive;

    public function getPercentage(): string
    {
        return $this->percentage;
    }

    public function setPercentage(string $percentage): void
    {
        $this->percentage = $percentage;
    }

    public function isInclusive(): bool
    {
        return $this->inclusive;
    }

    public function setInclusive(bool $inclusive): void
    {
        $this->inclusive = $inclusive;
    }
}
