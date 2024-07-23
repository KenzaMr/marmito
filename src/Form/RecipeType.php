<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('time')
            ->add('nbpersonne')
            ->add('difficulties', ChoiceType::class, [
                'choices' => [
                    '1' => 'facile',
                    '2' => 'moyennement facile',
                    '3' => 'moyen',
                    '4' => 'moyennement difficile',
                    '5' => 'difficile'
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'description',
            ])
            ->add('prix')
            ->add('favoris')
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...));
    }
    public function autoSlug(PreSubmitEvent $event)
    {
        $data=$event->getData();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
