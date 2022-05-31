<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 30/05/2022
 * Time: 23:19
 */

namespace App\Data;

class SearchData
{
    /**
     * @var ?string
     */
    public ?string $q = '';

    public bool $done = false;

    public bool $toDo = false;

    public bool $delete = false;
}