<?php
namespace Cogipix\CogimixCustomProviderBundle\Form;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;
/**
 *
 * @author plfort - Cogipix
 *
 */
class CustomProviderInfoFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
        ->add('name', 'text', array(
                'label' => 'cogimix.custom_provider.display_name'))
        ->add('alias', 'text', array(
                        'label' => 'cogimix.custom_provider.unique_alias'))
        ->add('authType', 'choice', array('choices'=>array('none'=>'cogimix.custom_provider.authentification.none','basic'=>'cogimix.custom_provider.authentification.basic','digest'=>'cogimix.custom_provider.authentification.digest'),
                                'label' => 'cogimix.custom_provider.authentification'))
        ->add('username','text',array('label'=>'cogimix.custom_provider.authentification.username','required'=>false))
        ->add('password','text',array('label'=>'cogimix.custom_provider.authentification.password','required'=>false))
       ->add('endPointUrl','text',array('label'=>'cogimix.custom_provider.endpoint_url'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Cogipix\CogimixCustomProviderBundle\Entity\CustomProviderInfo',
                'validation_groups' => function(FormInterface $form) {
                                $default = array('Create');
                                $data = $form->getData();
                                if ('none' != $data->getauthType()) {
                                    $default[]='CreateWithAuth';
                                }
                                return $default;
                            },
        ));
    }

    public function getName() {
        return 'custom_provider_create_form';
    }
}