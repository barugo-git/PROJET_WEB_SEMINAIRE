<?php

namespace App\Form;

use App\Entity\Demandes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('theme', TextType::class)
            ->add('resume', TextareaType::class)
            ->add('dateSouhaitee', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('fichier', FileType::class, [
                'label' => 'Fichier de présentation (.zip)',
                'mapped' => false, // le champ n'est pas une propriété de l'entité
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'application/zip',
                            'application/x-zip-compressed',
                            'application/x-compressed',
                            'multipart/x-zip',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier .zip valide.',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demandes::class,
        ]);
    }
}
