<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Dto\UserCreateDto;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UserService;
use App\Exception\ValidationException;

class UserController extends AbstractController
{   
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    #[Route('api/register', name: 'app_user_register')]
    public function registerUser(Request $request): JsonResponse
    {
        $userCreateDto = new UserCreateDto($request);

        try {
            $this->userService->createUser($userCreateDto);
        } catch (ValidationException $e) {
            return new JsonResponse(['errors' => $e->getErrors()], 400);
        } catch (\Exception $e) {
            throw $e; 
        }
        
        return $this->json(['message' => 'User created']);
    }
}
