
@if(!empty($results))
    <small class="text-danger">Kindly enter quantiy of items and report for the following Sub Services.</small>
    @foreach ($results as $result)
        <h5>{{ $result->name }}</h5>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="quantity">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity[{{$result->uuid}}]" value="" min="" max="">
            </div>
            {{-- <div class="form-group col-md-12">
                <label for="report">Report</label>
                <textarea rows="3" class="form-control @error("report") is-invalid @enderror" id="report" name="report[]"></textarea>
            </div> --}}
        </div>
    @endforeach
@endif
