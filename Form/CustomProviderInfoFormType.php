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
                'label' => 'Display name'))
        ->add('alias', 'text', array(
                        'label' => 'Unique alias'))
        ->add('authType', 'choice', array('choices'=>array('none'=>'None','basic'=>'Basic','digest'=>'Digest'),
                                'label' => 'Auth'))
        ->add('username','text',array('label'=>'Username','required'=>false))
        ->add('password','text',array('label'=>'Password','required'=>false))
       ->add('endPointUrl','text',array('label'=>'URL'));
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