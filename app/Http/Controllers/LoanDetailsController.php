<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanDetailsController extends Controller
{
    public function index()
{
    $loanDetails = DB::table('loan_details')->get();

    $emiDetails = [];
    if (DB::getSchemaBuilder()->hasTable('emi_details')) {
        $emiDetails = DB::table('emi_details')->get();
    }


    return view('loan-details.index', compact('loanDetails','emiDetails'));
}

public function processEmi()
{
    DB::statement('DROP TABLE IF EXISTS emi_details');

    $minDate = DB::table('loan_details')->min('first_payment_date');
    $maxDate = DB::table('loan_details')->max('last_payment_date');

    $start = new \DateTime($minDate);
    $end = new \DateTime($maxDate);
    $interval = new \DateInterval('P1M');  // 1 month interval
    $daterange = new \DatePeriod($start, $interval, $end->modify('+1 month'));

    $columns = 'clientid INT, ';
    foreach ($daterange as $date) {
        $columns .= $date->format('Y_M') . ' DECIMAL(10, 2), ';
    }
    $columns = rtrim($columns, ', ');  // Remove the last comma

    DB::statement("CREATE TABLE emi_details ($columns)");

    $loanDetails = DB::table('loan_details')->get();

    foreach ($loanDetails as $loan) {
        $emi = $loan->loan_amount / $loan->num_of_payment;

        $roundedEmi = round($emi, 2);

        $row = ['clientid' => $loan->clientid];
        foreach ($daterange as $date) {
            $row[$date->format('Y_M')] = 0.00;
        }

        $startMonth = new \DateTime($loan->first_payment_date);
        $paymentsMade = 0;
        $totalEmiAssigned = 0.00;

        foreach ($daterange as $date) {
            if ($date >= $startMonth && $paymentsMade < $loan->num_of_payment) {
                $row[$date->format('Y_M')] = $roundedEmi;
                $totalEmiAssigned += $roundedEmi;
                $paymentsMade++;
            }
        }

        $remainingAmount = $loan->loan_amount - $totalEmiAssigned;

        if ($remainingAmount != 0) {
            $daterangeArray = iterator_to_array($daterange);
            $lastPaymentMonth = $daterangeArray[$loan->num_of_payment - 1]->format('Y_M');
            $row[$lastPaymentMonth] += round($remainingAmount, 2);
        }

        DB::table('emi_details')->insert($row);
    }

    return redirect()->route('loan.details');
}


}
