<a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right">
              @if(!empty($warranty->service_request_warranties_issued))
              @if($warranty->service_request_warranties_issued->cse_id == Auth::user()->id)
              <a href="{{ route('admin.warranty_details', ['warranty'=>$warranty->service_request->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>

              <a href="#markAsResolved" id="markas-resolved"
              data-toggle="modal"
              data-url="{{ route('admin.mark_warranty_resolved', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale() ]) }}"
              class="dropdown-item details text-success"><i class="fas fa-check"></i>  Mark as Resolved</a>
              @endif
              @endif

              @if(empty($warranty->service_request_warranties_issued))
              
              <a href="{{ route('cse.accept_warranty_claim', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Accept</a>
              @endif
            
             @if($warranty->expiration_date >  Carbon\Carbon::now())
              @if($warranty->has_been_attended_to == 'Yes')
            
               <a href="#resolvedDetails" data-toggle="modal" class="dropdown-item details text-primary" 
                data-url="{{ route('admin.warranty_resolved_details', ['warranty'=>$warranty->uuid, 'locale'=>app()->getLocale()]) }}" 
                id="resolved-details" data-job="{{ $warranty['service_request']['unique_id']}}">
               <i class="far fa-clipboard"></i> Resolved Details</a>
          @endif
          @else
          <a href="{{ route('admin.warranty_details', ['warranty'=>$warranty->service_request->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-primary"><i class="far fa-clipboard"></i> Details</a>
          @endif
