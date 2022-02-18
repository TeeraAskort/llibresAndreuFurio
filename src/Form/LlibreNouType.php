<?php

namespace App\Form;

use App\Entity\Editorial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LlibreNouType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("isbn", TextType::class)->add('titol', TextType::class)->add('autor', TextType::class)->add('pagines', IntegerType::class)->add('imatge', FileType::class)->add('editorial', EntityType::class, array('class' => Editorial::class, 'choice_label' => 'nom'))->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}
