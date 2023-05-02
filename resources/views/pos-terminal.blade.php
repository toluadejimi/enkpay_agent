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
                                <i class="mdi mdi-clipboard-check-bold-circle text-success icon-lg"></i>
                            </div>
                            <div class="float-right">
                                <p class="mb-0 text-right">Total Terminal </p>
                                <div class="fluid-container">
                                    <h3 class="font-weight-medium text-right mb-0">{{$terminal_count}}
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
                    type="button" role="tab" aria-controls="pills-home" aria-selected="false">Terminal List</button>
            </li>

        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Active Terminals</h4>
                                <div class="table-responsive">
                                    <table class="table" id="mytable">
                                        <thead>
                                            <tr>
                                                <th> Serial No </th>
                                                <th> Description </th>
                                                <th> Transfer Status </th>
                                                <th> POS Status</th>



                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($terminal as $item)
                                            <tr>
                                                <td><a href="/terminal-view/?serial_no={{$item->serial_no}}">{{$item->serial_no}}
                                                </td></a>
                                                <td>{{$item->description}}</td>
                                                @if($item->transfer_status == "0")
                                                <td><span class="badge rounded-pill bg-warning text-dark">Can't
                                                        Transfer</span>
                                                </td>
                                                @elseif($item->transfer_status == "1")
                                                <td><span class="badge rounded-pill bg-success">Transfer Active</span>
                                                </td>
                                                @else
                                                <td><span class="badge rounded-pill bg-danger">NAN</span></td>
                                                @endif

                                                @if($item->status == "0")
                                                <td><span
                                                        class="badge rounded-pill bg-warning text-dark">Inactive</span>
                                                </td>
                                                @elseif($item->status == "1")
                                                <td><span class="badge rounded-pill bg-success">Active</span></td>
                                                @else
                                                <td><span class="badge rounded-pill bg-danger">NAN</span></td>
                                                @endif

                                            </tr>
                                            @empty
                                            <tr colspan="20" class="text-center">No Terminal Record Found</tr>
                                            @endforelse

                                        </tbody>


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
