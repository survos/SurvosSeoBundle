<?php


declare(strict_types=1);

namespace Survos\SeoBundle\Service;

/**
 * SEO related Twig helpers.
 */
final class SeoService
{


    /**
     * @param array<string, int|string|null> $config
     */
    public function __construct(
        private array $config=[]
    )
    {
    }

    public function getConfigValue(string $key): int|string|null
    {
        return $this->config[$key]; // @todo: error checking
    }

    /**
     * @param string $key
     * @return array<int,int>
     */
    public function getMinMax(string $key): array
    {
        return [
            (int)$this->getConfigValue('min' . $key . 'Length'),
            (int)$this->getConfigValue('max' . $key . 'Length')];
    }

}
