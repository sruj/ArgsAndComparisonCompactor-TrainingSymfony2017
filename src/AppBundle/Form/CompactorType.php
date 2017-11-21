<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Compactor;

class CompactorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('context', null, ['label' => 'Provide context: ', 'data' => '0'])
            ->add('expected', null, ['label' => 'Provide expected: ', 'data' => "abc"])
            ->add('actual', null, ['label' => 'Provide actual: ', 'data' => "adc"])
            ->add('Go!', SubmitType::class, array('label' => 'Create!'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Compactor::class]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_compactor_type';
    }
}
