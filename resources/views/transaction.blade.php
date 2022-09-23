@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

    <div class="row">
              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                  <div class="card-body">
                    <div class="clearfix">
                      <div class="float-left">
                        <i class="mdi mdi-arrow-down-bold-circle text-success icon-lg"></i>
                      </div>
                      <div class="float-right">
                        <p class="mb-0 text-right">Total Cash In</p>
                        <div class="fluid-container">
                          <h3 class="font-weight-medium text-right mb-0">NGN {{number_format($money_in), 2 }}</h3>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                  <div class="card-body">
                    <div class="clearfix">
                      <div class="float-left">
                        <i class=" mdi mdi-arrow-up-bold-circle  text-danger icon-lg"></i>
                      </div>
                      <div class="float-right">
                        <p class="mb-0 text-right">Total Cash Out</p>
                        <div class="fluid-container">
                          <h3 class="font-weight-medium text-right mb-0">NGN {{number_format($money_out), 2 }}</h3>
                        </div>
                      </div>
                    </div>
                   
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                  <div class="card-body">
                    <div class="clearfix">
                      <div class="float-left">
                        <i class="mdi mdi-poll-box text-success icon-lg"></i>
                      </div>
                      <div class="float-right">
                        <p class="mb-0 text-right">Successful Transactions</p>
                        <div class="fluid-container">
                          <h3 class="font-weight-medium text-right mb-0">{{$sucessful_trx}}</h3>
                        </div>
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                  <div class="card-body">
                    <div class="clearfix">
                      <div class="float-left">
                        <i class="mdi mdi-poll-box text-danger text-info icon-lg"></i>
                      </div>
                      <div class="float-right">
                        <p class="mb-0 text-right">Failed Transactions</p>
                        <div class="fluid-container">
                          <h3 class="font-weight-medium text-right mb-0">{{$failed_trx}}</h3>
                        </div>
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>




<div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Transactions</h4>
                                <div class="table-responsive">
                                <table class="table" id="mytable">
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


                                </table>
                                </div>
                            </div>
 
                            </div>
                            </div>


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


</div>


                                         




@endsection

@section('javascripts')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#mytable').DataTable();
        });
    </script>
@endsection