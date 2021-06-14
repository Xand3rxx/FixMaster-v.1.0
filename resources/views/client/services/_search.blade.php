
@if($type == 'Name')
    @if(count($services) == 0)
        <div class="col-lg-12 col-md-8 col-12 mt-5 pt-2 mt-sm-0 pt-sm-0 services-list">
            <div class="justify-content-center">
            <h5>No result found for {{ $query }}</h5>
            </div>
        </div>
    @else
        @foreach($services as $service)@endforeach

        <div class="col-lg-12 col-md-8 col-12 mt-5 pt-2 mt-sm-0 pt-sm-0 services-list">
            <div class="row align-items-center">
                <div class="col-lg-9 col-md-7">
                    <div class="title-heading">
                    {{-- <h4 class="mb-0 serv__1">{{ $service->name }}</h4> --}}
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                @foreach($services as $service)
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="card blog rounded border-0 shadow">
                        <div class="position-relative">
                            <img class="ult1 card-img-top rounded-top" src="{{ asset('assets/service-images/'.$service->image) }}" alt="{{ $service->name }}">

                            <div class="overlay rounded-top bg-dark"></div>
                        </div>
                        <div class="card-body content">
                        <h5 class="serv__2">{{ $service->name }} <a href="{{ route('client.services.details', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" title="View {{ $service->name }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                            <div class="post-meta d-flex justify-content-between mt-2">
                            </div>
                            <a href="{{ route('client.service_quote', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-outline-fix btn-block">Request Service</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div><!--end col-->
    @endif

@else
    @if(count($services) == 0)
    <div class="col-lg-12 col-md-8 col-12 mt-5 pt-2 mt-sm-0 pt-sm-0 services-list">
        <div class="justify-content-center">
        <h5>No result found for {{ $query }}</h5>
        </div>
    </div>
    @else

    @foreach($services as $service)@endforeach

    {{-- <h5 class="mt-4 mb-0">{{ $service->name }}</h5> --}}
    <div class="row">
        @foreach($services as $item)
            <div class="col-md-4 mt-4 pt-2">
                <div class="card blog rounded border-0 shadow">
                    <div class="position-relative">
                    <img alt="{{ $item->name }}" src="{{ asset('assets/service-images/'.$item->image) }}"  class="card-img-top rounded-top" />
                        <div class="overlay rounded-top bg-dark"></div>
                    </div>
                    <div class="card-body content">
                        <h5><a href="javascript:void(0)" class="card-title title text-dark" style="color: #3c4858 !important; font-size: 20px !important; transition: all 0.5s ease !important;">{{ $item->name }}</a> <a href="{{ route('client.services.details', ['service'=>$item->uuid, 'locale'=>app()->getLocale()]) }}" title="View {{ $item->name }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                        <div class="post-meta d-flex justify-content-between mt-3">
                            <a href="{{ route('client.services.quote', ['service'=>$item->uuid, 'locale'=>app()->getLocale()]) }}" class="text-muted readmore" >Request Service <i class="mdi mdi-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        @endforeach

    </div><!--end row-->
    @endif
@endif