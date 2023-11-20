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



class UserService {
    private $em;
    private $passwordHasher;
    private $validator;

    public function __construct(
        EntityManagerInterface $em, 
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    )
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
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

        $password = $this->passwordHasher->hashPassword(
            $user,
            $plainTextPassword
        );

        $user->setEmail($email);
        $user->setPassword($password);

        $this->handleValidationError($user);

        $this->em->persist($user);
        $this->em->flush();   
    }


}