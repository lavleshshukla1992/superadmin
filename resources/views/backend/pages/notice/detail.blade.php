@extends('backend.layouts.master')

@section('title')
    Notice - Admin Panel
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
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
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
                                        {{$notice->media ?? ''}}
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
</div>
@endsection