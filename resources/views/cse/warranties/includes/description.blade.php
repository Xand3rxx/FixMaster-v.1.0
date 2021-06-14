<table class="table table-striped table-sm mg-b-0">
                                       
                                       <tbody>
                                       <tr>
                                           <td class="tx-medium">Job Reference</td>
                                           <td class="tx-color-03"> {{$service_request->unique_id}}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Service Required</td>
                                           <td class="tx-color-03"> {{$service_request->service->name}}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Scheduled Fix Date </td>
                                <td class="tx-color-03">{{ !empty($service_request->preferred_time) ? Carbon\Carbon::parse($service_request->preferred_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'Not Scheduled yet'}} </td>
                                       </tr>
                                       
                                       <tr>
                                           <td class="tx-medium">Initial Service Charge</td>
                                           <td class="tx-color-03">₦{{ number_format($service_request->price->amount) }} Standard Price</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Total Service Charge</td>
                                           <td class="tx-color-03">₦{{ number_format($service_request->total_amount) }}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Security Code</td>
                                           <td class="tx-color-03">{{$service_request->client_security_code}}</td>
                                       </tr>
                                       
                                       <tr>
                                           <td class="tx-medium">Initial CSE Assigned</td>
                                           <td class="tx-color-03">{{CustomHelpers::arrayToList($service_request->service_request_assignees, 'cse-user')}}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Initial Technicians Assigned</td>
                                           <td class="tx-color-03">
                                      
                                       {{ CustomHelpers::arrayToList($service_request->service_request_assignees, 'technician-artisans') }}
                                         
                                             
                                           </td>
                                       </tr>

                                       @if(!empty($service_request->service_request_warranty->service_request_warranty_issued))
                                            @if(!is_null($service_request->service_request_warranty->service_request_warranty_issued->technician_id))
                                       <tr>
                                           <td class="tx-medium">Warranty Technicians Assigned</td>
                                           <td class="tx-color-03">
                                        
                                          {{ CustomHelpers::getWarrantTechnician($service_request->service_request_warranty->service_request_warranty_issued->technician_id) }}
                                           </td>
                                       </tr>
                                       @endif
                                           @endif
                                       <tr>
                                           <td class="tx-medium">Initial Quality Assurance Managers Assigned</td>
                                           <td class="tx-color-03">{{CustomHelpers::arrayToList($service_request->service_request_assignees, 'quality-assurance-user')}}</td>
                                           
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">State</td>
                                           <td class="tx-color-03">{{$service_request->client->account->state->name??'UNAVAILABLE'}}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">L.G.A</td>
                                           <td class="tx-color-03">{{$service_request->client->account->lga->name?? 'UNAVAILABLE'}}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Town/City</td>
                                           <td class="tx-color-03">{{$service_request->client->account->town->name?? 'UNAVAIALABLE'}}</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Initial Request Address</td>
                                           <td class="tx-color-03">{{$service_request->client->account->contact == null ? '': $service_request->client->account->contact->address}}.</td>
                                       </tr>
                                       <tr>
                                           <td class="tx-medium">Initial Request Description</td>
                                           <td class="tx-color-03">{{$service_request->description}}.</td>
                                       </tr>
                                      
                                       <tr>
                                           <td class="tx-medium">Reason for Warranty Claim </td>
                                           <td class="tx-color-03">I'm no longer interested. <span class="text-danger">(Only visible if the request was cancelled)</span></td>
                                       </tr>

                                   </tbody>
                               </table>
                               <div class="divider-text">Media Files</div>
                                    <div class="row row-xs">
                                        <div class="col-6 col-sm-4 col-md-3 col-xl">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-danger">
                                              <i class="far fa-file-pdf"></i>
                                            </div>
                                            <div class="card-body">
                                              <h6><a href="" class="link-02">{{ substr('54c2a6f3-8a9c-411a-bd68-96a3a37617b2', 0, 15) }}.pdf</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                        <div class="col-6 col-sm-4 col-md-3 col-xl">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-primary">
                                              <i class="far fa-file-word"></i>
                                            </div>
                                            <div class="card-body">
                                                <h6><a href="" class="link-02">{{ substr('1c160a9b-8f52-46f5-a687-1dd608da48b3', 0, 15) }}.docx</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                        <div class="col-6 col-sm-4 col-md-3 col-xl mg-t-10 mg-sm-t-0">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-indigo">
                                              <i class="far fa-file-image"></i>
                                            </div>
                                            <div class="card-body">
                                                <h6><a href="" class="link-02">{{ substr('ff9c0bfa-aeed-4724-a8e4-790cf04a9fdd', 0, 15) }}.jpg</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                        <div class="col-6 col-sm-4 col-md-3 col-xl mg-t-10 mg-md-t-0">
                                          <div class="card card-file">
                                            <div class="dropdown-file">
                                              <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                              <div class="dropdown-menu dropdown-menu-right">
                                                <a href="#" class="dropdown-item download"><i data-feather="download"></i>Download</a>
                                              </div>
                                            </div><!-- dropdown -->
                                            <div class="card-file-thumb tx-info">
                                              <i class="far fa-file-video"></i>
                                            </div>
                                            <div class="card-body">
                                                <h6><a href="" class="link-02">{{ substr('d886204a-a376-4924-a83b-2d7a7f84df7d', 0, 15) }}.mp4</a></h6>
                                            </div>
                                            <div class="card-footer"><span class="d-none d-sm-inline">Date Created: </span>{{ \Carbon\Carbon::now('UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</div>
                                          </div>
                                        </div><!-- col -->
                                      </div><!-- row -->
                                </div><!-- df-example -->
