@foreach (json_decode($feedbackConversation) as $key=> $fdkcon)
@if($fdkcon->status=='Closed' || $fdkcon->status=='Re-Open')
<div class="text-center">
    <p>This Converstion was marked {{ $fdkcon->status }} by {{ $fdkcon->user_type }} on {{date('d M Y h:i A',strtotime($fdkcon->timestamp))}}</p>
</div>
@else
@if($fdkcon->user_type=='member')
<div class="message received">
    <p>{{ $fdkcon->message }}</p>
    @if (isset($fdkcon->media) && file_exists(public_path('uploads/' . $fdkcon->media)))
    <img src="/uploads/{{$fdkcon->media}}" class="preview-button" data-file="{{ $fdkcon->media }}" height="250" width="250">
    @endif
    <br />
    <span class="sender italic-text">Message By {{$fdkcon->sender}}</span>
    <span class="time pull-right">{{date('d M Y h:i A',strtotime($fdkcon->timestamp))}}</span>
</div>
@else
<div class="message sent">
    <p>{{$fdkcon->message}}</p><br />
    @if (isset($fdkcon->media) && file_exists(public_path('uploads/' . $fdkcon->media)))
    @php
    $filePath = public_path('uploads/' . $fdkcon->media);
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    @endphp

    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
    <img src="/uploads/{{$fdkcon->media}}" class="preview-button" data-file="{{ $fdkcon->media }}" height="250" width="250">
    @else
    <a href="/uploads/{{$fdkcon->media}}" target="_blank" class="preview-button" data-file="{{ $fdkcon->media }}"> File Attactment Preview </a>
    @endif
    @endif
    <br />
    <span class="sender italic-text">Message By Super Admin</span>
    <span class="time pull-right">{{date('d M Y h:i A',strtotime($fdkcon->timestamp))}}</span>
</div>
@endif
@endif
@endforeach