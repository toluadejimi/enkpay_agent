@extends('layouts.app')

@section('content')

<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">


<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Withdrawal </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Available Balance</li>
                    <li class="breadcrumb-item">NGN {{number_format($user_balance), 2}}</li>

                </ol>
            </nav>




        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Withdrawal</h4>
                        <p class="card-description"> Transfer your Funds to your bank account </p>



                    </div>
                </div>
            </div>




            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    <div class="card-body">

                        <h4 class="card-title">Bank Transfer</h4>

                        <form method="POST" action="/bank-transfer-now" class="pt-3">
                            @csrf

                            <div class="form-group">
                                <label>Enter Amount To Withdraw</label>
                                <input type="number" name="amount" class="form-control form-control-lg"
                                    required placeholder="Min NGN 100 | Max NGN 250,000.00 " aria-label=" ">
                                <small> Transfer charges  NGN {{$t_charges}}</small>
                            </div>

                            <div class="form-group">
                                <label>Enter Pin</label>
                                <input type="number" name="pin" class="form-control form-control-lg" required>
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-gradient-primary me-2"> Continue </button>

                            </div>

                    </div>
                    </form>

                </div>
            </div>






            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Account Information</h2>



                        <div class="row">
                            <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="">Account Name</p>
                                    <button type="submit" class="btn btn-gradient-danger me-2">
                                        {{Auth::user()->c_account_name}}</button>

                                </div>

                                <div class="col-md-6 ">
                                    <p class="">Bank Name</p>
                                    <button type="submit" class="btn btn-gradient-danger me-2">
                                        {{Auth::user()->c_bank_name}}</button>

                                </div>

                                <div class="col-md-6">

                                    <p class="">Account Number</p>
                                    <button type="submit" class="btn btn-gradient-danger me-2">
                                        {{Auth::user()->c_account_number}}</button>

                                </div>

                                <div class="col-xs-6">
                                    <form method="GET" action="#" class="pt-3">
                                        @csrf
                                        <div class="form-group pt-3">
                                            <button type="submit" class="btn btn-gradient-primary me-2">
                                                Update Account Information</button>
                                        </div>
                                    </form>
                                </div>

                            </div>









                                {{-- <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group pt-3">
                                            <label>Bank Name</label>
                                            <input type="text" class="form-control form-control-lg" disabled
                                                value="{{  Auth::user()->c_bank_name  }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <form method="POST" action="/update-bank" class="pt-3">
                                            @csrf
                                            <div class="form-group pt-3">
                                                <button type="submit" class="btn btn-gradient-primary me-2">
                                                    Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group pt-3">
                                    <label>Account Number</label>
                                    <input type="text" class="form-control form-control-lg" disabled
                                        value="{{  Auth::user()->account_number  }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pt-3">
                                    <label>Account Name</label>
                                    <input type="text" class="form-control form-control-lg" disabled
                                        value="{{  Auth::user()->account_name  }}">
                                </div>
                            </div> --}}
                        </div>
                    </div>




                </div>
            </div>
        </div>














        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Recent Transactions</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Transaction ID </th>
                                        <th> Type </th>
                                        <th> Amount(NGN) </th>
                                        <th> Status </th>
                                        <th> Narration </th>
                                        <th> Date </th>
                                        <th> Time </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transaction as $item)
                                    <tr>
                                        <td>{{$item->trx_id}}</td>
                                        <td>{{$item->type}}</td>
                                        <td>{{number_format($item->amount, 2)}}</td>
                                        @if($item->status == "0")
                                        <td><span class="badge rounded-pill bg-warning text-dark">Pending</span></td>
                                        @elseif($item->status == "1")
                                        <td><span class="badge rounded-pill bg-success">Success</span></td>
                                        @else
                                        <td><span class="badge rounded-pill bg-danger">Rejected</span></td>
                                        @endif
                                        <td>{{$item->narration}}</td>
                                        <td>{{date('F d, Y', strtotime($item->created_at))}}</td>
                                        <td>{{date('h:i:s A', strtotime($item->created_at))}}</td>

                                    </tr>
                                    @empty
                                    <tr colspan="20" class="text-center">No Record Found</tr>
                                    @endforelse

                                </tbody>
                                {!! $transaction->links() !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">


        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Enkwave 2021</span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a href="https://enkwave.com.contact-us target="
                    _blank">Contact us</span>
        </div>
    </footer>
    <!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>








@endsection
