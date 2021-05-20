<?php

namespace App\Form;

use App\Entity\Competition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('theme')
            ->add('date_deb')
            ->add('date_fin')
            ->add('save', SubmitType::class, array(
                'label' => 'Ajouter',
                'attr' => array('class' => 'btn btn-primary mt-3')));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}
