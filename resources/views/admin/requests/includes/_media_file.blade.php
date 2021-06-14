
@if(pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'jpg' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'png' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'svg' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'gif' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'jpeg')

<li class="col-6 col-sm-4 col-md-3 col-xl" data-responsive="{{ asset('assets/service-request-media-files/'.$item['unique_name']) }} 375, {{ asset('assets/service-request-media-files/'.$item['unique_name']) }} 480, {{ asset('assets/service-request-media-files/'.$item['unique_name']) }} 800" data-src="{{ asset('assets/service-request-media-files/'.$item['unique_name']) }}" data-sub-html="<h4>{{ $item['original_name'] }}</h4>">
    <a href="">
        @if(empty($item['unique_name']))
            <img src="{{ asset('assets/images/no-image-available.png') }}" class="img-responsive" width="194" height="131" alt="No image found">

        @elseif(!file_exists(public_path('assets/service-request-media-files/'.$item['unique_name'])))
            <img src="{{ asset('assets/images/no-image-available.png') }}" class="img-responsive" width="194" height="131" alt="No image found">
        @else
            <img src="{{ asset('assets/service-request-media-files/'.$item['unique_name']) }}" class="img-responsive" width="194" height="131" alt="{{ $item['unique_name'] }}">
        @endif
    </a>
</li>

@elseif(pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'doc' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'docx' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'pdf' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'txt' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'xls' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'csv')
    <div class="col-6 col-sm-4 col-md-3 col-xl">
        <div class="card card-file">
            <div class="dropdown-file">
                <a href="" class="dropdown-link" data-toggle="dropdown"><i
                        data-feather="more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ asset('assets/service-request-media-files/'.$item['unique_name']) }}" class="dropdown-item" download><i data-feather="download"></i>Download</a>
                </div>
            </div><!-- dropdown -->
            <div class="card-file-thumb">
                @if(pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'doc' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'docx')
                <i class="far fa-file-word tx-primary"></i>
                @elseif(pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'pdf')
                <i class="far fa-file-pdf tx-danger"></i>
                @elseif(pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'txt')
                <i class="far fa-file-alt"></i>
                @elseif(pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'xls' || pathInfo($item['unique_name'], PATHINFO_EXTENSION) == 'csv')
                <i class="far fa-file-excel text-success"></i>
                @endif
                
            </div>
            <div class="card-body">
                <h6><a href="" class="link-02">{{ substr($item['unique_name'], 0, 15) }}</a></h6>
            </div>
            <div class="card-footer"><span class="d-none d-sm-inline">Date Created:
                </span>{{ \Carbon\Carbon::parse($item['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
            </div>
        </div>
    </div><!-- col -->
@endif