@extends('layouts.app')

@section('content')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{url('')}}/public/dp/dist/css/bootstrap-select.css">


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
                        <h4 class="card-title">Bank Details Update</h4>
                        <p class="card-description"> Update your bank account details </p>



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

                        <h4 class="card-title">Update Bank Account Information</h4>

                        <form method="POST" action="/verify-info" class="pt-3">
                            @csrf

                            <div class="row">
                                <div class="form-group">
                                    <select class="form-control"  id="number" data-container="body"  name="bank_code" data-live-search="true">                                
                                        <option disable selected>--select bank--</option>
                                        @foreach($banks as $item)
                                        <option value="{{ $item->code }}{{$item->bankName}}">{{ $item->bankName}}</option>
                                        @endforeach
                                    </select>
                                </div>




                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="number" name="account_number" class="form-control form-control-lg"
                                        required placeholder="Enter Account Number">
                                </div>



                                <div class="form-group">
                                    <button type="submit" class="btn btn-gradient-primary me-2"> Continue </button>

                                </div>
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

                <script>

                    var select_box_element = document.querySelector('#select_box');

                    dselect(select_box_element, {
                        search: true
                    });

                </script>


                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
                <script src="{{url('')}}/public/dp/js/bootstrap-select.js"></script>
                <script src="{{url('')}}/public/dp/main.js"></script>





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
