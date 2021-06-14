<div class="pd-20 pd-lg-25 pd-xl-30">
    <small class="font-weight-bold">Subject: {{ $message->subject }}</small><br>
    <small class="font-weight-bold">From: {{ $message->userSentMessage->fullName->name }}</small><br>
    <small class="font-weight-bold">To: {{ $message->userReceivedMessage->fullName->name }}</small><br>
    <small class="font-weight-bold">Date: {{ Carbon\Carbon::parse($message->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</small>
    <hr>
    {!! $message->body !!}
</div>