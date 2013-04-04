<?php
namespace Cogipix\CogimixCustomProviderBundle\ViewHooks\Menu;


use Cogipix\CogimixCommonBundle\ViewHooks\Menu\MenuItemInterface;


class MenuRenderer implements MenuItemInterface{

    public function getMenuItemTemplate()
    {
          return 'CogimixCustomProviderBundle:Menu:menu.html.twig';

    }
}