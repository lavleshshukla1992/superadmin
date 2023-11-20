@extends('backend.layouts.master')

@section('title')
    Notice - Admin Panel
@endsection
@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Notice Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('notice.index') }}">All Notice</a></li>
                    <li><span>Detail Notice</span></li>
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
                    <div class="form-group">
                        <div class="row py-3 justify-content-end">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="btn-group mr-2">
                                    <a href="{{route('notice.edit',$notice['id'])}}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                        Edit <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <div class="btn-group mr-2">
                                    <form method="post" action="{{route('notice.destroy',$notice['id'])}}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-outline-danger btn-sm">
                                            Delete <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                               
                            </div> 
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Name'}}
                                    </div>
                                    <div class="col-6">
                                        {{$notice->name ?? ''}}
                                    </div>
                                </div>
                            </div>
                            {{-- all_state --}}
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Media'}}
                                    </div>
                                    <div class="col-6">
                                        @if (isset($notice->notice_image) && file_exists(public_path('uploads/' . $notice->notice_image)))
                                            <a download="{{$notice->notice_image}}" href="/uploads/{{$notice->notice_image}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $notice->notice_image }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3" >
                            <div class="col-md-6">
                                <div class="row pb-4">
                                    <div class="col-6">
                                        {{'Description'}}
                                    </div>
                                    <div class="col-6">
                                        {{$notice->description ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{'Audiance'}}
                        <hr class="mt-0">
                        <div class="row py-3">                                    
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'State Name'}}
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $stateName =  $notice->state_id != 0 &&  !is_null($notice->state_id) ?  App\Models\State::whereId($notice->state_id)->value('name') : 'All State';
                                        @endphp
                                        {{$stateName}}
                                    </div>
                                </div>                   
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'District Name'}}
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $districtName =  $notice->district_id != 0 && ! is_null($notice->district_id) ? App\Models\District::whereId($notice->district_id)->value('name'): 'All District';
                                        @endphp
                                        {{$districtName}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Panchayat Name'}}
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $panchayatName =  $notice->state_id != 0 &&  !is_null($notice->state_id) ?  App\Models\Panchayat::whereId($notice->municipality_id)->value('name') : 'All State';
                                        @endphp
                                        {{$panchayatName}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Status'}}
                                    </div>
                                    <div class="col-6">
                                        {{$notice->status ?? ''}}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="2%">Sr. No</th>
                                    <th width="5%">Name</th>
                                    <th width="3%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $key=> $member)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $member['vendor_first_name'] }}</td>
                                        <td>{{ $member['status'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewButtons = document.querySelectorAll('.preview-button');
        
        previewButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const fileName = this.dataset.file;
                const fileUrl = '/uploads/' + fileName;
                const popupWindow = window.open(fileUrl, 'File Preview', 'width=800,height=600');
                popupWindow.focus();
            });
        });
    });
</script>
@endsection