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
        .checkbox-columns {
    height: 100px;
    overflow: auto;
}
.checkbox-column label {
    font-weight:500;
}
    </style>
@endsection

@php
    $state = App\Models\State::pluck('name','id')->toArray();
    $allState = ['0' => 'All State']+$state;

    $vending = App\Models\Vending::pluck('name','id')->toArray();
    $vending = ['0' => 'All Vending']+$vending;

    $marketplace = App\Models\MarketPlace::pluck('name','id')->toArray();
    $marketplace = ['0' => 'All MarketPlace']+$marketplace;
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
                        {!! Form::open(['route'=>'training.store','method'=>'post', 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Manage Training</h4>

                                </div>
                                <div class="col-md-6">
                                    {!! Form::button ('Start Training', ['class'=>'btn btn-primary float-right' , 'type'=>'submit']) !!}
                                </div>
                            </div>
                            @include('backend.layouts.partials.messages')
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', null , ['class'=>'form-control']) !!}
                                    </div>
                                    {{-- all_state --}}
                                    <div class="col-md-6">
                                        {!! Form::label('cover_image', 'Cover Image') !!}
                                        {!! Form::file('cover_image',['class'=>'form-control']) !!}

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('video_type', 'Insert Video Link') !!}
                                        {!! Form::radio('video_type', 'video' , ['class'=>'form-control']) !!}
                                    </div>
                                    
                                    <div class="col-md-6">
                                        {!! Form::label('video_type', 'Go Live') !!}
                                        {!! Form::radio('video_type', 'Live' , ['class'=>'form-control']) !!}
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('video_link', 'Video Link') !!}
                                        {!! Form::text('video_link', null , ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('live_link', 'Live Link') !!}
                                        {!! Form::text('live_link', null , ['class'=>'form-control ']) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="row py-4">
                                    <div class="col-md-6">
                                        {!! Form::label('select_demography', 'Select Demography') !!}
                                        <div class="checkbox-container">
                                            <label class="checkbox-label">
                                                {!! Form::radio('select_demography', '1', false, ['class' => 'demography-checkbox']) !!} Yes
                                            </label>
                                            <label class="checkbox-label">
                                                {!! Form::radio('select_demography', '0', true, ['class' => 'demography-checkbox']) !!} No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0">

                                <div class="demography-fields">                                    
                                    <div class="row">                                    
                                        <div class="col-md-6">
                                            {!! Form::label('gender', 'Gender') !!}
                                            <div class="checkbox-columns" id="gender">
                                                @foreach(['0' => 'All Gender','male' => 'Male', 'female'=>'Female', 'other'=>'Other'] as $key=>$result)
                                                    <div class="checkbox-column">
                                                        <input type="checkbox" name="gender[]" id="{{ $key }}" value="{{ $key }}">
                                                        <label for="{{ $key }}">{{ $result }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('social_category', 'Social Category') !!}
                                            <div class="checkbox-columns" id="social_category">
                                                @foreach(['0' => 'All Social Category','Sc' => 'SC', 'ST'=>'ST', 'OBC'=>'OBC', 'General'=>'General', 'EWS'=>'EWS', 'Open'=>'Open'] as $key=>$result)
                                                    <div class="checkbox-column">
                                                        <input type="checkbox" name="social_category[]" id="{{ $key }}" value="{{ $key }}">
                                                        <label for="{{ $key }}">{{ $result }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">                                    
                                        <div class="col-md-6">
                                            {!! Form::label('educational_qualification', 'Educational Qualification') !!}
                                            <div class="checkbox-columns" id="educational_qualification">
                                                @foreach(['0' => 'All Educational Qualification','primary_education' => 'Primary Education', 'high_school' => 'High School', 'Intermediate' => 'Intermediate', 'Undergraduate' => 'Undergraduate', 'Postgraduate' => 'Postgraduate'] as $key=>$result)
                                                    <div class="checkbox-column">
                                                        <input type="checkbox" name="educational_qualification[]" id="{{ $key }}" value="{{ $key }}">
                                                        <label for="{{ $key }}">{{ $result }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('type_of_vending', 'Type Of Vending') !!}
                                            <div class="checkbox-columns" id="type_of_vending">
                                                @foreach($vending as $key=>$result)
                                                    <div class="checkbox-column">
                                                        <input type="checkbox" name="type_of_vending[]" id="{{ $key }}" value="{{ $key }}">
                                                        <label for="{{ $key }}">{{ $result }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::label('type_of_marketplace', 'Type Of Marketplace') !!}
                                            <div class="checkbox-columns" id="type_of_marketplace">
                                                @foreach($marketplace as $key=>$result)
                                                    <div class="checkbox-column">
                                                        <input type="checkbox" name="type_of_marketplace[]" id="type_of_marketplace{{ $key }}" value="{{ $key }}">
                                                        <label for="type_of_marketplace{{ $key }}">{{ $result }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>                                
                                        <div class="col-md-6">
                                            {!! Form::label('state', 'State Name') !!}
                                            <div class="checkbox-columns" id="state_id">
                                                @foreach($allState as $key=>$result)
                                                    <div class="checkbox-column">
                                                        <input type="checkbox" name="state_id[]" id="state_id{{ $key }}" value="{{ $key }}">
                                                        <label for="state_id{{ $key }}">{{ $result }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::label('district_id', 'District Name') !!}
                                            <div class="checkbox-columns" id="district_id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('municipality_id', 'Panchayat Name') !!}
                                            <div class="checkbox-columns" id="municipality_id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

<script>
    function setPanchayat() {
        var selecteddistricts = $('#district_id input[type="checkbox"]:checked');
        var selectedStates = $('#state_id input[type="checkbox"]:checked');
        if (selecteddistricts.length > 1) {
            $('#municipality_id').empty();
        } else if (selecteddistricts.length === 1) {
            var stateId = selectedStates.val();
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
                success: function(response) {
                    response['0'] = 'All Panchayat';
                    $('#municipality_id').empty();
                    $.each(response, function(key, value) {
                        var checkbox = '<div class="checkbox-column">';
                        checkbox += '<input type="checkbox" name="municipality_id[]" id="municipality_id' + key + '" value="' + key + '"> ';
                        checkbox += '<label for="municipality_id' + key + '"> ' + value + '</label>';
                        checkbox += '</div>';
                        $('#municipality_id').append(checkbox);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('.demography-checkbox').change(function() {
            if ($(this).val() == '0') {
                $('.demography-fields').hide();
            } else {
                $('.demography-fields').show();
            }
        }).trigger("change");
    });
</script>
<script>
    $(document).ready(function() {
        function toggleAllchecked(checkbox,field) {
            $(field).prop('checked', checkbox.checked);
        }
        $(document).on('change','#type_of_vending input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#type_of_vending input[type="checkbox"]');
            }
        });
        $(document).on('change','#type_of_marketplace input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#type_of_marketplace input[type="checkbox"]');
            }
        });
        $(document).on('change','#gender input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#gender input[type="checkbox"]');
            }
        });
        $(document).on('change','#social_category input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#social_category input[type="checkbox"]');
            }
        });
        $(document).on('change','#educational_qualification input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#educational_qualification input[type="checkbox"]');
            }
        });
        $('#state_id').on('change', 'input[type="checkbox"]', function() {
            if($(this).val()==0){
                toggleAllchecked(this,'#state_id input[type="checkbox"]');
            }
            var selectedStates = $('#state_id input[type="checkbox"]:checked');
            if (selectedStates.length > 1 || selectedStates.length < 1 ) {
                $('#district_id').empty();
                $('#municipality_id').empty();
            } else if (selectedStates.length === 1) {
                var stateId = selectedStates.val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/admin/districts-list',
                    method: 'POST',
                    data: { state: stateId },
                    success: function(response) {
                        response['0'] = 'All District';
                        $('#district_id').empty();
                        $.each(response, function(key, value) {
                            var checkbox = '<div class="checkbox-column">';
                            checkbox += '<input type="checkbox" name="district_id[]" id="district_id' + key + '" value="' + key + '"> ';
                            checkbox += '<label for="district_id' + key + '"> ' + value + '</label>';
                            checkbox += '</div>';
                            $('#district_id').append(checkbox);
                        });
                    setPanchayat();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $(document).on('change','#district_id input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#district_id input[type="checkbox"]');
            }
            setPanchayat();
        });
        $(document).on('change','#municipality_id input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#municipality_id input[type="checkbox"]');
            }
        });
    });
</script>
@endsection
