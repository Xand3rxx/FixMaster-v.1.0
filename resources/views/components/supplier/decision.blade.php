<div>
    <form id="prospective-decision-form"
        action="{{ route('admin.prospective.supplier.decision', app()->getLocale()) }}" method="POST">
        @csrf
        <input id="prospective-user" type="hidden" name="user" value="0">
        <input id="prospective-user-decision" type="hidden" name="decision" value="0">
    </form>
    @push('scripts')
        <script>
            $(function() {
                $(".prospective-decision-making").on('click', function(e) {
                    e.preventDefault()
                    if (confirm('Are you sure?')) {
                        $('#prospective-user').val($(this).data('user'))
                        $('#prospective-user-decision').val($(this).data('action'))
                        $('#prospective-decision-form').submit()
                    }
                    return false;
                });
            });

        </script>
    @endpush
</div>
