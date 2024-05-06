@if($controlEquipment->Equipment && $controlEquipment->Anforderung && ! $controlEquipment->archived_at)
    <tr>
        <td>
            <a href="{{ route('equipment.show',$controlEquipment->Equipment) }}">
                {{ $controlEquipment->Equipment->eq_name }}</a>
            <br>
            <x-notifyer>{{__('Inventar-Nr')}}
                : {{ str_limit($controlEquipment->Equipment->eq_inventar_nr,30) }}</x-notifyer>
        </td>
        <td>{{ $controlEquipment->Anforderung->an_name }}</td>
        <td>{!! $controlEquipment->checkDueDate($controlEquipment) !!}</td>
        <td></td>
    </tr>
@endif