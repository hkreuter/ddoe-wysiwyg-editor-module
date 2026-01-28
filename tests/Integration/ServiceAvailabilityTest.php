<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\WysiwygModule\Tests\Integration;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ServiceAvailabilityTest extends IntegrationTestCase
{
    private static $cachedContainer;
    private static $decorations = [];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$cachedContainer = ContainerFactory::getInstance()->getContainer();
    }

    #[DataProvider('serviceAvailabilityDataProvider')]
    #[Test]
    public function servicesAvailable(string $serviceName): void
    {
        $service = self::$cachedContainer->get($serviceName);
        $this->assertInstanceOf($serviceName, $service);
    }

    #[DataProvider('serviceDecorationProvider')]
//    #[Test]
    public function servicesDecorated(string $serviceName, array $expectedDecorations): void
    {
        $decorations = self::$decorations[$serviceName];
        foreach ($expectedDecorations as $oneExpectedDecoration) {
            $this->assertContains($oneExpectedDecoration, $decorations);
        }
    }

    public static function serviceDecorationProvider(): \Generator
    {
    }

    public static function serviceAvailabilityDataProvider(): array
    {
        return [
            // HtmlFilter (public services)
            [\OxidEsales\WysiwygModule\HtmlFilter\HtmlFilterInterface::class],
            [\OxidEsales\WysiwygModule\HtmlFilter\HtmlRemoverInterface::class],

            // Service (public services)
            [\OxidEsales\WysiwygModule\Service\EditorRendererInterface::class],
        ];
    }
}
