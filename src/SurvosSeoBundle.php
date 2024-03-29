<?php

/** generated from /home/tac/ca/survos/packages/maker-bundle/templates/skeleton/bundle/src/Bundle.tpl.php */

namespace Survos\SeoBundle;

use Survos\SeoBundle\DataCollector\SeoCollector;
use Survos\SeoBundle\Service\SeoService;
use Survos\SeoBundle\Twig\Extension\SeoExtension;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SurvosSeoBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        // $builder->setParameter('survos_workflow.direction', $config['direction']);

        // twig classes
//        <services>
//        <service class="Vich\UploaderBundle\DataCollector\MappingCollector" id="Vich\UploaderBundle\DataCollector\MappingCollector" public="false">
//            <argument type="service" id="vich_uploader.metadata_reader" />
//            <tag name="data_collector" template="@VichUploader/Collector/mapping_collector.html.twig"
// id="vich_uploader.mapping_collector" />
//        </service>
//    </services>

        $builder->autowire(SeoService::class)
            ->setArgument('$config', $config)
            ;

        $builder->autowire(SeoCollector::class)
            ->setArgument('$seoService', new Reference(SeoService::class))
            ->addTag('data_collector', [
                'template' => '@SurvosSeo/seo_collector.html.twig'
            ]);

        $definition = $builder
            ->autowire('survos.seo_twig', SeoExtension::class)
            ->addTag('twig.extension')
            ->setArgument('$seoService', new Reference(SeoService::class))
        ;
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->scalarNode('branding')->defaultValue('')->end()
            ->integerNode('minTitleLength')->defaultValue(30)->end()
            ->integerNode('maxTitleLength')->defaultValue(150)->end()
            ->integerNode('minDescriptionLength')->defaultValue(10)->end()
            ->integerNode('maxDescriptionLength')->defaultValue(255)->end()
            ->booleanNode('enabled')->defaultTrue()->end()
//            ->integerNode('min_sunshine')->defaultValue(3)->end()
            ->end();
    }
}
