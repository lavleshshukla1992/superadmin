@extends('backend.layouts.master')

@section('title')
    Scheme - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Scheme</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>All Scheme</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 clearfix">
                @include('backend.layouts.partials.logout')
            </div>
        </div>
    </div>
    <!-- page title area end -->

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Scheme List</h4>
                        <div class="clearfix"></div>
                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="2%">Sr. No</th>
                                        <th width="5%">Name</th>
                                        <th width="3%">Created By</th>
                                        <th width="3%">Updated By</th>
                                        <th width="2%">Start Date</th>
                                        <th width="2%">End Date</th>
                                        <th width="5%">Status</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($schemes as $key=> $scheme)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $scheme['name'] }}</td>
                                            <td>{{ $scheme['created_by'] }}</td>
                                            <td>{{ $scheme['updated_by'] }}</td>
                                            <td>{{ $scheme['start_at'] }}</td>
                                            <td>{{ $scheme['end_at'] }}</td>
                                            <td>{{ $scheme['status'] }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <div class="btn-group mr-2">
                                                        <a href="{{route('scheme.show',$scheme['id'])}}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                                            Show <i class="fa-solid fa-eye-to-square"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group mr-2">
                                                        <a href="{{route('scheme.edit',$scheme['id'])}}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                                            Edit <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group mr-2">
                                                        <form method="post" action="{{route('scheme.destroy',$scheme['id'])}}">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                Delete <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                   
                                                </div>  
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('scripts')
    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        /*================================
                            datatable active
                            ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: false
            });
        }
    </script>
@endsection
