<?php
namespace App\Repositories;

use App\Models\Loandetails;
use App\Repositories\Contracts\LoanDetailRepositoryInterface;
class LoanDetailRepository implements LoanDetailRepositoryInterface
{
    public function all()
    {
        return Loandetails::all();
    }

    public function find($id)
    {
        return Loandetails::find($id);
    }
}