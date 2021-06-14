<table class="table table-hover mg-b-0" id="basicExample">
                  <thead class="thead-primary">
                    <tr>
                      <th class="text-center">#</th>
                      <th>radius</th>
                      <th class="text-center">max_ongoing_jobs</th>
                      <th>Status.</th>
                      <th>Date Created</th>
                      <th>Date Updated</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  @foreach($requestSetting as $k=>$val)
                    <tr>
                      <td class="tx-color-03 tx-center">{{++$k}}</td>
                      <td>{{$val->radius}}Km</td>
                      <td>{{$val->max_ongoing_jobs}}</td> 
                      <!-- <td class="tx-medium">{{$val->status}}</td> -->
                      <td>
                        @if($val->status==0)
                        <span class="badge badge-danger">Inactive</span>
                        @elseif($val->status==1)
                            <span class="badge badge-success">Active</span>   
                        @endif
                     </td>
                      <td class="text-medium text-success">{{date("Y/m/d h:i:A", strtotime($val->created_at))}}</td>
                      <td class="text-medium">{{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</td>
                      <td class=" text-center">
                        <div class="dropdown-file">
                          <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <!-- <a onclick="editCriteria( {{$val->id}} )" href="#" data-toggle="modal" data-target="#editmenuitem" class="dropdown-item details text-danger"><i class="fas fa-edit"></i> Edit</a> -->
                            <!-- <a href="#" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a> -->
                          
                            <a href="#editCriteria" data-toggle="modal" id="criteria-edit" data-url="{{ route('admin.taxes.edit', ['tax'=>$val->uuid, 'locale'=>app()->getLocale()]) }}" data-tax-name="{{ $tax->name }}" data-id="{{ $tax->uuid }}" class="dropdown-item details text-info"><i class="far fa-edit"></i> Edit</a>

                            <a data-url="{{ route('admin.taxes.delete', ['tax'=>$tax->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger delete-entity" title="Delete {{ $tax->name}}" style="cursor: pointer;"><i class="fas fa-trash"></i> Delete</a>


                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                </table>