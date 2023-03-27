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
                            <div class="card bg-gradient-danger card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Weekly Sales <i class="mdi mdi-chart-line mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">$ 15,0000</h2>
                                <h6 class="card-text">Increased by 60%</h6>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Weekly Orders <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">45,6334</h2>
                                <h6 class="card-text">Decreased by 10%</h6>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white">
                            <div class="card-body">
                                <img src="{{url('')}}/public/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-right"></i>
                                </h4>
                                <h2 class="mb-5">95,5741</h2>
                                <h6 class="card-text">Increased by 5%</h6>
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
                                        <th> Amount </th>
                                        <th> Status </th>
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
