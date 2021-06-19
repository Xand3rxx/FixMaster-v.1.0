<div class="table-responsive rounded" id="contacts_table">
    <table class="table mb-0 table-center scroll">
        <thead class="bg-light">
            <tr>
                <th scope="col">Frequently Used Contacts</th>
            </tr>
        </thead>
        <tbody>
            @if($myContacts) 
                @foreach($myContacts as $k=>$myContact)
                    <tr>
                        <td>
                            <div class="media">
                            
                                <div class="custom-control custom-radio custom-control-inline">
                                    <div class="form-group mb-0">
                                        <input type="radio" id="{{$myContact->id}}" value="{{ $myContact->id }}" name="contact_id" class="custom-control-input contact-id" data-town-id="{{ $myContact->town_id }}" data-contact-name="{{ $myContact->name ?? 'Default Contact' }}" data-url="{{ route('client.service-request.validate_service_area', app()->getLocale()) }}" />
                                        <label class="custom-control-label" for="{{$myContact->id}}">{{$myContact->name ?? 'Default Contact'}}</label>
                                    </div>
                                </div>
                                
                                <div class="content ml-3">
                                    <span class="forum-title text-primary font-weight-bold">{{$myContact->phone_number}}</span>
                                    <p class="text-muted small mb-0 mt-2">{{$myContact->address}}</p>
                                </div>

                            </div>
                        </td>
                    </tr>
                @endforeach 
            @endif
        </tbody>
    </table>
</div>