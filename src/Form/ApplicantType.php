<?php

namespace App\Form;

use App\Entity\Applicant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ApplicantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email', EmailType::class, ['label' => 'Email ID'])
            ->add('experience', NumberType::class, ['label' => 'How Many Months Experience Do You Have?'])
            ->add('postalCode', TextType::class, ['label' => 'Postal Code'])
            ->add('type')
            ->add('resumeFile', VichFileType::class, [
                'required' => true,
                'label' => 'Applying for'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Applicant::class,
        ]);
    }
}
