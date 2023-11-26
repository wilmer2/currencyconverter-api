<?php

namespace App\Adapter;

use Symfony\Contracts\Translation\TranslatorInterface;


class TranslateAdapter
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    private function trans(string $message, string $domain)
    {
        return $this->translator->trans($message, domain: $domain);
    }

    public function translateException(string $message): string
    {
        return $this->trans($message, 'exception');
    }

    public function translateValidators(string $message): string
    {
        return $this->trans($message, 'validators');
    }
}