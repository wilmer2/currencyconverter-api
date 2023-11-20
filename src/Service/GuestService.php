<?php

namespace App\Service;

use App\Dto\GuestIdRequestDto;
use App\Repository\GuestRepository;
use App\Entity\Guest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\ORM\EntityManagerInterface;

class GuestService {
    private $guestRepository;
    private $em;
    private const REQUEST_LIMIT = 5;

    public function __construct(
        GuestRepository $guestRepository, 
        EntityManagerInterface $em
    )
    {
        $this->guestRepository = $guestRepository;
        $this->em = $em;
    }

    private function createGuest($guestId)
    {
        $newGuest = new Guest();
        $newGuest->setCount(1);
        $newGuest->setGuestId($guestId);

        $this->em->persist($newGuest);
        $this->em->flush();
    }

    public function trackGuest(GuestIdRequestDto $guestIdRequestDto, $user)
    {   
        if ($user) return;
        
        $guestId = $guestIdRequestDto->getGuestId();
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
                'Guest request limit exceeded. Please consider registering for continued access.'
            );
        }
    }


}