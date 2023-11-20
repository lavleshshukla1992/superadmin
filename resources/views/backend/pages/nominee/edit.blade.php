@extends('backend.layouts.master')

@section('title')
    Add Nominee - Admin Panel
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
@endsection

@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Add Nominee</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>Add Nominee</span></li>
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
                        {!! Form::model($nominee,['route'=>['update-nominee-details',1],'method'=>'POST']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Manage Scheme</h4>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('member-detail', ['id' => $memebership_id]) }}" type="btn" class="btn btn-warning" style="float: right; margin-left: 10px;">Cancel</a>
                                    {!! Form::button ('Submit', ['class'=>'btn btn-primary float-right' , 'type'=>'submit']) !!}
                                </div>
                            </div>
                            @include('backend.layouts.partials.messages')

                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{ Form::hidden('member_id', $vendor_id) }}
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name[]', $name1 , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('type', 'Relationship Type') !!}
                                        {!! Form::select('type[]', $type, $field1, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::text('name[]', $name2 , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::select('type[]', $type, $field2, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::text('name[]', $name3 , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::select('type[]', $type, $field3, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::text('name[]', $name4 , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::select('type[]', $type, $field4, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::text('name[]', $name5 , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::select('type[]', $type, $field5, ['class' => 'form-control']) !!}
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