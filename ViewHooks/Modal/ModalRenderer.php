<?php
namespace Cogipix\CogimixCustomProviderBundle\ViewHooks\Modal;

use Cogipix\CogimixCommonBundle\ViewHooks\Modal\ModalItemInterface;

class ModalRenderer implements ModalItemInterface
{

    public function getModalTemplate()
    {
        return 'CogimixCustomProviderBundle:Modal:modals.html.twig';

    }

}
