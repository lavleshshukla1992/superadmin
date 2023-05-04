@extends('backend.layouts.master')

@section('title')
    Training Create - Admin Panel
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
    $state = ['' => 'Select State']+$state;
@endphp
@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Training Create</h4>
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
                        {!! Form::model($training,['route'=>['training.update',$training],'method'=>'post']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Manage Training</h4>

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
                                    {{-- all_state --}}
                                    <div class="col-md-6">
                                        @php
                                            $allState = $training->all_state ? true :false;
                                        @endphp
                                        {!! Form::label('all_state', 'All State') !!}
                                        {!! Form::checkbox('all_state', null ,$allState) !!}
                                        {!! Form::hidden('all_state', 0 , ['class'=>'form-control']) !!}

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('state_id', 'State Name') !!}
                                        {!! Form::select('state_id',$state, null , ['class'=>'form-control']) !!}
                                    </div>
                                    
                                    <div class="col-md-6">
                                        {!! Form::label('district_id', 'District Name') !!}
                                        {!! Form::select('district_id',[], null , ['class'=>'form-control']) !!}
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('municipality_id', 'Panchayat Name') !!}
                                        {!! Form::select('municipality_id',[], null , ['class'=>'form-control']) !!}
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
@section('scripts')

    <script>
        var allState = {{$allState}};
        $(function() {
            setPanchayat();
            setDistrict();

            console.log("on load called ..................");
            
        });
        $("#state_id").on("change",function(){           
            setPanchayat();
            setDistrict();
        });

        function setDistrict() {
            var stateId = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/admin/districts-list',
                type: 'POST',
                data: {
                    state:stateId
                },
                success: function (response) { 
                    var options = "<option value=''> Select State</option>";
                    for (const key in response) {
                        if (response.hasOwnProperty.call(response, key)) {
                            const element = response[key];
                            options += "<option value='"+key+"'>"+element+"</option>";
                            
                        }
                    }
                    $("#district_id").empty().append(options);
                }
            }); 
        }

        function setPanchayat() {
            
            var stateId = $("#state_id").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/admin/panchayat-list',
                type: 'POST',
                data: {
                    state:stateId
                },
                success: function (response) { 
                    var options = "<option value=''> Select State</option>";
                    for (const key in response) {
                        if (response.hasOwnProperty.call(response, key)) {
                            const element = response[key];
                            options += "<option value='"+key+"'>"+element+"</option>";
                            
                        }
                    }
                    $("#municipality_id").empty().append(options);
                }
            }); 
        }

        if (allState) 
        {
            $("#district_id").attr("disabled",true);
            $("#state_id").attr("disabled",true);
            $("#municipality_id").attr("disabled",true);
        }
        $("#all_state").on("click",function(){
            if ($(this).prop("checked")) 
            {
                $("#district_id").attr("disabled",true);
                $("#state_id").attr("disabled",true);
                $("#municipality_id").attr("disabled",true);
            }
            else{
                $("#district_id").removeAttr("disabled",'true');
                $("#state_id").removeAttr("disabled",'true');
                $("#municipality_id").removeAttr("disabled",'true');

            }
        });
    </script>
@endsection
