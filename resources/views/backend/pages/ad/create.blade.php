@extends('backend.layouts.master')

@section('title')
    Ads Create - Admin Panel
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
                    <h4 class="page-title pull-left">Ads Create</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.users.index') }}">All Adss</a></li>
                        <li><span>Create Ads</span></li>
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
                        <h4 class="header-title">Manage Ads</h4>
                        @include('backend.layouts.partials.messages')

                        <form action="{{ route('admin.ad.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <ul class="nav nav-tabs" role="tablist">
                                    @for ($i = 1; $i < $total_ads; $i++)
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#ad{{ $i }}">Ad
                                                {{ $i }}</a>
                                        </li>
                                    @endfor
                                </ul>
                                <div class="tab-content">
                                    @for ($i = 1; $i < $total_ads; $i++)
                                        <div id="ad{{ $i }}" class="tab-pane">
                                            <form id="" action="{{ route('admin.ad.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="ad_type{{ $i }}">Ads Type</label>
                                                    <div>
                                                        <label>
                                                            <input type="radio" class="ad_type"
                                                                onclick="return showHideFields('google','{{ $i }}')"
                                                                name="ads[{{ $i }}][ad_type]"
                                                                id="ad_type[{{ $i }}]" value="1"
                                                                {{ (isset($ads[$i]['ad_type']) && $ads[$i]['ad_type'] == '1') || empty($ads[$i]['ad_type']) ? 'checked' : '' }}>
                                                            Google
                                                            Ads
                                                            <input type="radio" class="ad_type"
                                                                onclick="return showHideFields('private','{{ $i }}')"
                                                                name="ads[{{ $i }}][ad_type]"
                                                                id="ad_type[{{ $i }}]" value="2"
                                                                {{ isset($ads[$i]['ad_type']) && $ads[$i]['ad_type'] == '2' ? 'checked' : '' }}>
                                                            Private
                                                            Ads
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group ad_type_private {{ isset($ads[$i]['ad_type']) && $ads[$i]['ad_type'] == '2' ? '' : 'hide' }}">
                                                    <label for="ad_name{{ $i }}">Advertiser Name</label>
                                                    <input type="text" class="form-control"
                                                        id="ad_name{{ $i }}"
                                                        value="{{ $ads[$i]['ad_name'] ?? '' }}"
                                                        name="ads[{{ $i }}][ad_name]">
                                                </div>
                                                <div
                                                    class="form-group ad_type_google {{ (isset($ads[$i]['ad_type']) && $ads[$i]['ad_type'] == '1') || empty($ads[$i]['ad_type']) ? '' : 'hide' }}">
                                                    <label for="google_script{{ $i }}">Google Script</label>
                                                    <textarea name="ads[{{ $i }}][google_script]" class="form-control" row="5"
                                                        id="google_script{{ $i }}" cols="30" rows="10">{{ $ads[$i]['google_script'] ?? '' }}</textarea>
                                                </div>
                                                <div
                                                    class="form-group ad_type_private {{ isset($ads[$i]['ad_type']) && $ads[$i]['ad_type'] == '2' ? '' : 'hide' }}">
                                                    <label for="ad_media{{ $i }}">Select Media</label>
                                                    <input type="file" class="form-control"
                                                        id="ad_media{{ $i }}"
                                                        value="{{ $ads[$i]['ad_media'] ?? '' }}"
                                                        name="ads[{{ $i }}][ad_media]">
                                                        @if (!empty($ads[$i]['ad_media']))
                                                        <img src="{{ asset('uploads//') }}/{{ $ads[$i]['ad_media'] ?? '' }}" alt="" height="200" width="200">
                                                        @endif
                                                </div>
                                                <div
                                                    class="form-group ad_type_private {{ isset($ads[$i]['ad_type']) && $ads[$i]['ad_type'] == '2' ? '' : 'hide' }}">
                                                    <label for="ad_link{{ $i }}">Insert Link</label>
                                                    <input type="text" class="form-control"
                                                        id="ad_link{{ $i }}"
                                                        value="{{ $ads[$i]['ad_link'] ?? '' }}"
                                                        name="ads[{{ $i }}][ad_link]">
                                                </div>
                                                @csrf
                                                <button type="sbmit" id="savebtn{{ $i }}"
                                                    class="btn btn-primary mt-4 pr-4 pl-4 {{ !empty($ads[$i]['ad_type']) ? 'hide' : ''}} savebtn">SAVE</button>

                                                <a class="btn btn-danger text-white deletebtn hide"
                                                    href="{{ route('admin.ad.destroy', $ads[$i]['id'] ?? '') }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $i }}').submit();">
                                                    DELETE
                                                </a>
                                            </form>

                                            <form id="delete-form-{{ $i }}"
                                                action="{{ route('admin.ad.destroy', $ads[$i]['id'] ?? '') }}"
                                                method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            <button type="button" id="editbtn{{ $i }}"
                                                onclick="return showHideFields('editbtn','{{ $i }}')"
                                                class="btn btn-primary mt-4 pr-4 pl-4 {{ empty($ads[$i]['ad_type']) ? 'hide' : ''}} editbtn">EDIT</button>
                                        </div>
                                    @endfor
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".date").datetimepicker({
                format: 'DD-MMM-YYYY'
            });
            $('.tab-content .tab-pane:first').addClass('active');
            $('.nav-tabs a:first').addClass('active');
            $(".ad_type").click(function() {
                $("#content").toggle();
            });
            @for ($i = 1; $i < $total_ads; $i++)
                @if (!empty($ads[$i]['ad_type']))
                $("#ad{{ $i }} input").prop("disabled", true);
                $("#ad{{ $i }} textatra").prop("disabled", true);
            @else
                $("#ad{{ $i }} input").prop("disabled", false);
                $("#ad{{ $i }} textatra").prop("disabled", false);
            @endif
        @endfor
        });
    </script>
@endsection
<script>
    function showHideFields(ad_type, tab_id) {
        if (ad_type == 'google') {
            $('#ad' + tab_id + ' .ad_type_private').addClass('hide');
            $('#ad' + tab_id + ' .ad_type_google').removeClass('hide');
        }
        if (ad_type == 'private') {
            $('#ad' + tab_id + ' .ad_type_google').addClass('hide');
            $('#ad' + tab_id + ' .ad_type_private').removeClass('hide');
        }
        if (ad_type == 'editbtn') {
            $("#ad" + tab_id + " input").prop("disabled", false);
            $("#ad" + tab_id + " textatra").prop("disabled", false);
            $('#ad' + tab_id + ' .savebtn').removeClass('hide');
            $('#ad' + tab_id + ' .deletebtn').removeClass('hide');
            $('#ad' + tab_id + ' .editbtn').addClass('hide');
        }
    }
</script>
