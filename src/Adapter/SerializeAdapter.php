<?php

namespace App\Adapter;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class SerializeAdapter {
    private $serializer;
    
    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function deserialize($data, $class, $format)
    {
        $response = $this->serializer->deserialize($data, $class, $format);

        return $response;
    }

    public function deserializeJson($data, $class)
    {
        $response = $this->deserialize($data, $class, 'json');

        return $response;
    }

}