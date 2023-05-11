@extends('backend.layouts.master')

@section('title')
    Training - Admin Panel
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Training Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('training.index') }}">All Training</a></li>
                    <li><span>Create Training</span></li>
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
                                    <a href="{{route('training.edit',$training['id'])}}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                        Edit <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <div class="btn-group mr-2">
                                    <form method="post" action="{{route('training.destroy',$training['id'])}}">
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
                                <div class="row">
                                    <div class="col-6">
                                        {{'Name'}}
                                    </div>
                                    <div class="col-6">
                                        {{$training->name ?? ''}}
                                    </div>
                                </div>
                            </div>
                            {{-- all_state --}}
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Cover Image'}}
                                    </div>
                                    <div class="col-6">
                                        {{$training->cover_image ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Video Type'}}
                                    </div>
                                    <div class="col-6">
                                        {{$training->video_type ?? ''}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'Video Link'}}
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $videoLink = $training->video_link ?? $training->live_link ?? '';
                                        @endphp
                                        <a href="{{$videoLink}}">{{$videoLink}}</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="row py-3">                                    
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'State Name'}}
                                    </div>
                                    <div class="col-6">
                                        @php
                                            $stateName =  $training->state_id != 0 &&  !is_null($training->state_id) ?  App\Models\State::whereId($training->state_id)->value('name') : 'All State';
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
                                            $districtName =  $training->district_id != 0 && ! is_null($training->district_id) ? App\Models\District::whereId($training->district_id)->value('name'): 'All District';
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
                                            $panchayatName =  $training->state_id != 0 &&  !is_null($training->state_id) ?  App\Models\Panchayat::whereId($training->municipality_id)->value('name') : 'All State';
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
                                        {{$training->status ?? ''}}
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