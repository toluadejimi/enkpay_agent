@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class="mdi mdi-arrow-down-bold-circle text-success icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total Cash In</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">NGN {{number_format($money_in), 2 }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 grid-margin stretch-card">
                <div class="card card-statistics">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <i class=" mdi mdi-arrow-up-bold-circle  text-danger icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total Cash Out</p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">NGN {{number_format($money_out), 2 }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>




        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="false">All Transactions</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-profile" aria-selected="false">POS</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                    type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Transfers</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-bills-tab" data-bs-toggle="pill" data-bs-target="#pills-bills"
                    type="button" role="tab" aria-controls="pills-bills" aria-selected="false">Bills</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

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
                                                <th> Debit (NGN) </th>
                                                <th> Credit (NGN) </th>
                                                <th> Balance (NGN) </th>
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
                                                <td>{{number_format($item->debit, 2)}}</td>
                                                <td>{{number_format($item->credit, 2)}}</td>
                                                <td>{{number_format($item->balance, 2)}}</td>

                                                @if($item->status == "0")
                                                <td><span class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                </td>
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


                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>


            </div>



            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">POS  Transactions</h4>
                                <div class="table-responsive">
                                    <table class="table" id="mytable1">
                                        <thead>
                                            <tr>
                                                <th> Transaction ID </th>
                                                <th> Type </th>
                                                <th> Debit (NGN) </th>
                                                <th> Credit (NGN) </th>
                                                <th> Balance (NGN) </th>
                                                <th> Status </th>
                                                <th> Narration </th>
                                                <th> Date </th>
                                                <th> Time </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($pos_transaction as $item)
                                            <tr>
                                                <td>{{$item->ref_trans_id}}</td>
                                                <td>{{$item->transaction_type}}</td>
                                                <td>{{number_format($item->debit, 2)}}</td>
                                                <td>{{number_format($item->credit, 2)}}</td>
                                                <td>{{number_format($item->balance, 2)}}</td>

                                                @if($item->status == "0")
                                                <td><span class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                </td>
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

                                         {!! $pos_transaction->links() !!}


                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>


            </div>





            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Transfer Transactions</h4>
                                <div class="table-responsive">
                                    <table class="table" id="mytable">
                                        <thead>
                                            <tr>
                                                <th> Transaction ID </th>
                                                <th> Type </th>
                                                <th> Debit (NGN) </th>
                                                <th> Credit (NGN) </th>
                                                <th> Balance (NGN) </th>
                                                <th> Status </th>
                                                <th> Narration </th>
                                                <th> Date </th>
                                                <th> Time </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($transfer_transaction as $item)
                                            <tr>
                                                <td>{{$item->ref_trans_id}}</td>
                                                <td>{{$item->transaction_type}}</td>
                                                <td>{{number_format($item->debit, 2)}}</td>
                                                <td>{{number_format($item->credit, 2)}}</td>
                                                <td>{{number_format($item->balance, 2)}}</td>

                                                @if($item->status == "0")
                                                <td><span class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                </td>
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

                                        {!! $transfer_transaction->links() !!}

                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>



             <div class="tab-pane fade" id="pills-bills" role="tabpanel" aria-labelledby="pills-bills-tab">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bills Transactions</h4>
                                <div class="table-responsive">
                                    <table class="table" id="mytable">
                                        <thead>
                                            <tr>
                                                <th> Transaction ID </th>
                                                <th> Type </th>
                                                <th> Debit (NGN) </th>
                                                <th> Credit (NGN) </th>
                                                <th> Balance (NGN) </th>
                                                <th> Status </th>
                                                <th> Narration </th>
                                                <th> Date </th>
                                                <th> Time </th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($bill_transaction as $item)
                                            <tr>
                                                <td>{{$item->ref_trans_id}}</td>
                                                <td>{{$item->transaction_type}}</td>
                                                <td>{{number_format($item->debit, 2)}}</td>
                                                <td>{{number_format($item->credit, 2)}}</td>
                                                <td>{{number_format($item->balance, 2)}}</td>

                                                @if($item->status == "0")
                                                <td><span class="badge rounded-pill bg-warning text-dark">Pending</span>
                                                </td>
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

                                        {!! $bill_transaction->links() !!}

                                    </table>
                                </div>
                            </div>

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


@section('javascripts')
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
            $('#mytable1').DataTable();
        });
</script>
@endsection

