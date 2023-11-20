@extends('backend.layouts.master')

@section('title')
    Information - Admin Panel
@endsection

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Information Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('information.index') }}">All Information</a></li>
                    <li><span>Detail Information</span></li>
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
                                    <a href="{{route('information.edit',$information['id'])}}" type="btn" class="btn btn-sm btn-outline-secondary pr-2"> 
                                        Edit <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <div class="btn-group mr-2">
                                    <form method="post" action="{{route('information.destroy',$information['id'])}}">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-outline-danger btn-sm">
                                            Delete <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                               
                            </div> 
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Name'}}
                                    </div>
                                    <div class="col-6">
                                        {{$information->title ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3" >
                            <div class="col-md-6">
                                <div class="row pb-4">
                                    <div class="col-6">
                                        {{'Description'}}
                                    </div>
                                    <div class="col-6">
                                        {{$information->description ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3" >
                            <div class="col-md-6">
                                <div class="row pb-4">
                                    <div class="col-6">
                                        {{'Information Link'}}
                                    </div>
                                    <div class="col-6">
                                        {{$information->information_link ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-6">
                                        {{'information Image'}}
                                    </div>
                                    <div class="col-6">
                                        @if (isset($information->cover_image) && file_exists(public_path('uploads/' . $information->cover_image)))
                                            <a download="{{$information->cover_image}}" href="/uploads/{{$information->cover_image}}" class="btn btn-success">Download</a>
                                            <button class="preview-button btn btn-primary" data-file="{{ $information->cover_image }}">View</button>
                                        @else
                                            <span class="not-available">Not available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
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