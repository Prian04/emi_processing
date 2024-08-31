<?php
namespace App\Services;

use App\Repositories\Contracts\LoanDetailRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Services\Contracts\EMIServiceInterface;
class EMIService implements EMIServiceInterface
{
    protected $loanDetailRepository;

    public function __construct(LoanDetailRepositoryInterface $loanDetailRepository){
        $this->loanDetailRepository = $loanDetailRepository;
    }

    public function all(){
        
        return $this->loanDetailRepository->all();
    }

    public function processEMIData(){
      
    $minDate = $this->loanDetailRepository->all()->min('first_payment_date');
    $maxDate = $this->loanDetailRepository->all()->max('last_payment_date');

  
    $start = new \DateTime($minDate);
    $end = new \DateTime($maxDate);
    $end->modify('+1 month');

    $period = new \DatePeriod($start, new \DateInterval('P1M'), $end);

   
    $columns = [];
    foreach ($period as $dt) {
        $columns[] = $dt->format('Y_M');
    }

   
    DB::statement('DROP TABLE IF EXISTS emi_details');

    $createTableSQL = "CREATE TABLE emi_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        clientid INT";

    foreach ($columns as $column) {
        $createTableSQL .= ", `$column` DECIMAL(10, 2) DEFAULT 0";
    }

    $createTableSQL .= ")";

    DB::statement($createTableSQL);

    // Process each loan and calculate EMI
    $loans = $this->loanDetailRepository->all();

    foreach ($loans as $loan) {
        $emiAmount = round($loan->loan_amount / $loan->num_of_payment, 2);
        $remainingAmount = $loan->loan_amount;
        $payments = [];

        // Generate payment dates for each EMI
        $currentDate = new \DateTime($loan->first_payment_date);

        for ($i = 0; $i < $loan->num_of_payment; $i++) {
            $monthColumn = $currentDate->format('Y_M');
            $payments[$monthColumn] = $emiAmount;
            $remainingAmount -= $emiAmount;

            // Move to the next month
            $currentDate->modify('+1 month');
        }

        // Adjust the last payment to ensure the total EMI equals the loan amount
        $lastPaymentMonth = $currentDate->modify('-1 month')->format('Y_M');
        $payments[$lastPaymentMonth] += round($remainingAmount, 2);

     
        $insertSQL = "INSERT INTO emi_details (clientid";

        foreach ($payments as $month => $amount) {
            $insertSQL .= ", `$month`";
        }

        $insertSQL .= ") VALUES (:clientid";

        foreach ($payments as $month => $amount) {
            $insertSQL .= ", :$month";
        }

        $insertSQL .= ")";

        $bindings = ['clientid' => $loan->clientid];
        foreach ($payments as $month => $amount) {
            $bindings[$month] = $amount;
        }

        DB::statement($insertSQL, $bindings);
    }
    }
}