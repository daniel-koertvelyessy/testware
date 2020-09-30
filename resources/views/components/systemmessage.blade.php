
<article class="card p-2 bm-1">
    <header class=" d-flex flex-row">
        <p class="text-small pr-1 col-4"><span class="fas fa-envelope"></span> Meldung vom {{ $date??date('Y-m-d') }}
            <a href="#" class=""><i class="fas fa-check"></i></a>
            <a href="#" class=""><i class="far fa-trash-alt"></i></a></p>
        <p class="border-left pl-3 col-8">{{ $msg??'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum quia, reiciendis? Asperiores at autem corporis deleniti dicta doloremque eos, esse facilis hic in maiores quas repellat tenetur, ullam ut voluptas?<'}}</p>
    </header>
    <footer class="mt-0" >
        <a href="#" class="small">zum Gerät</a>
    </footer>
</article>
