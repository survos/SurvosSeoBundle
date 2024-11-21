<?php

declare(strict_types=1);

// src/DataCollector/SeoCollector.php
//   from https://www.strangebuzz.com/en/blog/adding-a-custom-data-collector-in-the-symfony-debug-bar
namespace Survos\SeoBundle\DataCollector;

use Survos\SeoBundle\Service\SeoService;
use Survos\SeoBundle\Twig\Extension\SeoExtension;
use Symfony\Component\DomCrawler\Crawler;
    use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

use function Symfony\Component\String\u;

final class SeoCollector extends DataCollector
{

    private const MAX_PANEL_WIDTH = 50;
    private const CLASS_ERROR = 'red';
    private const CLASS_WARNING = 'yellow';
    private const CLASS_OK = 'green';

    public function __construct(private SeoService $seoService)
    {
    }

    public function collect(Request $request, Response $response, \Throwable|null $exception = null): void
    {
        $crawler = new Crawler((string) $response->getContent());

        // Title ———————————————————————————————————————————————————————————————
        $titleTag = $crawler->filter('title');
        if ($titleTag->count() > 0) {
            $titleStr = u($titleTag->text());
            $titleSize = $titleStr->length();
            $titleInfo = [
                'value' => $titleStr->wordwrap(self::MAX_PANEL_WIDTH)->toString(),
                'size' => (string) $titleSize,
                'status' => $this->getTitleClass($titleSize),
            ];
            $this->data['title'] = $titleInfo;
        }

        // Description —————————————————————————————————————————————————————————
        $meta = $crawler->filterXPath('//meta[@name="description"]');
        if ($meta->count() > 0) {
            $descriptionStr = u((string) $meta->attr('content'));
            $descriptionLength = $descriptionStr->length();
            $descriptionInfo = [
                'value' => $descriptionStr->wordwrap(self::MAX_PANEL_WIDTH)->toString(),
                'size' => (string) $descriptionLength,
                'status' => $this->getDescriptionClass($descriptionLength),
            ];
            $this->data['description'] = $descriptionInfo;
        }
    }

    private function getTitleClass(int $size): string
    {
        if ($size === 0) {
            return self::CLASS_ERROR;
        }
        [$min, $max] = $this->seoService->getMinMax('Title');
        return ( ($size >= $min) && ($size <= $max)) ? self::CLASS_OK : self::CLASS_WARNING;
    }

    private function getDescriptionClass(int $size): string
    {
        if ($size === 0) {
            return self::CLASS_ERROR;
        }

        [$min, $max] = $this->seoService->getMinMax('Description');
        return ( ($size >= $min) && ($size <= $max)) ? self::CLASS_OK : self::CLASS_WARNING;

    }

    /**
     * @return array<string,string>
     */
    public function getTitle(): array
    {
        return $this->data['title'] ?? [];
    }

    /**
     * @return array<string,string>
     */
    public function getDescription(): array
    {
        return $this->data['description'] ?? [];
    }

    public function reset(): void
    {
        $this->data = [];
    }

    public function getName(): string
    {
        return self::class;
    }
}
