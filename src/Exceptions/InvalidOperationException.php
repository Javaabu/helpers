<?php
namespace Javaabu\Helpers\Exceptions;

class InvalidOperationException extends AppException
{
    /**
     * Constructor
     * @param string $message
     * @param string $name
     */
    public function __construct($message = 'The operation is invalid', $name = 'InvalidOperation')
    {
        parent::__construct(422, $name, $message);
    }

}
