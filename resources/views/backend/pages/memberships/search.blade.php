@extends('backend.layouts.master')

@section('title')
    Membership Create - Admin Panel
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

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" type="text/css"href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Membership Search</h4>
                </div>
            </div>
            <div class="col-sm-6 clearfix">
                @include('backend.layouts.partials.logout')
            </div>
        </div>
    </div>
    <!-- page title area end -->
    @php
    $state = App\Models\State::pluck('name','id')->toArray();
    $state = ['0' => 'All State']+$state;

    $vending = App\Models\Vending::pluck('name','id')->toArray();
    $vending = ['0' => 'All Vending']+$vending;

    $marketplace = App\Models\MarketPlace::pluck('name','id')->toArray();
    $marketplace = ['0' => 'All MarketPlace']+$marketplace;
    @endphp
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route'=>'membership-search','method'=>'post']) !!}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', null , ['class'=>'form-control search-fields']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::label('age', 'Age') !!}
                                        {!! Form::number('age', null , ['class'=>'form-control search-fields ']) !!}
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::label('gender', 'Gender') !!}
                                        <div class="checkbox-columns search-fields" id="gender">
                                            @foreach(['0' => 'All Gender','male' => 'Male', 'female'=>'Female', 'other'=>'Other'] as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="gender[]" id="{{ $key }}" value="{{ $key }}" {{ (!empty($memeberships->gender) && in_array($key, explode(",", $memeberships->gender))) ? 'checked' : '' }}>
                                                    <label for="{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('social_category', 'Social Sategory') !!}
                                        <div class="checkbox-columns" id="social_category">
                                            @foreach(['0' => 'All Social Category','Gen' => 'Gen', "SC" => "SC", "ST" => "ST" , "OBC" => "OBC"] as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="social_category[]" id="{{ $key }}" value="{{ $key }}" {{  (!empty($memeberships->social_category) && in_array($key, explode(",", $memeberships->social_category))) ? 'checked' : '' }}>
                                                    <label for="{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        {!! Form::label('marital_status', 'Marital Status') !!}
                                        <div class="checkbox-columns" id="social_category">
                                            @foreach(['0' => 'All',"no"=>"Unmarried","yes"=>"Married"] as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="marital_status[]" id="{{ $key }}" value="{{ $key }}" {{  (!empty($memeberships->marital_status) && in_array($key, explode(",", $memeberships->marital_status))) ? 'checked' : '' }}>
                                                    <label for="{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        {!! Form::label('education_qualification', 'Education Qualification') !!}
                                        <div class="checkbox-columns" id="education_qualification">
                                            @foreach(['0' => 'All Educational Qualification','SSC'=>'SSC','High School' => 'High School','Uneducated' => 'Uneducated','Graduate' => 'Graduate','Post Graduate' => 'Post Graduate'] as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="education_qualification[]" id="{{ $key }}" value="{{ $key }}" {{  (!empty($memeberships->education_qualification) && in_array($key, explode(",", $memeberships->education_qualification))) ? 'checked' : '' }}>
                                                    <label for="{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('type_of_vending', 'Vending Type') !!}
                                        <div class="checkbox-columns" id="type_of_vending">
                                            @foreach($vending as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="type_of_vending[]" id="{{ $key }}" value="{{ $key }}" {{  (!empty($memeberships->type_of_vending) && in_array($key, explode(",", $memeberships->type_of_vending))) ? 'checked' : '' }}>
                                                    <label for="{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        {!! Form::label('type_of_marketplace', 'Marketplace Type') !!}
                                        <div class="checkbox-columns  search-fields" id="type_of_marketplace">
                                            @foreach($marketplace as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="type_of_marketplace[]" id="type_of_marketplace{{ $key }}" value="{{ $key }}" {{  (!empty($memeberships->type_of_marketplace) && in_array($key, explode(",", $memeberships->type_of_marketplace))) ? 'checked' : '' }}>
                                                    <label for="type_of_marketplace{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        {!! Form::label('total_years', 'Total Years Of Business') !!}
                                        {!! Form::number('total_years', null , ['class'=>'form-control search-fields ']) !!}
                                    </div>
                                    
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('current_state', 'State') !!}
                                        <div class="checkbox-columns" id="current_state">
                                            @foreach($state as $key=>$result)
                                                <div class="checkbox-column">
                                                    <input type="checkbox" name="current_state[]" id="current_state{{ $key }}" value="{{ $key }}" {{ (!empty($memeberships->current_state) && in_array($key, explode(",", $memeberships->current_state))) ? 'checked' : '' }}>
                                                    <label for="current_state{{ $key }}">{{ $result }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        {!! Form::label('current_district', 'District') !!}
                                        <div class="checkbox-columns" id="current_district">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        {!! Form::label('municipality_panchayat_current', 'Municipality') !!}
                                        <div class="checkbox-columns" id="municipality_panchayat_current">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-md-4 pt-3">
                                        {!! Form::button('Search',['class'=>'form-control float-right btn btn-warning','id'=>'searchButton','type' => 'submit']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <table id="dataTable" class="text-center w-100">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="2%">Sr. No</th>
                                        <th width="3%">Name </th>
                                        <th width="5%">Membership Id </th>
                                        <th width="5%">State </th>
                                        <th width="5%">DOJ</th>
                                        <th width="5%">Vending Type</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($memeberships))
                                        @foreach ($memeberships as $key=> $memebership)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $memebership['name'] }}</td>
                                                <td>{{ $memebership['membership_id'] }}</td>
                                                <td>{{ $memebership['state'] }}</td>
                                                <td>{{ $memebership['created_at'] }}</td>
                                                <td>{{ $memebership['vending_type'] }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <div class="btn-group mr-2">
                                                            <a href="{{ route('member-details', ['id' => $memebership['id']]) }}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                                                Show  <i class="fa-solid fa-eye-to-square"></i>
                                                            </a>
                                                        </div>       
                                                    </div>  
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>  
        </div>
    </div>
    

    <script src="{{ asset('backend/assets/js/vendor/jquery-2.2.4.min.js')}}"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>

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
                    state:stateId
                },
                success: function(response) {
                    response['0'] = 'All Panchayat';
                    $('#municipality_panchayat_current').empty();
                    var municipality = "<?= $memeberships->municipality_panchayat_current??'' ?>";
                    var municipalityArray = municipality.split(',');
                    $.each(response, function(key, value) {
                        var checkbox = '<div class="checkbox-column">';
                        if (municipalityArray.includes(key)) {
                            checkbox += '<input type="checkbox" name="municipality_panchayat_current[]" id="municipality_panchayat_current' + key + '" value="' + key + '" checked> ';
                        }else{
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
        $(document).on('change','#current_state input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#current_state input[type="checkbox"]');
            }
            var selectedStates = $('#current_state input[type="checkbox"]:checked');
            if (selectedStates.length > 1 || selectedStates.length < 1 ) {
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
                    data: { state: stateId },
                    success: function(response) {
                        response['0'] = 'All District';
                        $('#current_district').empty();
                        var district = "<?= $memeberships->current_district??'' ?>";
                        var districtArray = district.split(',');
                        $.each(response, function(key, value) {
                            var checkbox = '<div class="checkbox-column">';
                            if (districtArray.includes(key)) {
                                checkbox += '<input type="checkbox" name="current_district[]" id="current_district' + key + '" value="' + key + '" checked> ';
                            }else{
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

        $(document).on('change','#current_district input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#current_district input[type="checkbox"]');
            }
            setPanchayat();
        });
        $(document).on('change','#municipality_panchayat_current input[type="checkbox"]',function(){
            if($(this).val()==0){
                toggleAllchecked(this,'#municipality_panchayat_current input[type="checkbox"]');
            }
        });
</script>

    <script>

        $(document).on('click','#searchButton',function(){
            var serachedFields = [];
            $('.search-fields').each(function(i, obj) {
                var name = obj.name;
                var value = $(this).val();
               if (typeof value != 'undefiled' && value.length > 0) 
               {
                    serachedFields[name] = value;
               }
            });
        });


        $("#current_state").on("change",function(){
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
                    var options = "<option value=''> Select </option>";
                    for (const key in response) {
                        if (response.hasOwnProperty.call(response, key)) {
                            const element = response[key];
                            options += "<option value='"+key+"'>"+element+"</option>";
                            
                        }
                    }
                    $("#current_district").empty().append(options);
                    setPanchayat();
                }
            }); 
        });
        
        function setPanchayat() {
            
            var stateId = $("#state").val();
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
                    var options = "<option value=''> Select </option>";
                    for (const key in response) {
                        if (response.hasOwnProperty.call(response, key)) {
                            const element = response[key];
                            options += "<option value='"+key+"'>"+element+"</option>";
                            
                        }
                    }
                    $("#municipality_panchayat_current").empty().append(options);
                }
            }); 
        }

        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true,
                width:"100%",
                dom: 'Bfrtip', // Add buttons
                buttons: [
                    'csv'
                ],
            });
        }

    </script>
@endsection
