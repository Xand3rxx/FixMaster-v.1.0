{{-- Hidden fields needed for request --}}
<input type="hidden" value="{{ $service->uuid }}" name="service_uuid" class="d-none" />
<input name="payment_for" type="hidden" value="service-request" class="d-none" />
{{-- <input type="hidden" value="{{!empty($balance->closing_balance) ? $balance->closing_balance : '0'}}" name="balance" class="d-none" /> --}}
<input type="hidden" value="" class="d-none alt-booking" />
<input type="hidden" value="" class="d-none town-id" />
<input type="hidden" value="{{ route('lga_list', app()->getLocale()) }}" class="d-none lga-list" />
<input type="hidden" value="{{ route('towns.show', app()->getLocale()) }}" class="d-none town-list" />
<input type="hidden" value="{{ route('client.ajax_contactForm', app()->getLocale()) }}" class="d-none ajax-contact-form" />
<input type="hidden" value="{{ route('client.service-request.validate_service_area', app()->getLocale()) }}" class="d-none validate-service-area" />
