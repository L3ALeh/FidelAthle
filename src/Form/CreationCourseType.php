<?php

namespace App\Form;

use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\NiveauCourse;
use App\Entity\TypeCourse;
use App\Entity\Course;
use DateTimeInterface;
use Proxies\__CG__\App\Entity\CategorieCourse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class CreationCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCourse', null, array(
                'label' => 'Nom de la course :'
            ))
            ->add('distance', null, array(
                'label' => 'Distance de la course :'
            ))
            ->add('prix', null, array(
                'label' => 'Prix :'
            ))
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => true,
                'label' => 'Date de la course :',
                'attr' => ['required' => true],
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => new \DateTime(),
                        'message' => 'La date ne peut pas être antérieure à aujourd\'hui.',
                    ]),
                ],
            ])
            ->add('unNiveauCourse', EntityType::class, array(
                'class' => NiveauCourse::class,
                'choice_label' => 'label',
                'empty_data' => null,
                'required' => false,
                'label' => 'Choisir le niveau de la course :    '
            ))
            ->add('unTypeCourse', EntityType::class, array(
                'class' => TypeCourse::class,
                'choice_label' => 'label',
                'empty_data' => null,
                'required' => false,
                'label' => 'Choisir le type de course :    '
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
