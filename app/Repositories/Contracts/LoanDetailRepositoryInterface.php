<?php
namespace App\Repositories\Contracts;

interface LoanDetailRepositoryInterface
{
    public function all();
    public function find($id);
}