<?php

namespace Survos\SeoBundle\Tests\Functional;

use Psr\EventDispatcher\EventDispatcherInterface;
use Survos\SeoBundle\Service\SeoService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Filesystem;

class FunctionalTest extends KernelTestCase
{
    private Container $container;
    private static array $events;

    public function testSomething(): void
    {
        // 1 and 2 are from symfony docs: https://symfony.com/doc/current/testing.html

        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $this->container = static::getContainer();

        /** @var SeoService $seoService */
        $seoService = $this->container->get(SeoService::class);
        dd($seoService->getConfig());

    }

}
