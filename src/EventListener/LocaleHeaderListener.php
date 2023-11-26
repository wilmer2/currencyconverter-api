<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleHeaderListener
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Check if locale is provided in the request
        $locale =  $request->headers->get('Accept-Language');

        if ($locale) {
            // Set the locale if provided
            $request->setLocale($locale);
        }
    }

}