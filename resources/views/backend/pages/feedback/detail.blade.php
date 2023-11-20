@extends('backend.layouts.master')

@section('title')
Feedback - Admin Panel
@endsection

@section('style')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">

<style>
    .chat-screen {
        max-width: 600px;
        margin: 0 auto;
    }

    .chat-bubble {
        display: inline-block;
        max-width: 70%;
        padding: 10px;
        border-radius: 20px;
        margin-bottom: 10px;
    }

    .sender-bubble {
        background-color: #DCF8C6 !important;
        float: right;
    }

    .message-bubble {
        background-color: #F2F2F2;
        float: left;
    }

    .chat-bubble p {
        margin: 0;
        word-wrap: break-word;
    }

    .timestamp {
        font-size: 0.8rem;
        color: #888;
        text-align: right;
    }

    /* Responsive layout for the table */
    @media (max-width: 600px) {
        .chat-bubble {
            max-width: 100%;
        }
    }
</style>
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

    .mt-30 {
        margin-top: 30px;
    }

    body {
        padding-top: 30px;
    }

    .chat-container {
        min-width: 100%;
    }

    .message-list {
        background-color: #f7f7f7;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        display: flex;
        /* Set parent element to display: flex */
        flex-direction: column;
        /* Stack messages vertically */
    }

    .message {
        margin-bottom: 10px;
        padding: 8px;
        border-radius: 5px;
        max-width: 70%;
    }

    .received {
        background-color: #d1dffd;
        align-self: flex-start;
        min-width: 35%;
    }

    .sent {
        background-color: #e2f3e9;
        align-self: flex-end;
        min-width: 35%;
    }

    .sent p,
    .received p {
        margin: 0;
    }

    .time {
        font-size: 12px;
        color: #888;
    }

    /* Optional: Add some spacing between messages */
    .message-list .message:not(:first-child) {
        margin-top: 5px;
    }

    .italic-text {
        font-style: italic;
    }
</style>
@if($feedback->status == 'Closed')
<style>
    .replyform input,
    .replyform textarea,
    .replyform button {
        pointer-events: none;
        background-color: #f0f0f0;
        color: #888;
    }
</style>
@endif
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Feedback Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('feedback.index') }}">All Feedback</a></li>
                    <li><span>Detail Feedback</span></li>
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
                        <div class="row py-3">
                            <div class="col-sm-6" role="group" aria-label="Basic example">
                                <div class="btn-group pull-left">
                                    <div>
                                        Tracking Id:<b> #{{$feedback->id}}</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" role="group" aria-label="Basic example">
                                <div class="btn-group pull-right">
                                    @if($feedback->status=='Closed')
                                    <a href="{{ route('feedback-status', ['feedback_id' => $feedback->id,'status' => 'Re-Open','reply' => 'open']) }}" type="btn" class="btn btn-success" onclick="return confirm('Are you sure you want to Re-Open the conversation?');">
                                        <i class="fa fa-check"></i> Re-Open Conversation
                                    </a>
                                    @else
                                    <a href="{{ route('feedback-status', ['feedback_id' => $feedback->id,'status' => 'Closed','reply' => 'closed']) }}" type="btn" class="btn btn-danger" onclick="return confirm('Are you sure you want to close the conversation?');">
                                        <i class="fa fa-close"></i> Close Conversation
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <!-- <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Name'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$feedback->name ?? ''}}
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Type'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$feedback->type ?? ''}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Complaint Type'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$complaint_type ?? ''}}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Subject'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$feedback->subject ?? ''}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Registered Date'}} :
                                    </div>
                                    <div class="col-6">
                                        {{date('d M Y ',strtotime($feedback->created_at))}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row py-3">
                                    <div class="col-6">
                                        {{'Message'}} :
                                    </div>
                                    <div class="col-6">
                                        {{$feedback->message ?? ''}}
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

<div class="container chat-container">
    <div class="row">
        <div class="col-md-12">
            <div class="message-list">
            </div>
            <div class="py-3">
                <form action="{{ route('feedback-status') }}" class="replyform" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" value="Pending">
                    <input type="hidden" name="feedback_id" value="{{ $feedback->id }}">
                    <div class="input-group mb-3">
                        <textarea class="form-control" name="reply" id="reply" cols="30" rows="5" placeholder="Enter your message..."></textarea>
                        <div class="input-group-append">
                            <label class="input-group-text">
                                <i class="bi bi-file-earmark-image"></i> Select File
                            </label>
                            <input type="file" class="d-none" name="media" id="media">
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" id="removeFileButton" style="display: none;">Remove File</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
    document.getElementById('media').addEventListener('change', function() {
        var fileInput = this;
        var removeFileButton = document.getElementById('removeFileButton');
        var customFileLabel = document.querySelector('.input-group-text');

        if (fileInput.files.length > 0) {
            var fileName = fileInput.files[0].name;
            customFileLabel.innerHTML = '<i class="bi bi-check"></i> ' + fileName;
            removeFileButton.style.display = 'inline-block';
        } else {
            customFileLabel.innerHTML = '<i class="bi bi-file-earmark-image"></i> Select File';
            removeFileButton.style.display = 'none';
        }
    });

    // Trigger file input when "Select File" label is clicked
    document.querySelector('.input-group-text').addEventListener('click', function() {
        var fileInput = document.getElementById('media');
        fileInput.click();
    });

    // Handle file removal
    document.getElementById('removeFileButton').addEventListener('click', function() {
        var fileInput = document.getElementById('media');
        var customFileLabel = document.querySelector('.input-group-text');
        fileInput.value = '';
        customFileLabel.innerHTML = '<i class="bi bi-file-earmark-image"></i> Select File';
        this.style.display = 'none';
    });

    $('.replyform').on('submit', function(event) {
        event.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log(response);
                $('#reply').val('');
                $('#media').val('');
                $('.input-group-text').html('<i class="bi bi-file-earmark-image"></i> Select File');
                $('#removeFileButton').hide();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

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

    function updateMessageContainer() {
        var feedbackId = '{{ $feedback->id }}';
        var url = 'fetch-updated-data?feedback_id=' + feedbackId;
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('.message-list').html(response.html);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    setInterval(updateMessageContainer, 1000);
</script>
@endsection