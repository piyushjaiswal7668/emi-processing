@extends('layouts.app')

@section('title', 'Loan and EMI Details')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Loan Details</h2>

            <!-- Loan Details Table -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Number of Payments</th>
                        <th>First Payment Date</th>
                        <th>Last Payment Date</th>
                        <th>Loan Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loanDetails as $loan)
                        <tr>
                            <td>{{ $loan->clientid }}</td>
                            <td>{{ $loan->num_of_payment }}</td>
                            <td>{{ $loan->first_payment_date }}</td>
                            <td>{{ $loan->last_payment_date }}</td>
                            <td>{{ number_format($loan->loan_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Process Data Button -->
            <form action="{{ route('process.emi') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Process Data</button>
            </form>
        </div>
    </div>

    <!-- EMI Details Accordion (Only if data exists) -->
    @if (!empty($emiDetails) && count($emiDetails) > 0)
        <div class="row mt-5">
            <div class="col-md-12">
                <h2 class="mb-4">EMI Details</h2>

                <div class="accordion" id="emiAccordion">
                    @foreach($emiDetails as $index => $emi)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    Client ID: {{ $emi->clientid }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#emiAccordion">
                                <div class="accordion-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>EMI Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($emi as $key => $value)
                                                @if ($key !== 'clientid' && $value > 0) <!-- Only show months with EMI > 0 -->
                                                    <tr>
                                                        <td>{{ $key }}</td> <!-- Month as the key -->
                                                        <td>{{ number_format($value, 2) }}</td> <!-- EMI amount as the value -->
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
