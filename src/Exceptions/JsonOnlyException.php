<?php
namespace Javaabu\Helpers\Exceptions;

class JsonOnlyException extends AppException
{
    /**
     * Constructor
     *
     * @param null|string $message
     */
    public function __construct($message = '')
    {
        parent::__construct(400, 'OnlyJsonAllowed', $message);
    }

}
