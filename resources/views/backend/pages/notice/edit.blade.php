@extends('backend.layouts.master')

@section('title')
    Notice Create - Admin Panel
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        a.btn.btn-danger.text-white.deletebtn {
            margin-top: 15px;
        }
    </style>
@endsection
@php
    $state = App\Models\State::pluck('name','id')->toArray();
    $state = ['0' => 'All State']+$state;
@endphp 
@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Notice Create</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('notice.index') }}">All Notice</a></li>
                        <li><span>Create Notice</span></li>
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
                        {!! Form::model($notice,['route'=>['notice.update',$notice],'method'=>'PATCH']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Manage Notice</h4>

                                </div>
                                <div class="col-md-6">
                                    {!! Form::button ('Submit', ['class'=>'btn btn-primary float-right' , 'type'=>'submit']) !!}
                                </div>
                            </div>
                            @include('backend.layouts.partials.messages')

                            {{-- <form action="{{ route('country.store') }}" method="POST" enctype="multipart/form-data"> --}}
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('media', 'Media') !!}
                                        {!! Form::file('media', ['class' => 'form-control']) !!}
                                    </div>
                                    {{-- <div class="col-md-6">
                                        {!! Form::label('status', 'Status') !!}
                                        {!! Form::select('status',['Active' => 'Active', 'In Active'=>'In Active'], null , ['class'=>'form-control ']) !!}
                                    </div> --}}
                                    
                                </div>
                                <div class="row py-4">
                                    <div class="col-md-12">
                                        {!! Form::label('description', 'Description') !!}
                                        {!! Form::textarea('description', null , ['class'=>'form-control', 'rows' => '4']) !!}

                                    </div>
                                    
                                </div>

                                <span class=""> {{'Select Audiance'}} </span>
                                <hr class="mt-0">

                                <div class="row">                                    
                                    <div class="col-md-6">
                                        {!! Form::label('state_id', 'State Name') !!}
                                        {!! Form::select('state_id',$state, null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('district_id', 'District Name') !!}
                                        {!! Form::select('district_id',['0' => 'All District'], null , ['class'=>'form-control']) !!}
                                    </div>

                                </div>
                                <div class="row">
                                   
                                    <div class="col-md-6">
                                        {!! Form::label('municipality_id', 'Panchayat Name') !!}
                                        {!! Form::select('municipality_id',['0' => 'All Panchayat'], null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('status', 'Status') !!}
                                        {!! Form::select('status',['Active' => 'Active', 'In Active'=>'In Active'], null , ['class'=>'form-control ']) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection
