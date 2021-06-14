@extends('layouts.client')
@section('title', 'Messages')
@section('content')
@include('layouts.partials._messages')
       
<style>.bg-light{ background-color: #fffaf6 !important; }</style>
<div class="col-lg-8 col-12">
    <div class="rounded shadow p-4">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Messages:</h5>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#message-modal" class="btn btn-primary btn-sm"><i data-feather="plus" class="fea icon-sm"></i> Message FixMaster</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
                <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link rounded active" id="inbox-tab" data-toggle="pill" href="#inbox" role="tab" aria-controls="inbox" aria-selected="false">
                            <div class="text-center pt-1 pb-1">
                                <h4 class="title font-weight-normal mb-0">Inbox</h4>
                            </div>
                        </a><!--end nav link-->
                    </li><!--end nav item-->
                    
                    <li class="nav-item">
                        <a class="nav-link rounded" id=sent-tab" data-toggle="pill" href="#sent" role="tab" aria-controls="sent" aria-selected="false">
                            <div class="text-center pt-1 pb-1">
                                <h4 class="title font-weight-normal mb-0">Sent</h4>
                            </div>
                        </a><!--end nav link-->
                    </li><!--end nav item-->
                </ul><!--end nav pills-->
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
                @foreach ($receivedMessages as $message => $values)
                    <h6 class="text-light bg-dark"><span class="ml-1">{{ $message }}</span></h6>
                    @foreach ($values as $value) 
                        <div class="d-flex border-bottom p-3 message-details @if($value->is_read == '0') bg-light @endif" data-url="{{ route('client.inbox_message_details', $value->id) }}">
                            <a href="#messageDetailsModal" data-toggle="modal">
                                <div class="media ml-2">
                                    <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />

                                    <div class="content ml-3">
                                        <small class="float-right">{{ Carbon\Carbon::parse($value->created_at, 'UTC')->isoFormat('h:mma') }}</small>

                                        <h6 class="text-dark">Kelvin Adesenya</h6>
                                        <h6 class="tx-11 text-primary">{{ $value->subject }}</h6>
                                        <span class="text-muted mb-0">{!! strip_tags(substr($value->body, 0, 85)) !!}...</span>
                                    </div>
                                </div>
                            </a>
                        </div> 
                    @endforeach
                @endforeach
            </div>

            <div class="tab-pane fade show" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                @foreach ($sentMessages as $message => $values)
                    <h6 class="text-light bg-dark"><span class="ml-1">{{ $message }}</span></h6>
                    @foreach ($values as $value) 
                        <div class="d-flex border-bottom p-3 message-details @if($value->is_read == '0') bg-light @endif" data-url="{{ route('client.outbox_message_details', $value->id) }}">
                            <a href="#messageDetailsModal" data-toggle="modal">
                                <div class="media ml-2">

                                    @if($value->sender_id == '4' || $value->userReceivedMessage->designation == '[SUPER_ADMIN_ROLE]' || $value->userReceivedMessage->designation == '[ADMIN_ROLE]')
                                    <img src="{{ asset('assets/images/home-fix-logo-coloredd.png') }}" class="avatar avatar-md-sm rounded-pill shadow" alt="">
                                    @elseif($value->userReceivedMessage->designation == '[CSE_ROLE]')
                                        @if(!empty($value->userReceivedMessage->cse->avatar) && file_exists(public_path().'/assets/cse-technician-images/'.$value->userReceivedMessage->cse->avatar))
                                        <img src="{{ asset('assets/cse-technician-images/'.$value->userReceivedMessage->cse->avatar) }}" class="avatar avatar-md-sm rounded-pill shadow" alt="" />
                                        @else
                                            @if($value->userReceivedMessage->cse->gender == 'Male')
                                                <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />
                                            @else
                                                <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />
                                            @endif
                                        @endif
                                    @elseif($value->userReceivedMessage->designation == '[TECHNICIAN_ROLE]')
                                        @if(!empty($value->userReceivedMessage->technician->avatar) && file_exists(public_path().'/assets/cse-technician-images/'.$value->userReceivedMessage->technician->avatar))
                                        <img src="{{ asset('assets/cse-technician-images/'.$value->userReceivedMessage->technician->avatar) }}" class="avatar avatar-md-sm rounded-pill shadow" alt="" />
                                        @else
                                            @if($value->userReceivedMessage->technician->gender == 'Male')
                                                <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />
                                            @else
                                                <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />
                                            @endif
                                        @endif
                                    @elseif($value->userReceivedMessage->designation == '[CLIENT_ROLE]')
                                        @if(!empty($value->userReceivedMessage->client->avatar) && file_exists(public_path().'/assets/client-avatars/'.$value->userReceivedMessage->client->avatar))
                                        <img src="{{ asset('assets/client-avatars/'.$value->userReceivedMessage->client->avatar) }}" class="avatar avatar-md-sm rounded-pill shadow" alt="" />
                                        @else
                                            @if($value->userReceivedMessage->client->gender == 'Male')
                                                <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />
                                            @else
                                                <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="avatar avatar-md-sm rounded-pill shadow" />
                                            @endif
                                        @endif
                                    @endif

                                    <div class="content ml-3">
                                        <small class="float-right">{{ Carbon\Carbon::parse($value->created_at, 'UTC')->isoFormat('h:mma') }}</small>

                                        <h6 class="text-dark">{{ $value->userReceivedMessage->fullName->name }}</h6>
                                        <h6 class="tx-11 text-primary">{{ $value->subject }}</h6>
                                        <span class="text-muted mb-0">{!! strip_tags(substr($value->body, 0, 85)) !!}...</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div><!--end col-->


<!-- Modal Content Start -->
<div class="modal fade" id="message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Send Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form class="rounded shadow p-4" method="POST" action="{{ route('client.send_messages') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input name="recipient_id" id="recipient_id" type="hidden" class="form-control pl-5 d-none @error('recipient_id') is-invalid @enderror" value="{{ old('recipient_id') ?? 4 }}" required/>
                            <div class="form-group position-relative">
                                <label>Subject <span class="text-danger">*</span></label>
                                <i data-feather="alert-circle" class="fea icon-sm icons"></i>
                                <input name="subject" id="subject" type="text" class="form-control pl-5 @error('subject') is-invalid @enderror"/>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><!--end col-->

                        <div class="col-md-12">
                            <div class="form-group position-relative">
                                <label>Message <span class="text-danger">*</span></label>
                                <i data-feather="message-circle" class="fea icon-sm icons"></i>
                                <textarea name="message" id="messageBody" rows="4" class="form-control pl-5 @error('message') is-invalid @enderror" placeholder="Your message :"></textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" id="submit" class="submitBnt btn btn-primary">Submit</button>
                        </div><!--end col-->
                    </div><!--end row-->

                </form><!--end form-->
            </div>
            
        </div>
    </div>
</div>
<!-- Modal Content End -->

<div class="modal fade" id="messageDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Message Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="message-content">
                <!-- Message body displays here -->
                <div id="spinner-icon"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {

        $(document).on('click', '.message-details', function(){
            // e.preventDefault();
            let route = $(this).attr('data-url');

            console.log(route);
            $.ajax({
                url: route,
                beforeSend: function() {
                    $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4" style="margin-top: 200px !important"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    // $('#message-content').modal('show');
                    $('#message-content').html('');
                    $('#message-content').html(result).show();
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error+ ' An error occured while trying to retireve message details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            });

        });

        $('.close').click(function (){
            $('#message-content').html('');
            $(".modal-backdrop").remove();
        });

    });
   
</script>
@endpush
@endsection