@extends('layouts.app')

@section('content')


<div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-home"></i>
                            </span> Dashboard
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                            </li>
                            </ul>
                        </nav>
                        </div>
                        <div class="row">
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Main Account <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">NGN {{number_format($main_account, 2)}}</h2>
                                <h6 class="card-text">Main Account Balance</h6>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-dark card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Bonus Account <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">NGN {{number_format($bonus_account, 2)}}</h2>
                                <h6 class="card-text">Bonus Account Balance</h6>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Weekly Sales <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">NGN {{number_format($weekly_total), 2}}</h2>
                                <h6 class="card-text">Total sales for the week</h6>
                            </div>
                            </div>
                        </div>


                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Withdrawal<i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">NGN {{number_format($all_sales), 2}}</h2>
                                    <div class="column"><h6 class="card-text">Total Withdrawal</h6>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3"> Transactions Count <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">{{$trasaction_count}}</h2>
                                <h6 class="card-text">Weekly Transaction Count</h6>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-7 grid-margin stretch-card">
                            <div class="card">

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
                                        <th> Credit(NGN) </th>
                                        <th> Debit(NGN) </th>
                                        <th> Balance(NGN) </th>
                                        <th> Status </th>
                                        <th> Narration </th>
                                        <th> Date </th>
                                        <th> Time </th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($transaction as $item)
                                        <tr>
                                            <td>{{$item->ref_trans_id}}</td>
                                            <td>{{$item->transaction_type}}</td>
                                            <td>{{number_format($item->credit, 2)}}</td>
                                            <td>{{number_format($item->debit, 2)}}</td>
                                            <td>{{number_format($item->balance, 2)}}</td>
                                            @if($item->status == "0")
                                            <td><span class="badge rounded-pill bg-warning text-dark">Pending</span></td>
                                            @elseif($item->status == "1")
                                            <td><span class="badge rounded-pill bg-success">Success</span></td>
                                            @else
                                            <td><span class="badge rounded-pill bg-danger">Rejected</span></td>
                                            @endif
                                            <td>{{$item->note}}</td>
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
                        <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"><a href="https://enkwave.com.contact-us target="_blank">Contact us</span>
                        </div>
                    </footer>
                    <!-- partial -->
                    </div>
                    <!-- main-panel ends -->
                </div>
                <!-- page-body-wrapper ends -->
                </div>








@endsection
