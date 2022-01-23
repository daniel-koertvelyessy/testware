<div class="modal fade"
     id="modalAddNote"
     tabindex="-1"
     aria-labelledby="modalAddNoteLabel"
     aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('note.store') }}#notes"
                  id="frmStoreNoteData"
                  method="POST"
                  enctype="multipart/form-data"
            >
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modalAddNoteLabel"
                    >{{__('Notiz für :objectname anlegen', ['objectname'=>$objectname])}}</h5>
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden"
                           name="_method"
                           id="modal_method"
                    >

                    <input type="hidden"
                           name="id"
                           id="model_note_id"
                    >

                    <input type="hidden"
                           name="uid"
                           id="note_object_uid"
                           value="{{ $uid }}"
                    >

                    <input type="hidden"
                           name="user_id"
                           id="modal_addnote_user_id"
                           value="{{ Auth::user()->id }}"
                    >

                    <div class="row">
                        <div class="col-md-8">
                            <x-selectfield id="note_type_id"
                                           label="{{__('Typ')}}"
                            >
                                @foreach (App\NoteType::all() as $note_type)
                                    <option value="{{ $note_type->id }}">{{ $note_type->label }}</option>
                                @endforeach
                                <option value="new">{{ __('neu') }}</option>
                            </x-selectfield>
                        </div>
                        <div class="col-md-4">
                            <x-textfield id="newNoteType"
                                         label="{{ __('Neuer Typ') }}"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <x-textfield id="label"
                                         label="{{__('Titel')}}"
                                         required
                            />
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="is_intern"
                                       name="is_intern"
                                       value="1"
                                       checked
                                >
                                <label class="custom-control-label"
                                       for="is_intern"
                                >{{ __('Notiz intern halten') }}
                                </label>
                            </div>
                        </div>
                    </div>


                    <x-textarea id="description"
                                label="{{__('Inhalt')}}"
                    />

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file"
                                   name="file_path"
                                   id="file_path"
                                   data-browse="{{__('Datei')}}"
                                   class="custom-file-input"
                                   accept=".pdf,.tif,.tiff,.png,.jpg,jpeg"
                            >
                            <label class="custom-file-label"
                                   for="file_path"
                            >{{__('Datei wählen')}}</label>
                        </div>
                    </div>

                    <x-textfield id="file_name"
                                 label="{{ __('Datei Name') }}"
                    />
                   {{-- <div class="row">
                        <div class="col-md-8">
                            <h3 class="h5">{{ __('Tag hinzufügen') }}</h3>

                            <x-selectgroup id="setTag" label="" btnT="btnAddTag"
                                           class=""
                                           btnL="{{ __('hinzufügen') }}"
                            >
                                @forelse(\App\Tag::all() as $tag)
                                    <option value="{{ $tag->id }}" data-label="{{ $tag->label }}" data-color="{{ $tag->color }}">
                                        {{ $tag->label }}
                                    </option>
                                    @empty
                                    <option value="void">{{ __('keine Tags vorhanden') }}</option>
                                @endforelse
                            </x-selectgroup>

                            <h3 class="h5 mt-4">{{ __('Neuen Tag erstellen') }}</h3>
                            <div class="row">
                                <div class="col-md-3">
                                    <x-textfield hideLabel label="{{ __('Kürzel') }}" id="setNewTagLabel"/>
                                </div>
                                <div class="col-md-3">
                                    <x-textfield hideLabel label="{{ __('Name') }}" id="setNewTagName"/>
                                </div>
                                <div class="col-md-4">
                                    <x-selectfield id="setNewTagColor">
                                        <option value="info">{{ __('Info') }}</option>
                                        <option value="success">{{ __('Erfolg') }}</option>
                                        <option value="warning">{{ __('Warnung') }}</option>
                                        <option value="danger">{{ __('Gefahr') }}</option>
                                        <option value="muted">{{ __('Muted') }}</option>
                                    </x-selectfield>
                                </div>
                                <div class="col-md-2">
                                    <x-button type="button" id="btnAddNoteTag">
                                        <span class="fas fa-chevron-right"></span>
                                    </x-button>
                                </div>
                            </div>




                        </div>
                        <div class="col-md-4">
                            <div class="list-group" id="taglist">

                            </div>
                        </div>
                    </div>--}}

                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-dismiss="modal"
                    >{{__('Abbruch')}}</button>
                    <button class="btn btn-primary">{{__('Notiz speichern')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
