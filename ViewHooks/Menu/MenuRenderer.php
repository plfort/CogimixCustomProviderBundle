<?php
namespace Cogipix\CogimixCustomProviderBundle\ViewHooks\Menu;


use Cogipix\CogimixBundle\ViewHooks\Menu\MenuItemInterface;


class MenuRenderer implements MenuItemInterface{

    public function getMenuItemTemplate()
    {
          return 'CogimixCustomProviderBundle:Menu:menu.html.twig';

    }
}