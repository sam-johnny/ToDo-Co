<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 23/05/2022
 * Time: 23:43
 */

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserInvalidException extends AccessDeniedHttpException
{

}