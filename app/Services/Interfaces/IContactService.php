<?php

namespace App\Services\Interfaces;

interface IContactService
{

    public function updateEmpty(array $req);
    public function updateValue(array $req);
    public function dontUpdate(array $req);

    public function getColumns();
}