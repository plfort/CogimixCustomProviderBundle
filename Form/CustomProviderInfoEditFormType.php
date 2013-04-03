<?php
namespace Cogipix\CogimixCustomProviderBundle\Form;
/**
 *
 * @author plfort - Cogipix
 *
 */
use Symfony\Component\Form\FormBuilderInterface;

class CustomProviderInfoEditFormType extends CustomProviderInfoFormType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder->remove('alias');

    }

    public function getName() {
        return 'custom_provider_edit_form';
    }
}