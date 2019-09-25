<?php

namespace App\Support\Control\Contracts\Repositories;

interface Group
{

    public function getById($id);

    public function allWithTag(\App\Support\Control\Contracts\Models\GroupTag $tag);

    public function all();
}
