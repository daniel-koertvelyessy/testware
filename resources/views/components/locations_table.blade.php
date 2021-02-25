<div class="col">
    <table class="table table-responsive-md table-striped">
        <thead>
        <tr>
            <th>@sortablelink('l_label', __('Standort'))</th>
            <th>@sortablelink('l_name', __('Name'))</th>
            <th> {{__('Gebäude')}}</th>
            <th> {{__('Geräte')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($locations as $location)
            <tr>
                <td>
                    <a href="/location/{{ $location->id }}">{{ $location->l_label }}</a>
                </td>
                <td>{{ $location->l_name }}</td>
                <td>{{ $location->Building->count() }}</td>
                <td>{{ $location->countTotalEquipmentInLocation() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($locations->count()>1)
        <div class="d-flex justify-content-center">
            {!! $locations->withQueryString()->onEachSide(2)->links() !!}
        </div>
    @endif
</div>
