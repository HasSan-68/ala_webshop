<?php

namespace App\Form;

use App\Entity\Producten;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class Producten1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('discription')
            ->add('price')
            ->add('image')

->add('imageFile',VichImageType::class,[
        'required'  => false,
        'allow_delete' => true,
        'download_label' =>'...',
        'download_uri' => true,
        'image_uri' => true,
        'asset_helper' => true,

    ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producten1::class,
        ]);
    }
}
