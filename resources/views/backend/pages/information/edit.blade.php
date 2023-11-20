@extends('backend.layouts.master')

@section('title')
    Information Create - Admin Panel
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
    
    .checkbox-columns {
    height: 100px;
    overflow: auto;
}
.checkbox-column label {
    font-weight:500;
}
    </style>

@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Information Edit</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('information.index') }}">All Information</a></li>
                        <li><span>Edit Information</span></li>
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
                        {!! Form::model($information,['route'=>['information.update',$information],'method'=>'PATCH', 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Manage Information</h4>

                                </div>
                                <div class="col-md-6">
                                    <a href="/admin/information" type="btn" class="btn btn-warning" style="float: right; margin-left: 10px;">Cancel</a>
                                    {!! Form::button ('Submit', ['class'=>'btn btn-primary float-right' , 'type'=>'submit']) !!}
                                </div>
                            </div>
                            @include('backend.layouts.partials.messages')
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        {!! Form::hidden('info_id', $info_id) !!}
                                        {!! Form::label('cover_image', 'Cover Image') !!}
                                        {!! Form::file('cover_image', ['class' => 'form-control']) !!}

                                        @if(!empty($info_id))
                                        <img style="margin: 10px;" src="/uploads/{{$cover_image}}" width="10%">    
                                        @endif

                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('title', 'Information Title') !!}
                                        {!! Form::text('title', null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('description', 'Description') !!}
                                        {!! Form::textarea('description', null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('information_link', 'Information Link') !!}
                                        {!! Form::text('information_link', null , ['class'=>'form-control']) !!}
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