<div class="row">
    <div class="col-md-4">
        <x-textfield id="label_ad"
                     name="ad_label"
                     label="{{__('Kürzel')}}"
                     class="checkLabel"
        />
    </div>
    <div class="col-md-4">
        <x-textfield id="ad_name"
                     label="Bezeichner"
        />
    </div>
    <div class="col-md-4">
        <x-selectfield id="address_type_id"
                       label="Adress-Typ"
        >
            @foreach(App\AddressType::all() as $addressType)
                <option value="{{ $addressType->id }}"
                    {{ (old('address_type_id'))?' selected ' : ''}}>
                    {{ $addressType->adt_name }}
                </option>
            @endforeach
        </x-selectfield>
    </div>
</div>
<div class="row">
    <section class="col-md-8">
        <h3 class="h5">{{__('Firmierung')}}</h3>
        <x-textfield id="ad_name_firma"
                     label="{{__('Firma')}}"
                     value="{{ old('ad_name_firma')??''}}"
        />
        <div class="row">
            <div class="col-md-8">
                <x-rtextfield max="100"
                              id="ad_anschrift_strasse"
                              label="{{__('Straße')}}"
                              value="{{ old('ad_anschrift_strasse')??''}}"
                />
            </div>
            <div class="col-md-4">
                <x-textfield id="ad_anschrift_hausnummer"
                             label="{{__('Nr')}}"
                             value="{{ old('ad_anschrift_hausnummer')??''}}"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <x-rtextfield max="100"
                              id="ad_anschrift_ort"
                              label="{{__('Ort')}}"
                              value="{{ old('ad_anschrift_ort')??''}}"
                />
            </div>
            <div class="col-md-4">
                <x-rtextfield max="100"
                              id="ad_anschrift_plz"
                              label="{{__('PLZ')}}"
                              value="{{ old('ad_anschrift_plz')??''}}"
                />
            </div>
        </div>
        <x-selectfield id="land_id"
                       label="{{__('Land')}}"
        >
            @foreach (App\Land::all() as $land)
                <option value="{{ $land->id }}"
                    {{ (old('land_id'))?' selected ' : ''}} >
                    {{ $land->land_lang }}
                </option>
            @endforeach
        </x-selectfield>

    </section>
    <section class="col-md-4">
        <h3 class="h5">{{__('Optionale Angaben')}}</h3>
        <x-textfield id="ad_name_firma_2"
                     label="{{__('Firma 2')}}"
                     value="{{ old('ad_name_firma_2')??''}}"
        />
        <x-textfield id="ad_name_firma_co"
                     label="{{__('Firma c/o')}}"
                     value="{{ old('ad_name_firma_co')??''}}"
        />
        <x-textfield id="ad_name_firma_abladestelle"
                     label="{{__('Abladestelle')}}"
                     value="{{ old('ad_name_firma_abladestelle')??''}}"
        />
        <x-textfield id="ad_name_firma_wareneingang"
                     label="{{__('Wareneingang')}}"
                     value="{{ old('ad_name_firma_wareneingang')??''}}"
        />
        <x-textfield id="ad_anschrift_eingang"
                     label="{{__('Eingang')}}"
                     value="{{ old('ad_anschrift_eingang')??''}}"
        />
    </section>
</div>
