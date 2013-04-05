<?php
namespace Cogipix\CogimixCustomProviderBundle\ViewHooks\Css;
use Cogipix\CogimixCommonBundle\ViewHooks\Css\CssImportInterface;


/**
 *
 * @author plfort - Cogipix
 *
 */
class CssImportRenderer implements CssImportInterface
{

    public function getCssImportTemplate()
    {
        return 'CogimixCustomProviderBundle::css.html.twig';
    }

}
