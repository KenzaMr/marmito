<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => false,
            ])
            ->add('time')
            ->add('nbpersonne')
            ->add('difficulties', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'description',
            ])
            ->add('prix')
            ->add('favoris')
            ->add('Ingredients',EntityType::class,[
                'class'=>Recette::class,
                'choice_label'=>'name',
                'multiple'=>true,
                'expanded' => true,
            ])
            ->add('thumnailfile',FileType::class,[
                'mapped'=>false,
                'required'=>false
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...));
    }
    public function autoSlug(PreSubmitEvent $event)
    {
        $data=$event->getData();
        if (empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($data['name'])->lower();
            $data['slug']=$slug;

            $event->setData($data);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
