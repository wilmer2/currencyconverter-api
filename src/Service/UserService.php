<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Dto\UserCreateDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\ValidationException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService {
    private $em;
    private $passwordHasher;
    private $validator;
    private $tokenStorage;

    public function __construct(
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator,
        TokenStorageInterface $tokenStorage 
    )
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;

        $this->tokenStorage = $tokenStorage;
    }

    private function handleValidationError($user)
    {
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    public function createUser(UserCreateDto $userCreateDto)
    {
        $user = new User();
        $email = $userCreateDto->getEmail();
        $plainTextPassword = $userCreateDto->getPassword();
        $user->setEmail($email);
        $user->setPassword($plainTextPassword);
        $this->handleValidationError($user);

        $password = $this->passwordHasher->hashPassword(
          $user,
          $plainTextPassword
        );

        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();   
    }

    public function getCurrentUser()
    {   
        $token = $this->tokenStorage->getToken();

        return $token ? $token->getUser() : null;
    }
}