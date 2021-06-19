{{-- Hidden fields needed for request --}}
<input type="hidden" value="{{ $service->uuid }}" name="service_uuid" class="d-none" />
<input name="payment_for" type="hidden" value="service-request" class="d-none" />
<input type="hidden" value="{{!empty($balance->closing_balance) ? $balance->closing_balance : '0'}}" name="balance" class="d-none" />
<input type="hidden" value="" name="balance" class="d-none alt-booking" />
