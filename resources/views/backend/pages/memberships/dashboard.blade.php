@extends('backend.layouts.master')

@section('title')
Membership Dashboard
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="main-content-inner">
    {!! Form::open(['route'=>'membership-dashboard','method'=>'post']) !!}
    <div class="row pt-3 justify-content-center">
        <div class="col-5">
            {!! Form::label('from_date', 'From Date') !!}
            {!! Form::date('from_date', $fromDate ?? null , ['class'=>'form-control']) !!}
        </div>
        <div class="col-5">
            {!! Form::label('to_date', 'To Date') !!}
            {!! Form::date('to_date', $toDate ?? null , ['class'=>'form-control']) !!}
        </div>
        <div class="col-2">
            {!! Form::button ('Filter', ['class'=>'btn btn-primary float-right' , 'type'=>'submit']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <div class="row pt-3">
        <div class="col-2">
        {!! Form::open(['route'=>'membership-dashboard','method'=>'post']) !!}
            {!! Form::hidden('filter', 'today') !!}
            {!! Form::button ('Today', ['class'=>'btn btn-primary' , 'type'=>'submit']) !!}
        {!! Form::close() !!}
        </div>
        <div class="col-2">
        {!! Form::open(['route'=>'membership-dashboard','method'=>'post']) !!}
            {!! Form::hidden('filter', 'this_month') !!}
            {!! Form::button ('Current Month', ['class'=>'btn btn-primary' , 'type'=>'submit']) !!}
        {!! Form::close() !!}
        </div>
        <div class="col-2">
        {!! Form::open(['route'=>'membership-dashboard','method'=>'post']) !!}
            {!! Form::hidden('filter', 'last_month') !!}
            {!! Form::button ('Last Month', ['class'=>'btn btn-primary' , 'type'=>'submit']) !!}
        {!! Form::close() !!}
        </div>
    </div>

    <div class="row pt-3">

        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <h3>
                        Total user Joined
                    </h3>
                    <canvas id="barChart"></canvas>
                    @php
                    $label = $memberJoinedDateWise['label'] ?? "[]";
                    $joined = $memberJoinedDateWise['joined'] ?? "[]";
                    $left = $memberJoinedDateWise['left'] ?? "[]";

                    @endphp
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center bg-warning">

                        <h3>
                            {{$memberDashboard['total_user'] ?? 0}}
                        </h3>

                    </div>
                    <div class="row justify-content-center bg-warning">
                        <h4>
                            Total User Count
                        </h4>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <h4>
                                {{$memberDashboard['new_user'] ?? 0}}
                            </h4>
                            <h4>
                                Users Joined
                            </h4>

                        </div>

                        <div class="col-6">

                            <h4>
                                {{$memberDashboard['left_user'] ?? 0}}
                            </h4>
                            <h4>
                                User Left
                            </h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <h3>
                        Age Specific
                    </h3>
                    <canvas id="barChartAgeSpecific"></canvas>

                    @php

                    $ageSpecificLabel = $memberAgeSpecifc['label'] ?? "[]";
                    $ageSpecificData = $memberAgeSpecifc['joined'] ?? "[]";
                    $leftvalues = $memberAgeSpecifc['leftvalues'] ?? "[]";

                    @endphp
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="col-7">
                <div class="card" style="width:150% !important;">
                    <div class="card-body">

                        <div class="row">
                            <h3>
                                Gender specific
                            </h3>
                            <canvas id="pieGenderCtagory"></canvas>
                            @php
                            $genderSpecificLabel = $genderSpecific['label'] ?? "[]";
                            $genderSpecificData = $genderSpecific['data'] ?? "[]";
                            @endphp
                        </div>




                        <!-- 
                          <canvas id="barChartGender"></canvas>
                            @php

                                $genderSpecificLabel = $genderSpecific['label'] ?? "[]";
                                $genderSpecificData = $genderSpecific['data'] ?? "[]";

                            @endphp
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h3>
                                Demography
                            </h3>
                            <canvas id="barChartDemography"></canvas>
                            @php

                            $demographySpecificLabel = $demographySpecific['label'] ?? "[]";
                            $demographySpecificData = $demographySpecific['data'] ?? "[]";

                            @endphp
                        </div>
                        <div class="row pt-2">
                            <h3>
                                Marketplace
                            </h3>
                            <canvas id="barChartMarketPlace"></canvas>

                            @php
                            $marketplaceSpecificLabel = $marketplaceSpecific['label']?? "[]";
                            $marketplaceSpecificData = $marketplaceSpecific['data']?? "[]";
                            @endphp
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-5">
                <div class="col-7">
                    <div class="card" style="width:150% !important;">
                        <div class="card-body">
                            <div class="row">
                                <h3>
                                    Social Category
                                </h3>
                                <canvas id="pieSocialCtagory"></canvas>
                                @php
                                $socialCategoryLabel = $socialCategory['label'] ?? "[]";
                                $socialCategoryData = $socialCategory['data'] ?? "[]";
                                @endphp
                            </div>

                            <div class="row">
                                <h3>
                                    Educational Qualification
                                </h3>
                                <canvas id="pieEducationalQualification"></canvas>
                                @php
                                $educationalQualificationLabel = $educationalQualification['label'] ?? "[]";
                                $educationalQualificationData = $educationalQualification['data'] ?? "[]";
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    var label = JSON.parse('<?php echo $label; ?>');
    var joined = JSON.parse('<?php echo $joined; ?>');
    var left = JSON.parse('<?php echo $left; ?>');

    var ageSpecificLabel = JSON.parse('<?php echo $ageSpecificLabel; ?>');
    var ageSpecificData = JSON.parse('<?php echo $ageSpecificData; ?>');
    var leftvalues = JSON.parse('<?php echo $leftvalues; ?>');
    //console.log(ageSpecificLabel);
    //console.log(ageSpecificData);
    var genderSpecificLabel = JSON.parse('<?php echo $genderSpecificLabel; ?>');
    var genderSpecificData = JSON.parse('<?php echo $genderSpecificData; ?>');

    var socialCategoryLabel = JSON.parse('<?php echo $socialCategoryLabel; ?>');
    var socialCategoryData = JSON.parse('<?php echo $socialCategoryData; ?>');

    var marketplaceSpecificLabel = JSON.parse('<?php echo $marketplaceSpecificLabel; ?>');
    var marketplaceSpecificData = JSON.parse('<?php echo $marketplaceSpecificData; ?>');


    var demographySpecificLabel = JSON.parse('<?php echo $demographySpecificLabel; ?>');
    var demographySpecificData = JSON.parse('<?php echo $demographySpecificData; ?>');
    //console.log(demographySpecificData);
    var educationalQualificationLabel = JSON.parse('<?php echo $educationalQualificationLabel; ?>');
    var educationalQualificationData = JSON.parse('<?php echo $educationalQualificationData; ?>');
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<script>
    var ctx = document.getElementById("barChart").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: label,
            datasets: [{
                label: 'Joined',
                data: joined,
                backgroundColor: "rgba(255,193,7,1)"
            }, {
                label: 'Left',
                data: left,
                backgroundColor: "rgba(51,51,51,1)"
            }]
        }
    });

    var ctx = document.getElementById("barChartAgeSpecific").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'bar',
        options: {
            legend: {
                display: false
            }
        },
        data: {
            //labels: ["18-25", "25-32", "32-39", "40 +"],
            labels: ageSpecificLabel,
            datasets: [{
                //data: [12, 19, 3],
                data: ageSpecificData,
                //backgroundColor: ["rgba(255,193,7,1)", "rgba(51,51,51,1)"]
                backgroundColor: "rgba(255,193,7,1)"
            }, {
                label: 'Left',
                data: leftvalues,
                //backgroundColor: ["rgba(255,193,7,1)", "rgba(255,193,7,1)"]
                backgroundColor: "rgba(51,51,51,1)"
            }]
        }
    });

    // var ctx = document.getElementById("barChartGender").getContext('2d');
    // var barChart = new Chart(ctx, {
    //     type: 'horizontalBar',
    //     options: {
    //         legend: {
    //             display: false
    //         }
    //     },
    //     data: {
    //         labels: genderSpecificLabel,
    //         datasets: [{
    //         label: '',
    //         data: genderSpecificData,
    //         backgroundColor: "rgba(255,0,0,1)"
    //         }]
    //     }
    // });

    var ctx = document.getElementById("barChartDemography").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'horizontalBar',
        options: {
            legend: {
                display: false
            }
        },
        data: {
            labels: demographySpecificLabel,
            datasets: [{
                label: '',
                data: demographySpecificData,
                backgroundColor: "rgba(255,0,0,1)"
            }, {
                label: 'Left',
                data: leftvalues,
                //backgroundColor: ["rgba(255,193,7,1)", "rgba(255,193,7,1)"]
                backgroundColor: "rgba(51,51,51,1)"
            }]
        }
    });

    var ctx = document.getElementById("barChartMarketPlace").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'horizontalBar',
        options: {
            legend: {
                display: false
            }
        },
        data: {
            labels: marketplaceSpecificLabel,
            datasets: [{
                label: '',
                data: marketplaceSpecificData,
                backgroundColor: "rgba(255,0,0,1)"
            }, {
                label: 'Left',
                data: leftvalues,
                //backgroundColor: ["rgba(255,193,7,1)", "rgba(255,193,7,1)"]
                backgroundColor: "rgba(51,51,51,1)"
            }]
        }
    });

    var ctx = document.getElementById("pieSocialCtagory").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: socialCategoryLabel,
            datasets: [{
                label: '',
                data: socialCategoryData,
                backgroundColor: ["#51EAEA", "#FCDDB0", "#FF9D76", "#FB3569", "#82CD47"],
            }]
        }
    });

    var genctx = document.getElementById("pieGenderCtagory").getContext('2d');
    var barChart = new Chart(genctx, {
        type: 'pie',
        data: {
            labels: genderSpecificLabel,
            datasets: [{
                label: '',
                data: genderSpecificData,
                backgroundColor: ["#51EAEA", "#FCDDB0", "#FF9D76", "#FB3569", "#82CD47"],
            }]
        }
    });


    var ctx = document.getElementById("pieEducationalQualification").getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: educationalQualificationLabel,
            datasets: [{
                label: '',
                data: educationalQualificationData,
                backgroundColor: ["#51EAEA", "#FCDDB0", "#FF9D76", "#FB3569", "#82CD47"],
            }]
        }
    });

    // barChartMarketPlace
</script>
@endsection