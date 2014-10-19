<?php
namespace Kinash\BatteryRecycleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BatteryPackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'text');
        $builder->add('count', 'integer',array('data'=>1));
        $builder->add('name', 'text', array('required'=>false));
        $builder->add('save','submit',array('label'=>'Create'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kinash\BatteryRecycleBundle\Entity\BatteryPack'
        ));
    }

    public function getName()
    {
        return 'battery_pack_form';
    }
}