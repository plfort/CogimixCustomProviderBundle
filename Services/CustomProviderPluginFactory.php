<?php
namespace Cogipix\CogimixCustomProviderBundle\Services;


use Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo;

use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomProviderPluginFactory{

    private $container;

    public function __construct(ContainerInterface $container){

        $this->container=$container;
    }

    public function createCustomProviderPlugin(CustomProviderInfo $customProviderInfo){

        $customProviderPlugin = new CustomProviderMusicSearch();
        $customProviderPlugin->setLogger($this->container->get('logger'));
        $customProviderPlugin->setCustomProviderInfo($customProviderInfo);
        $customProviderPlugin->setSerializer($this->container->get('jms_serializer'));
        $customProviderPlugin->setSongManager($this->container->get('cogimix.song_manager'));
       return $customProviderPlugin;
    }
}