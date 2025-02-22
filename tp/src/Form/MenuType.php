<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cuisine', ChoiceType::class, [
                'label' => 'Type de cuisine',
                'choices' => [
                    'Française' => 'Française',
                    'Italienne' => 'Italienne',
                    'Asiatique' => 'Asiatique',
                    'Végétarienne' => 'Végétarienne',
                ],
            ])
            ->add('nbPlats', IntegerType::class, [
                'label' => 'Nombre de plats',
                'data' => 3,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Générer le menu',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
