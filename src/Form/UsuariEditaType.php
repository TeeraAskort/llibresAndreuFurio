<?php

namespace App\Form;

use App\Entity\Editorial;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuariEditaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("username", TextType::class)->add('password', PasswordType::class, ['mapped' => false, 'required' => false])->add('roles', HiddenType::class, ['mapped' => false, 'required' => false, 'empty_data' => 'ROLE_USER'])->add('save', SubmitType::class, array('label' => 'Enviar'));
    }
}
