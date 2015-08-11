<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ShippingBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ShippingBundle\Form\EventListener\BuildRuleFormSubscriber;
use Sylius\Component\Shipping\Checker\Registry\RuleCheckerRegistryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\PromotionBundle\Form\Type\Core\AbstractConfigurationType;
use Sylius\Component\Shipping\Model\RuleInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Shipping rule form type.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class RuleType extends AbstractConfigurationType
// class RuleType extends AbstractResourceType
{
    // protected $checkerRegistry;

    // public function __construct($dataClass, array $validationGroups, RuleCheckerRegistryInterface $checkerRegistry)
    // {
    //     parent::__construct($dataClass, $validationGroups);
    //
    //     $this->checkerRegistry = $checkerRegistry;
    // }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        // dump($options);exit;
        $builder
            ->add('type', 'sylius_shipping_rule_choice', array(
                'label' => 'sylius.form.rule.type',
                'attr' => array(
                    'data-form-collection' => 'update',
                ),
            ))
            ->addEventSubscriber(
                new BuildRuleFormSubscriber($this->registry, $builder->getFormFactory(), $options['configuration_type'])
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_shipping_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'configuration_type' => RuleInterface::TYPE_ITEM_COUNT,
        ));
    }

}
