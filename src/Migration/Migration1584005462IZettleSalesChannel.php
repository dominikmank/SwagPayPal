<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\InheritanceUpdaterTrait;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1584005462IZettleSalesChannel extends MigrationStep
{
    use InheritanceUpdaterTrait;

    public function getCreationTimestamp(): int
    {
        return 1584005462;
    }

    public function update(Connection $connection): void
    {
        $connection->executeUpdate('
            CREATE TABLE IF NOT EXISTS `swag_paypal_izettle_sales_channel` (
                `id`                        BINARY(16)              NOT NULL,
                `sales_channel_id`          BINARY(16)              NOT NULL,
                `sales_channel_domain_id`   BINARY(16)              NULL,
                `product_stream_id`         BINARY(16)              NULL,
                `username`                  VARCHAR(255)            NOT NULL,
                `password`                  VARCHAR(255)            NOT NULL,
                `sync_prices`               TINYINT(1)  DEFAULT 1   NOT NULL,
                `replace`                   TINYINT(1)  DEFAULT 0   NOT NULL,
                `created_at`                DATETIME(3)             NOT NULL,
                `updated_at`                DATETIME(3)             NULL,
                PRIMARY KEY (`id`),
                KEY `fk.swag_paypal_izettle_sales_channel.sales_channel_id` (`sales_channel_id`),
                KEY `fk.swag_paypal_izettle_sales_channel.sales_channel_domain_id` (`sales_channel_domain_id`),
                KEY `fk.swag_paypal_izettle_sales_channel.product_stream_id` (`product_stream_id`),
                CONSTRAINT `fk.swag_paypal_izettle_sales_channel.sales_channel_id` FOREIGN KEY (`sales_channel_id`) REFERENCES `sales_channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk.swag_paypal_izettle_sales_channel.sales_channel_domain_id` FOREIGN KEY (`sales_channel_domain_id`) REFERENCES `sales_channel_domain` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
                CONSTRAINT `fk.swag_paypal_izettle_sales_channel.product_stream_id` FOREIGN KEY (`product_stream_id`) REFERENCES `product_stream` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
