<div>
    <form id="prospective-cse-decision-form"
        action="{{ route('admin.prospective.cse.decision', app()->getLocale()) }}" method="POST">
        @csrf
        <input id="prospective-cse-user" type="hidden" name="user" value="0">
        <input id="prospective-cse-decision" type="hidden" name="decision" value="0">
    </form>
    @push('scripts')
        <script>
            $(function() {
                $(".cse-decision-making").on('click', function(e) {
                    e.preventDefault()
                    if (confirm('Are you sure?')) {
                        $('#prospective-cse-user').val($(this).data('user'))
                        $('#prospective-cse-decision').val($(this).data('action'))
                        $('#prospective-cse-decision-form').submit()
                    }
                    return false;
                });
            });

        </script>
    @endpush
</div>
