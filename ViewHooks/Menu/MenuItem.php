<?php
namespace Cogipix\CogimixCustomProviderBundle\ViewHooks\Menu;


use Cogipix\CogimixCommonBundle\ViewHooks\Menu\MenuItemInterface;
use Cogipix\CogimixCommonBundle\ViewHooks\Menu\AbstractMenuItem;


class MenuItem  extends AbstractMenuItem{

    public function getMenuItemTemplate()
    {
          return 'CogimixCustomProviderBundle:Menu:menu.html.twig';

    }

    public function getName(){
    	return 'customprovider';
    }
}