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




            <div class="col-md-6 grid-margin stretch-card">
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

                        <h4 class="card-title">Bank Transfer Preview</h4>

                        <form method="POST" action="/pay-now?final_amount={{$final_amount}}" class="pt-3">
                            @csrf

                            <div>  <h6> Amount to withdraw </h6>
                               <p> NGN {{number_format($amount, 2)}}</p>
                            </div>

                            <div>  <h6> Transfer Fee </h6>
                                <p> NGN {{number_format($t_charges, 2)}}</p>
                             </div>

                             <div>  <h6> Total </h6>
                                <p><b> NGN {{number_format($final_amount, 2)}}</p></b>
                             </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-gradient-primary me-2"> Continue </button>

                            </div>
                        </form>
                    </div>


                </div>
            </div>






            <div class="col-md-6 grid-margin stretch-card">
                {{-- <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Account Information</h2>



                        <div class="row">
                            <div class="col-md-12">


                            </div>
                        </div> --}}




                    </div>
                </div>









            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Enkwave
                        2021</span>
                    <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a
                            href="https://enkwave.com.contact-us target=" _blank">Contact us</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>








@endsection
