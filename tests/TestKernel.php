<?php

namespace Survos\SeoBundle\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Survos\SeoBundle\SurvosSeoBundle;

class TestKernel extends BaseKernel
{
    public function registerBundles(): iterable
    {
        return [
            new TwigBundle(),
            new FrameworkBundle(),
            new SurvosSeoBundle(),
        ];
    }

    /**
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config.yml');
    }

    public function getProjectDir(): string
    {
        return __DIR__ . '/project-dir';
    }
}
