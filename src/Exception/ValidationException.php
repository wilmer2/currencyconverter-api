<?php

namespace App\Exception;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends \Exception
{
    private $errors;

    public function __construct(ConstraintViolationList $errors, $code = 400)
    {
        $this->errors = $errors;
        parent::__construct('Validation failed.', $code, null);
    }

    public function getErrors()
    {
        $errorMessages = [];
        
        /** @var ConstraintViolationInterface $error */
        foreach ($this->errors as $error) {
            $field = $error->getPropertyPath();
            $message = $error->getMessage();

            $errorMessages[$field][] = $message;
        }
        
        return $errorMessages;
    }
}