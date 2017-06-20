<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 23/05/2017
 * Time: 15:56
 */

namespace App\Exceptions;


use Exception;

class ServiceException extends Exception
{
    public $errorMsg, $place;

    /**
     * ServiceException constructor.
     *
     * @param string $errorMsg
     * @param string $place
     */
    public function __construct($errorMsg, $place)
    {
        $this->errorMsg = $errorMsg;
        $this->place = $place;
    }

    public function __toString()
    {
        return $this->errorMsg;
    }
}