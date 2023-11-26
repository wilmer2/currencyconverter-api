<?php

namespace App\Service;

use App\Dto\GuestIdRequestDto;
use App\Repository\GuestRepository;
use App\Entity\Guest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Adapter\TranslateAdapter;

class GuestService {
    private $em;
    private $guestRepository;
    private $userService;

    private $translate;

    private const REQUEST_LIMIT = 5;

    public function __construct(
        EntityManagerInterface $em,
        GuestRepository $guestRepository,
        UserService $userService,
        TranslateAdapter $translate
    )
    {
        $this->em = $em;
        $this->guestRepository = $guestRepository;
        $this->userService = $userService;
        $this->translate = $translate;
    }

    private function createGuest($guestId)
    {
        $newGuest = new Guest();
        $newGuest->setCount(1);
        $newGuest->setGuestId($guestId);

        $this->em->persist($newGuest);
        $this->em->flush();
    }

    public function trackGuest(GuestIdRequestDto $guestIdRequestDto)
    {
        $user = $this->userService->getCurrentUser();

        if ($user) return;

        $guestId = $guestIdRequestDto->getGuestId();

        if (!$guestId) {
            throw new HttpException(
                400,
                $this->translate->translateException('guest.request.header')
            );
        }

        $guest = $this->guestRepository->findOneBy(['guestId' => $guestId]);

        if (!$guest) {
            $this->createGuest($guestId);
        } else {
            $this->checkRequestLimit($guest);
            $this->guestRepository->incrementCountByGuestId($guestId);
        }
    }

    private function checkRequestLimit($guest)
    {
        $count = $guest->getCount();

        if ($count >= self::REQUEST_LIMIT) {
            throw new HttpException(
                429,
                $this->translate->translateException('guest.request.limit_exceeded')
            );
        }
    }


}