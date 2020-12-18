<?php

namespace App\Services\Interfaces;

interface IContactService
{

    public function save(array $req);

    public function getColumns();
}