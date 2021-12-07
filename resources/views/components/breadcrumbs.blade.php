<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @if (isset($breadlist) && count($breadlist)>0)
        <li class="breadcrumb-item">
            <a href="/">{{__('Portal')}}</a>
        </li>
        @foreach($breadlist as $item)
            @if ($loop->last)
                <li class="breadcrumb-item active"
                    aria-current="page"
                >{{ $item['name'] }}</li>
            @else
                <li class="breadcrumb-item">
                    <a href="/{{ $item['link'] }}">{{$item['name']}}</a>
                </li>
            @endif
        @endforeach
        @else
            <li class="breadcrumb-item active">
                <a href="/"
                   aria-current="page"
                >{{__('Portal')}}</a>
            </li>
        @endif
    </ol>
</nav>
