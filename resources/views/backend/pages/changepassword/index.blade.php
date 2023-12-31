@extends('backend.layouts.master')

@section('title')
    Country Create - Admin Panel
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


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Change Password</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>Change Password</span></li>
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
                        {!! Form::open(['route'=>'admin.ChangePassword','method'=>'post']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Change Password</h4>

                                </div>
                                <div class="col-md-6">
                                    {!! Form::button ('Update', ['class'=>'btn btn-primary float-right' , 'type'=>'submit']) !!}
                                </div>
                            </div>
                            @include('backend.layouts.partials.messages')

                            {{-- <form action="{{ route('admin.ChangePassword') }}" method="POST" enctype="multipart/form-data"> --}}
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('current_password', 'Current Password') !!}
                                        {!! Form::password('current_password', ['required' => 'required', 'class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('new_password', 'New Password') !!}
                                        {!! Form::password('new_password', ['required' => 'required', 'class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('confirm_password', 'Confirm Password') !!}
                                        {!! Form::password('confirm_password', ['required' => 'required', 'class'=>'form-control']) !!}
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
@section('scripts')

@endsection
