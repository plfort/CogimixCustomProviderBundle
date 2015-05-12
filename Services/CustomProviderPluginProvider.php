<?php
namespace Cogipix\CogimixCustomProviderBundle\Services;


use Cogipix\CogimixCommonBundle\Plugin\PluginProviderInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CustomProviderPluginProvider implements PluginProviderInterface{

    private $om;
    private $tokenStorage;
    protected $plugins = array();
    protected $pluginProviders;

    private $pluginFactory;

    public function __construct(ObjectManager $om,TokenStorageInterface $tokenStorage,CustomProviderPluginFactory $factory){
        $this->om=$om;
        $this->tokenStorage=$tokenStorage;
        $this->pluginFactory=$factory;

    }

    public function getAvailablePlugins(){
     $user = $this->getCurrentUser();
     if($user!=null){
        $customProviderInfos=$this->om->getRepository('CogimixCustomProviderBundle:CustomProviderInfo')->findByUser($user);
        if(!empty($customProviderInfos)){
            foreach($customProviderInfos as $customProviderInfo){
                $this->plugins[$customProviderInfo->getAlias()]= $this->pluginFactory->createCustomProviderPlugin($customProviderInfo);
            }
        }
     }
        return $this->plugins;
    }


    public function getPluginChoiceList()
    {
        $choices = array();
        if(!empty($this->plugins)){
            foreach($this->plugins as $alias=>$plugin){
                $choices[$alias] = $plugin->getName();
            }
        }
        return $choices;
    }


    protected function getCurrentUser() {
        
        $token = $this->tokenStorage->getToken();
        if($token != null){
           
            $user = $token->getUser();
            if ($user instanceof \FOS\UserBundle\Model\UserInterface){
                return $user;
            }
                
        }
        
        return null;
    }

    public function getAlias(){
        return 'customproviderpluginprovider';
    }
}