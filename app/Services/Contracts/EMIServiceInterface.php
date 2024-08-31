<?php
namespace App\Services\Contracts;

interface EMIServiceInterface
{
    public function all();
    public function processEMIData();
}