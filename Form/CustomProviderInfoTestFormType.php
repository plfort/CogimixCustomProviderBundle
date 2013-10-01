<?php
namespace Cogipix\CogimixCustomProviderBundle\Form;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author plfort - Cogipix
 *
 */
use Symfony\Component\Form\FormBuilderInterface;

class CustomProviderInfoTestFormType extends CustomProviderInfoEditFormType{


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo',
                'validation_groups' => function(FormInterface $form) {
                                $default = array('Test');
                                $data = $form->getData();
                                if ('none' != $data->getauthType()) {
                                    $default[]='CreateWithAuth';
                                }
                                return $default;
                            },
        ));
    }

}