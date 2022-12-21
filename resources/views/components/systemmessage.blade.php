<article class="card p-2 mb-1 ">
    <div class="">
        <header class=" pr-1 d-flex justify-content-between align-items-center ">
            <div>
                <span class="fas fa-box"></span> {{ $subject }}
            </div>
            <span>
               <div class="dropdown">
                  <button class="btn btn-sm m-0"
                          type="button"
                          id="dropdownMenuButton"
                          data-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                  >
                    <span class="fas fa-ellipsis-v"></span>
                  </button>
                  <div class="dropdown-menu"
                       aria-labelledby="dropdownMenuButton"
                  >
                      @if (isset($linkshow))
                          <a class="dropdown-item  justify-content-between d-flex align-items-center"
                             href="{{ $linkshow }}"
                          >{{ $linkshowtext ?? __('öffnen') }} <i class="fas fa-chevron-right"></i></a>
                      @endif
                      @if (isset($linkconfirm))
                          <a class="dropdown-item  justify-content-between d-flex align-items-center"
                             href="{{ $linkconfirm }}"
                          >{{ $linkconfirmtext ?? __('bestätigen') }} <i class="fas fa-check"></i></a>
                      @endif
                      @if( isset($linkdelete))
                      <a href="{{ $linkdelete }}"
                         class="dropdown-item  justify-content-between d-flex align-items-center"
                      >Löschen <i class="far fa-trash-alt"></i></a>
                          @endif
                  </div>
                </div>
           </span>
        </header>
    </div>
    <section class="my-2">
        {{ $slot }}
    </section>
    <footer class="mt-0 d-flex justify-content-between small">
        <span class="text-muted">{{__('Ereignis')}}  {{ \Carbon\Carbon::parse($date ?? now()->subMinutes(10))->diffForHumans()  }} </span>
    </footer>
</article>
