<a href="{{ route('admin.index') }}"
   class="  @if($numObj / $maxObj < 0.7) d-none @endif w-25 "
>
    <div class="progress"
         title="{{__('Verfügbare Objekte')}} {{ $maxObj-$numObj }}"
    >
        <div class="progress-bar
@if ($numObj / $maxObj > 0.9)
            bg-danger
@else($numObj / $maxObj < 0.9 && $numObj / $maxObj < 0.7)
            bg-warning
@endif "
             role="progressbar"
             style="width: {{ 100 * $numObj / $maxObj }}%"
             aria-valuenow="{{ $numObj }}"
             aria-valuemin="0"
             aria-valuemax="{{ $maxObj }}"
        >
            {{ $numObj . ' / ' . $maxObj }}
        </div>
    </div>
</a>

