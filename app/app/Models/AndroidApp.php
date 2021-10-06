<?php

namespace App\Models;

class AndroidApp
{
    public $paths = [];

    public function __construct($paths)
    {
        $this->paths = $paths;
    }
}
