<?php
namespace Cogipix\CogimixCustomProviderBundle\ViewHooks\Modal;

use Cogipix\CogimixBundle\ViewHooks\Modal\ModalItemInterface;

class ModalRenderer implements ModalItemInterface
{

    public function getModalTemplate()
    {
        return 'CogimixCustomProviderBundle:Modal:modals.html.twig';

    }

}
