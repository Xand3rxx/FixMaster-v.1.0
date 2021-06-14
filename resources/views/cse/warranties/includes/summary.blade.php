<div id="serviceRequestSummary" class="tab-pane pd-20 pd-xl-25">
                            <div class="divider-text">Diagnostic Reports</div>
                            @if(!empty($requestReports))
                          

                            <div class="card-groups">
                          @foreach($requestReports as $item)
                       
                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">1</div>

                                        <p class="card-text">{{ucfirst($item->report)}}</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ Carbon\Carbon::parse($item->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa')}}
                                        </small></p>
                                    </div>
                                </div>
                              
                                @endforeach
                            </div>
                            @endif

                            <div class="divider-text">Causal Reports</div>
                            @if(!empty($service_request->service_request_warranty->service_request_warranty_issued))
                            @if(!empty($service_request->service_request_warranty->service_request_warranty_issued->warrantReport))

                            <div class="card-groups">
                          @foreach($service_request->service_request_warranty->service_request_warranty_issued->warrantReport as $item)
                          @if(!empty($item->causal_reason ))

                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">1</div>

                                        <p class="card-text">Causal Reason</p>
                                        <p class="card-text">{{ucfirst($item->causal_reason )}}</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ Carbon\Carbon::parse($item->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa')}}
                                        </small></p>
                                    </div>
                                </div>
                                @endif

                                @if(!empty($item->causal_agent_id ))

                                <div class="card">
                                    <div class="card-body shadow-none bd-primary overflow-hidden">
                                        <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">1</div>

                                        <p class="card-text">Causal Agent: <span style="color:red"> {{ ucfirst(CustomHelpers::getUserDetail($item->causal_agent_id)->roles[0]->url) }}</span> </p>
                                        <p class="card-text">{{ CustomHelpers::getWarrantTechnician($item->causal_agent_id) }}</p>
                                        <p class="card-text"><small class="text-muted">Date Created: {{ Carbon\Carbon::parse($item->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa')}}
                                        </small></p>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                    
                                
                          
                            </div>
                            @endif
                            @endif

                            <div class="divider-text">Faulty Part Images</div>
                            <div class="row row-xs">
                            @if(!empty($service_request->service_request_warranty->service_request_warranty_issued))
                            @if(!empty($service_request->service_request_warranty->service_request_warranty_issued->warrantyImage))
                            @foreach($service_request->service_request_warranty->service_request_warranty_issued->warrantyImage as $item)

                                <div class="col-6 col-sm-4 col-md-3 col-xl">
                                    <div class="card card-file">
                                    <div class="dropdown-file">
                                        <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('cse.warranty_download', ['file'=> $item->name, 'locale'=>app()->getLocale()]) }}" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                        </div>
                                    </div><!-- dropdown -->
                                    <div class="card-file-thumb tx-danger" 
                                    style="background-image: url('{{ asset('assets/warranty-claim-images/'.$item->name)}}')"
                                    >
                                        <i class="far fa-file-pdf"></i>
                                    </div>
                                    <div class="card-body">
                                  

                                        <h6><a href="" class="link-02">{{ substr($item->name, 0, 15).'.'.CustomHelpers::getExtention($item->name)}}
                                    
                                        </a></h6>
                                    </div>
                                    <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                    </div>
                                </div><!-- col -->
                                @endforeach
                    
                                @endif
                                 @endif
                            </div><!-- row -->

                            <div class="divider-text">RFQ's</div>
                            <h5 class="mt-4">Request For Quotation</h5>
                            <div class="table-responsive">
                             
                            @if(!empty($suppliers))
                           
                           @foreach($rfqs as $item)
                        
                                <table class="table table-hover mg-b-0 mt-4">
                                    <thead class="">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Batch Number</th>
                                            <th>Client</th>
                                            <th>Issued By</th>
                                            <th>Status</th>
                                            <th class="text-center">Total Amount</th>
                                            <th>Date Created</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>

                                    <tbody>
                                     
                                        <tr>
                                            <td class="tx-color-03 tx-center">{{  $loop->iteration }}</td>
                                            <td class="tx-medium">{{$item->unique_id}} </td>
                                            <td class="tx-medium">{{ ucfirst($item->serviceRequest->client->account->first_name)}}
                                            {{ucfirst($item->serviceRequest->client->account->last_name)}}
                                            </td>
                                            <td class="tx-medium">{{$item['issuer']['account']['first_name']}}
                                            {{$item['issuer']['account']['last_name']}}
                                            </td>
                                            <td class="text-medium text-success">{{$item->status}}</td>
                                            <td class="tx-medium text-center">₦{{ number_format($item->total_amount) ?? 'Null'}}</td>
                                            <td class="text-medium">{{ Carbon\Carbon::parse($item->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                            <td class=" text-center">
                                                <!-- <a href="#rfqDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View RFQ-C85BEA04 details" data-batch-number="RFQ-C85BEA04" data-url="#" id="rfq-details"></i> Details</a> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endforeach
                                @endif
                            </div><!-- table-responsive -->

                        </div><!----end summary-->