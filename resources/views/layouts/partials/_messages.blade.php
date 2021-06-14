
<link href="{{ asset('assets/client/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

{{-- Primary Alert --}}
@if(Session::has('primary'))
<div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Processing!</strong> {{ Session::get('primary') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif




{{-- Secondary Alert --}}
@if(Session::has('secondary'))
<div class="alert alert-secondary alert-dismissible fade show" role="alert">
  <strong>Almost there!</strong> {{ Session::get('secondary') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif


{{-- Success Alert --}}
@if($message = Session::get('success'))

  @section('scripts')
    <script>
      var message = '{{ $message }}';
      var type = 'success';
      displayMessage(message, type);
    </script>
  @endsection

@endif

{{-- Custom Alert --}}
@if(Session::has('flash_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> {{ Session::get('flash_message') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif

{{-- Danger Alert --}}
@if(Session::has('danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> {{ Session::get('danger') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif

{{-- Warning Alert --}}
@if(Session::has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Something went wrong!</strong> {{ Session::get('warning') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif

{{-- Informational Alert --}}
@if(Session::has('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>Heads Up!</strong> {{ Session::get('info') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif

{{-- Light Alert --}}
@if(Session::has('light'))
<div class="alert alert-light alert-dismissible fade show" role="alert">
  <strong>Heads Up!</strong> {{ Session::get('light') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>Sfdump
</div>
@endif

{{-- Dark Alert --}}
@if(Session::has('dark'))
<div class="alert alert-dark alert-dismissible fade show" role="alert">
  <strong>Note to User!</strong> {{ Session::get('dark') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span>&times;</span>
  </button>
</div>
@endif

{{-- Authentication Alert --}}
@if(Session::has('status'))

  <div class="notify top-right do-show" data-notification-status="success">{{ Session::get('status') }}</div>
      
  <a href="#" class="button d-none" data-type="bar-top" data-status="success"></a>
@endif

{{-- If the page has any error passed to it --}}
{{-- @if(count($errors) > 0)
  <div class="container">
    <div class="alert alert-outline alert-danger d-flex align-items-center" role="alert">
      <ul class="list-grou">
      @foreach($errors->all() as $error)
        <li style="list-style-type: none; !important"><i data-feather="alert-circle" class="mg-r-10"></i> {{ $error }}</li>
      @endforeach
      </ul>
    </div>
  </div>
@endif --}}
@if ($errors->any())
{{-- <div class="container">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  </div> --}}
  @foreach ($errors->all() as $error)
    @push('scripts')
      <script>
        var message = '{{ $error }}';
        var type = 'error';
        displayMessage(message, type);
      </script>
    @endpush
  @endforeach

@endif

@if ($message = Session::get('error'))
  @push('scripts')
    <script>
      var message = '{{ $message }}';
      var type = 'error';
      displayMessage(message, type);
    </script>
  @endpush
@endif

{{-- @if($errors->has('email'))
  <span class="invalid-feedback">
      <strong> {{ $error->('email') }} </strong>      
  </span>
@endif

@if($errors->has('password'))
  <span class="invalid-feedback">
      <strong> {{ $error->first('password') }} </strong>      
  </span>
@endif
 --}}
