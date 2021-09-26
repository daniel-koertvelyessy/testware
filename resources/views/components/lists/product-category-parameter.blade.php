
@foreach($params as $param)
<x-parameter-item-pk :param="$param" mode="edit"/>
@endforeach
{{--
<div class="card p-2 mb-4 showProduktKategorieParamListItem" id="pkp_${item.id}">
    <form action="/updateProduktKategorieParams" method="post" id="updateProduktKategorieParams_${item.id}">
        @csrf
        @method('PUT')
        <input type="hidden" id="produkt_kategorie_id_${item.id}" name="produkt_kategorie_id" value="${item.produkt_kategorie_id}">
        <input type="hidden" id="id_${item.id}" name="id" value="${item.id}">
        <div class="mb-2">
            <label for="pkp_label_${item.id}">{{__('Label')}}</label>
            <input type="text" name="pkp_label" id="pkp_label_${item.id}" class="form-control checkLabel" value="${item.pkp_label}">
            <p class="small text-primary">{{__('erforderlich, max 20 Zeichen, ohne Sonder- und Leerzeichen')}}</p>
        </div>
        <div class="mb-2">
            <label for="pkp_name_${item.id}">Name</label>
            <input type="text" name="pkp_name" id="pkp_name_${item.id}" class="form-control" value="${item.pkp_name}">
            <p class="small text-primary">{{__('maximal 150 Zeichen')}}</p>
        </div>
        <div class="input-group mt-2 d-flex justify-content-end">
            <button type="button" class="btn btn-sm btn-link mr-2 btnUpdatePKParam" data-id="${item.id}"><span class="fas fa-download ml-md-2"></span> {{__('speichern')}}</button>
            <button type="button" class="btn btn-sm btn-link btnDeletePKParam" data-id="${item.id}">{{__('Löschen')}} <span class="far fa-trash-alt"></span></button>
        </div>
    </form>
    <form method="post" action="{{ route('deleteProduktKategorieParam') }}#Produkte" id="frmDeleteProduktKategorieParam_${item.id}">
        @csrf
        @method('DELETE')

        <input type="hidden" id="pkp_id_${item.id}" name="id" value="${item.id}">
        <input type="hidden" id="pkp_label_${item.id}" name="pkp_label" value="${item.pkp_label}">
    </form>
</div>
--}}
