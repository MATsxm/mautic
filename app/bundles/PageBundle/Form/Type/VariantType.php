<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\PageBundle\Form\Type;

use Mautic\CoreBundle\Factory\MauticFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class VariantType
 */
class VariantType extends AbstractType
{

    /**
     * @var MauticFactory
     */
    private $factory;

    /**
     * @param MauticFactory $factory
     */
    public function __construct(MauticFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('weight', 'integer', array(
            'label'      => 'mautic.page.form.trafficweight',
            'label_attr' => array('class' => 'control-label'),
            'attr'       => array(
                'class'   => 'form-control',
                'tooltip' => 'mautic.page.form.trafficweight.help'
            ),
            'constraints' => array(
                new NotBlank(
                    array('message' => 'mautic.page.variant.weight.notblank')
                )
            )
        ));

        $builderComponents = $this->factory->getModel('page.page')->getBuilderComponents();

        if (!empty($builderComponents['abTestWinnerCriteria'])) {
            $criteria = $builderComponents['abTestWinnerCriteria']['criteria'];
            $choices  = $builderComponents['abTestWinnerCriteria']['choices'];

            $builder->add('winnerCriteria', 'choice', array(
                'label'      => 'mautic.page.form.abtestwinner',
                'label_attr' => array('class' => 'control-label'),
                'attr'       => array(
                    'class'    => 'form-control',
                    'onchange' => 'Mautic.getPageAbTestWinnerForm(this);'
                ),
                'expanded'   => false,
                'multiple'   => false,
                'choices'    => $choices,
                'empty_value' => 'mautic.core.form.chooseone',
                'constraints' => array(
                    new NotBlank(
                        array('message' => 'mautic.page.variant.winnercriteria.notblank')
                    )
                )
            ));

            $data = (isset($options['data']) && !(empty($options['data']['winnerCriteria']))) ? $options['data']['winnerCriteria'] : '';
            if (!empty($criteria[$data]['formType'])) {
                $builder->add('properties', $criteria[$data]['formType'], array(
                    'required' => false,
                    'label'    => false
                ));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('page_entity'));

        $resolver->setDefaults(array(
            'page_entity' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "pagevariant";
    }
}
