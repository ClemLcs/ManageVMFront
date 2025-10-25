<?php

// Totalement inutile car remplacé par RegistrationFormType.php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $b, array $options): void
    {
        $b
          ->add('firstName', TextType::class, [
              'label' => 'Prénom',
              'attr'  => ['placeholder' => 'Prénom'],
              'constraints' => [new Assert\NotBlank(message:'Le champs ne peut pas être vide.')],
          ])
          ->add('lastName', TextType::class, [
              'label' => 'Nom',
              'attr'  => ['placeholder' => 'Nom de famille'],
              'constraints' => [new Assert\NotBlank(message:'Le champs ne peut pas être vide.')],
          ])
          ->add('email', EmailType::class, [
              'label' => 'Adresse e-mail',
              'attr'  => ['placeholder' => 'Adresse e-mail'],
              'constraints' => [new Assert\NotBlank(message:'Le champs ne peut pas être vide.'), new Assert\Email()],
          ])
          // Champ non mappé: on le hash avant d’écrire dans password
          ->add('plainPassword', RepeatedType::class, [
              'type' => PasswordType::class,
              'mapped' => false,
              'first_options'  => ['label' => 'Mot de passe', 'attr'=>['placeholder'=>'Mot de passe']],
              'second_options' => ['label' => 'Confirmer le mot de passe','attr'=>['placeholder'=>'Confirmer le mot de passe']],
              'invalid_message' => 'Les mots de passe ne correspondent pas.',
              'constraints' => [
                  new Assert\NotBlank(message:'Le champs ne peut pas être vide.'),
                  new Assert\Length(min: 10, minMessage: 'Au moins 10 caractères.'),
                  new Assert\Regex(pattern:'/.*[A-Z].*/', message:'Au moins une majuscule.'),
                  new Assert\Regex(pattern:'/.*[a-z].*/', message:'Au moins une minuscule.'),
                  new Assert\Regex(pattern:'/.*\d.*/',   message:'Au moins un chiffre.'),
                  new Assert\Regex(pattern:'/.*[^A-Za-z0-9].*/', message:'Au moins un caractère spécial.'),
              ],
          ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
