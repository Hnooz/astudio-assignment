<?php

namespace App\Http\Controllers;

use App\Traits\HandleApiResponseTrait;

abstract class Controller
{
    use HandleApiResponseTrait;

    const ELEMENTS_PER_PAGE = 20;
}
