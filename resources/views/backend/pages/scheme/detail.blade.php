@extends('backend.layouts.master')

@section('title')
    Scheme - Admin Panel
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Scheme Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('scheme.index') }}">All Scheme</a></li>
                    <li><span>Detail Scheme</span></li>
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
                                    <a href="{{route('scheme.edit',$scheme['id'])}}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                        Edit <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <div class="btn-group mr-2">
                                    <form method="post" action="{{route('scheme.destroy',$scheme['id'])}}">
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
                                        {{$scheme->name ?? ''}}
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
                                        {{$scheme->media ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Start Date'}}
                                    </div>
                                    <div class="col-6">
                                        {{date('d-M-Y',strtotime($scheme->start_at)) ?? ''}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'End Date'}}
                                    </div>
                                    <div class="col-6">
                                        {{date('d-M-Y',strtotime($scheme->end_at)) ?? ''}}
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
                                        {{$scheme->description ?? ''}}
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
                                            $stateName =  $scheme->state_id != 0 &&  !is_null($scheme->state_id) ?  App\Models\State::whereId($scheme->state_id)->value('name') : 'All State';
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
                                            $districtName =  $scheme->district_id != 0 && ! is_null($scheme->district_id) ? App\Models\District::whereId($scheme->district_id)->value('name'): 'All District';
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
                                            $panchayatName =  $scheme->state_id != 0 &&  !is_null($scheme->state_id) ?  App\Models\Panchayat::whereId($scheme->municipality_id)->value('name') : 'All State';
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
                                        {{$scheme->status ?? ''}}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Scheme Image'}}
                                    </div>
                                    <div class="col-6">
                                        @if (isset($scheme->scheme_image) && file_exists(public_path('uploads/' . $scheme->scheme_image)))
                                            <a download="{{$scheme->scheme_image}}" href="/uploads/{{$scheme->scheme_image}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $scheme->scheme_image }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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