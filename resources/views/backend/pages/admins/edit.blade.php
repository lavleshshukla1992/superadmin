@extends('backend.layouts.master')

@section('title')
Admin Edit - Admin Panel
@endsection
@php
$state = App\Models\State::pluck('name','id')->toArray();
$state = ['0' => 'All State']+$state;
//echo"<pre>";print_r($admin);die;
@endphp
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
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
        font-weight: 500;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Admin Edit</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.admins.index') }}">All Admins</a></li>
                    <li><span>Edit Admin - {{ $admin->name }}</span></li>
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
                    <h4 class="header-title">Edit Admin - {{ $admin->name }}</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Admin First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Name" value="{{ $admin->first_name }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="last_name">Admin Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{ $admin->last_name }}">
                            </div>
                            {{-- <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Admin Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $admin->email }}">
                        </div> --}}
                </div>
                <div class="form-row">

                    <div class="form-group col-md-6 col-sm-12">
                        <label for="email">Admin Mobile No</label>
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No" value="{{ $admin->mobile_no }}">
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="email">Admin Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $admin->email }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="password">Assign Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="username">Admin Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $admin->username }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-6">
                        @if (file_exists(public_path('uploads/' . $admin->profile_image['name'])))
                            <img src="{{$admin->profile_image['url']}}" alt="" width="200px" height="200px">
                        @endif
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" placeholder="Enter Password">
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        @if (file_exists(public_path('uploads/' . $admin->identity_image['name'])))
                            <img src="{{$admin->identity_image['url']}}" alt="" width="200px" height="200px">
                        @endif
                        <label for="identity_image">Identity Image</label>
                        <input type="file" class="form-control" id="identity_image" name="identity_image" placeholder="Enter Password">
                    </div>
                </div>
                <hr class="mt-0">

                <div class="row py-4">
                    <div class="col-md-6 assign_demography">
                        {!! Form::label('assign_demography', 'Select Demography') !!}
                        <div class="checkbox-container">
                            <label class="checkbox-label">
                                <input class="demography-checkbox" name="assign_demography" type="radio" value="1" id="assign_demography_yes" {{ $admin->assign_demography == 1 ? 'checked' : '' }}> Yes
                            </label>
                            <label class="checkbox-label">
                                <input class="demography-checkbox" name="assign_demography" type="radio" value="0" id="assign_demography_no" {{ $admin->assign_demography == 0 ? 'checked' : '' }}> No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="demography-fields">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::label('state', 'State Name') !!}
                            <div class="checkbox-columns" id="current_state">
                                @foreach($state as $key=>$result)
                                <div class="checkbox-column">
                                    <input type="checkbox" name="current_state[]" id="current_state{{ $key }}" value="{{ $key }}" {{ (in_array($key, explode(",", $admin->current_state))) ? 'checked' : '' }}>
                                    <label for="current_state{{ $key }}">{{ $result }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::label('current_district', 'District Name') !!}
                            <div class="checkbox-columns" id="current_district">
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('municipality_panchayat_current', 'Panchayat Name') !!}

                            <div class="checkbox-columns" id="municipality_panchayat_current">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Admin</button>
                </form>
            </div>
        </div>
    </div>
    <!-- data table end -->

</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>

<script>
    function setPanchayat() {
        var selecteddistricts = $('#current_district input[type="checkbox"]:checked');
        var selectedStates = $('#current_state input[type="checkbox"]:checked');
        if (selecteddistricts.length > 1) {
            $('#municipality_panchayat_current').empty();
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
                    state: stateId
                },
                success: function(response) {
                    response['0'] = 'All Panchayat';
                    $('#municipality_panchayat_current').empty();
                    var municipality = "<?= $admin->municipality_panchayat_current ?>";
                    var municipalityArray = municipality.split(',');
                    $.each(response, function(key, value) {
                        var checkbox = '<div class="checkbox-column">';
                        if (municipalityArray.includes(key)) {
                            checkbox += '<input type="checkbox" name="municipality_panchayat_current[]" id="municipality_panchayat_current' + key + '" value="' + key + '" checked> ';
                        } else {
                            checkbox += '<input type="checkbox" name="municipality_panchayat_current[]" id="municipality_panchayat_current' + key + '" value="' + key + '"> ';
                        }
                        checkbox += '<label for="municipality_panchayat_current' + key + '"> ' + value + '</label>';
                        checkbox += '</div>';
                        $('#municipality_panchayat_current').append(checkbox);
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
            if ($(this).val() == '0' || $(this).val() == 0) {
                $('.demography-fields').hide();
            } else {
                $('.demography-fields').show();
            }
        });
        $('.assign_demography input[type="radio"]:checked').trigger("change");
        // var select_demography = "<?= $admin->assign_demography ?>";
        // if(select_demography==0){
        //     $('.demography-fields').hide();
        // } else {
        //     $('.demography-fields').show();
        // }
    });
</script>
<script>
    $(document).ready(function() {
        function toggleAllchecked(checkbox, field) {
            $(field).prop('checked', checkbox.checked);
        }
        $(document).on('change', '#current_state input[type="checkbox"]', function() {
            if ($(this).val() == 0) {
                toggleAllchecked(this, '#current_state input[type="checkbox"]');
            }
            var selectedStates = $('#current_state input[type="checkbox"]:checked');
            if (selectedStates.length > 1 || selectedStates.length < 1) {
                $('#current_district').empty();
                $('#municipality_panchayat_current').empty();
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
                    data: {
                        state: stateId
                    },
                    success: function(response) {
                        response['0'] = 'All District';
                        $('#current_district').empty();
                        var district = "<?= $admin->current_district ?>";
                        var districtArray = district.split(',');
                        $.each(response, function(key, value) {
                            var checkbox = '<div class="checkbox-column">';
                            if (districtArray.includes(key)) {
                                checkbox += '<input type="checkbox" name="current_district[]" id="current_district' + key + '" value="' + key + '" checked> ';
                            } else {
                                checkbox += '<input type="checkbox" name="current_district[]" id="current_district' + key + '" value="' + key + '"> ';
                            }
                            checkbox += '<label for="current_district' + key + '"> ' + value + '</label>';
                            checkbox += '</div>';
                            $('#current_district').append(checkbox);
                        });
                        setPanchayat();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
        $('#current_state input[type="checkbox"]:checked').trigger("change");

        $(document).on('change', '#current_district input[type="checkbox"]', function() {
            if ($(this).val() == 0) {
                toggleAllchecked(this, '#current_district input[type="checkbox"]');
            }
            setPanchayat();
        });
        $(document).on('change', '#municipality_panchayat_current input[type="checkbox"]', function() {
            if ($(this).val() == 0) {
                toggleAllchecked(this, '#municipality_panchayat_current input[type="checkbox"]');
            }
        });
    });
</script>
@endsection