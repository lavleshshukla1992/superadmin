@extends('backend.layouts.master')

@section('title')
    Member - Admin Panel
@endsection

@section('style')
<style>
    .statusform {
        display: flex !important;
    }
</style>
@endsection

@section('admin-content')
<style>
    .statusform {
        display: flex !important;
    }
    .mt-30{
        margin-top:30px;
    }
</style>
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Member Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('member-verification') }}">All Member</a></li>
                    <li><span>Detail Member</span></li>
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
                    <div class="form-group">
                        <div class="row py-3 justify-content-end">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <div class="btn-group mr-2">
                                    <a href="{{ route('nominee-details', ['id' => $member['id']]) }}" type="btn" class="btn btn-warning"><i class="fa fa-users"></i>&nbsp;&nbsp;Nominee Details</a>&nbsp;&nbsp;
                                    <a href="{{ route('member-pdf', ['id' => $member['id']]) }}" type="btn" class="btn btn-success">Dowload PDF  <i class="fa fa-download"></i> </a>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Name'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['vendor_first_name'] ?? ''}} {{$member['vendor_last_name'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Applied For'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['applied_for'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'State'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['state'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Date'}} :
                                    </div>
                                    <div class="col-6">
                                        {{date('F j, Y, g:i a', strtotime($member['created_at']))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Gender'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['gender'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Status'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['status'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Parent Name'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['parent_first_name'] ?? ''}} {{$member['parent_last_name'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Date Of Birth'}} :
                                    </div>
                                    <div class="col-6">
                                    {{date('F j, Y', strtotime($member['date_of_birth']))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Marital Status'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['marital_status'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Spouse Name'}} :
                                    </div>
                                    <div class="col-6">
                                    {{$member['spouse_name'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Social Category'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['social_category'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Current Address'}} :
                                    </div>
                                    <div class="col-6">
                                    {{$member['current_address'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Mobile No.'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['mobile_no'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Education Qualification'}} :
                                    </div>
                                    <div class="col-6">
                                    {{$member['education_qualification'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Current Pincode'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$member['current_pincode'] ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Profile Image'}} :
                                    </div>
                                    <div class="col-6">
                                        @if (isset($member['profile_image_name']) && file_exists(public_path('uploads/' . $member['profile_image_name'])))
                                            <a download="{{$member['profile_image_name']}}" href="/uploads/{{$member['profile_image_name']}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $member['profile_image_name'] }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Identity Image'}} :
                                    </div>
                                    <div class="col-6">
                                        @if (isset($member['identity_image_name']) && file_exists(public_path('uploads/' . $member['identity_image_name'])))
                                            <a download="{{$member['identity_image_name']}}" href="/uploads/{{$member['identity_image_name']}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $member['identity_image_name'] }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Membership Image'}} :
                                    </div>
                                    <div class="col-6">
                                        @if (isset($member['membership_image']) && file_exists(public_path('uploads/' . $member['membership_image'])))
                                            <a download="{{$member['membership_image']}}" href="/uploads/{{$member['membership_image']}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $member['membership_image'] }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Cover Image'}} :
                                    </div>
                                    <div class="col-6">
                                        @if (isset($member['cov_image']) && file_exists(public_path('uploads/' . $member['cov_image'])))
                                            <a download="{{$member['cov_image']}}" href="/uploads/{{$member['cov_image']}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $member['cov_image'] }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Lor Image'}} :
                                    </div>
                                    <div class="col-6">
                                        @if (isset($member['lor_image']) && file_exists(public_path('uploads/' . $member['lor_image'])))
                                            <a download="{{$member['lor_image']}}" href="/uploads/{{$member['lor_image']}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $member['lor_image'] }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-0">
                        <div class="row">
                            <form method="post" class="statusform" action="{{ route('verification-status') }}">
                                @method('post')
                                @csrf
                                <input type="hidden" name="member_id" value="{{ $member['id'] }}">
                                <input type="hidden" name="user_id" value="{{ $member['user_id'] }}">
                                <div class="col-sm-9">
                                    {!! Form::label('status', 'Status') !!}
                                    <select name="status" id="status" class="form-control">
                                        @foreach(['pending' => 'Pending', 'approved'=>'Approve', 'rejected'=>'Reject'] as $key=>$result)

                                        <option value="{{ $key }}" {{ $member['status'] == $key ? 'selected' : '' }}>{{ $result }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 mt-30">
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <i class="fa-solid fa-save"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewButtons = document.querySelectorAll('.preview-button');
        
        previewButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const fileName = this.dataset.file;
                const fileUrl = '/uploads/' + fileName;
                const popupWindow = window.open(fileUrl, 'File Preview', 'width=800,height=600');
                popupWindow.focus();
            });
        });
    });
</script>
@endsection