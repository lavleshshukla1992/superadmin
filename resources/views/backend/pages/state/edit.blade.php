@extends('backend.layouts.master')

@section('title')
    State Create - Admin Panel
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
                    <h4 class="page-title pull-left">State Create</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('state.index') }}">All States</a></li>
                        <li><span>Create State</span></li>
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
                        {!! Form::model($state,['route'=>['state.update',$state],'method'=>'put']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Manage State</h4>

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
                                        {!! Form::label('country_id', 'Name') !!}
                                        {!! Form::select('country_id',App\Models\Country::pluck('name','id'), null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', null , ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
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
@section('scripts')

    <script>

        $('#phonecode').on('focusout',function(){
            if (typeof $(this).val() == 'string') {
                $(this).val($(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '').substring(0,10));
            }
            console.log("called ",typeof $(this).val() , $(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '').substring(0,10));
        });
    </script>
@endsection
