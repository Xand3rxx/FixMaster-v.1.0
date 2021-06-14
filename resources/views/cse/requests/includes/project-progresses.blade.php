<h3>Project Progress</h3>
<section>
    <p class="mg-b-0">Specify the current progress of the job.</p>
    <div class="form-row mt-4">
        <div class="form-group col-md-12">
            <select required class="form-control custom-select" name="project_progress">
                <option selected disabled value="0">Select...</option>
                @foreach ($ongoingSubStatuses as $status)
                    <option value="{{ $status->uuid }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</section>
