<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Command;

class ConsoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('command', null, ['label' => 'Provide Command: ', 'data' => '-l true -p 234 -d Ala'])
            ->add('schema', null, ['label' => 'Provide Schema: ', 'data' => "l,p#,d*"])
            ->add('save', SubmitType::class, array('label' => 'Create Command'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Command::class]);

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_console_type';
    }
}
