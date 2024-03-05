<?php


declare(strict_types=1);

namespace Survos\SeoBundle\Service;

/**
 * SEO related Twig helpers.
 */
final class SeoService
{

    public function __construct(
        private array $config=[]
    )
    {
    }

    public function getConfigValue(string $key)
    {
        return $this->config[$key]; // @todo: error checking
    }

    public function getMinMax(string $key): array
    {
        return [$this->getConfigValue('min' . $key . 'Length'), $this->getConfigValue('max' . $key . 'Length')];
    }

}
