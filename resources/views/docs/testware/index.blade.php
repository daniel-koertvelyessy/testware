@extends('layout.layout-documentation')

@section('pagetitle')
    {{__('Dokumentation')}} @ testWare
@endsection


@section('doc-right-nav')
    <li class="duik-content-nav__item">
        <a href="#testWare-Objekte-Start">{{ __('Objekte') }}</a>
    </li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>{{__('testWare')}}</h1>
                <small class="text-muted">{{__('Stand')}} 2020.Oktober</small>
            </div>
        </div>
        <div class="row mt-lg-5 mt-sm-1">
            <div class="col">
                <p>{{__('Hier finden Sie die Dokumentation zu den verfügbaren Applikationen.')}}</p>

                <div data-spy="scroll"
                     data-target="#navbar-example2"
                     data-offset="0"
                >
                    <h4 id="testWare-Objekte-Start"
                        class="mt-3"
                    >testWare Objekte</h4>
                    <p class="lead">Hirarchie</p>
                    <div class="row">
                        <div class="col">
                            <p>Das zentrale Objekt in der testWare sind Geräte. Sie stellen reale Geräte in einem Betrieb dar.</p>
                            <p>Damit das Gerät mit Informationen angereichert werden kann, sind weitere Objekte nötig.</p>
                            <p>Der Aufbau der einzelnen Objekte ist im Schaubild dargestellt.</p>
                            <p><code>Geräte</code> sind im wesentlichen durch zwei Objekte definiert:</p>
                            <ol>
                                <li><span class="lead">Produkt</span></li>
                                <li><span class="lead">Stellplatz</span></li>
                            </ol>
                            <img src="{{ asset('img/svg/Objekt_Hirarchie.svg') }}"
                                 alt="Objekt Hirarchie in der testWare"
                                 class="img-fluid"
                            >
                            <p>Das <code>Produkt</code> definiert die Eigenschaften des Gerätes. Angefangen von der Kategorie, der Artikelnummer bis zur Einteilung der anzuwendenden Prüfung oder mehreren Prüfungen. Das <code>Produkt</code> ist eine Vorlage, aus der Geräte erstellt werden können.</p>
                            <p>Ändert sich beispielsweise ein Prüfvorschrift des Produktes werden automatisch alle Geräte, die aus diesem Produkt erstellt wurden, aktualisiert.</p>
                            <p>Der <code>Stellplatz</code> definiert den Ort an dem das Gerät sich befindet. Bei mobilen Geräten ist der Stellplatz der Ort, an dem das Gerät beim Nichtbetreiben lagert. Dies kann zum Beispiel die Ladestation sein.</p>
                            <p>Für Geräte können auch einen Raum oder ein Gebäude als Stellplatz definiert werden. Ganz den Anfoderungen des Gerätes entsprechend.</p>
                            <p>Näheres zu den Objekten finden Sie in den entsprechenden Sektionen.</p>
                            <h2 class="h4">Produkte</h2>
                            <p><code>Produkte</code> sind Vorlagen, aus denen Geräte erstellt werden können. Sie beinhalten alle gemeinsamen Werte, wie Hersteller, Artikelnummer oder die Bedienungsanleitung.</p>
                            <p><code>Produkte</code> können <code>Verordnungen</code> und dadurch bestimmten Anforderungen unterliegen. Dadurch ergeben sich Prüf- und/oder Wartungsvorgänge. Diese Vorgänge zu überwachen ist die Hauptaufgabe der testWare.</p>
                            <p><span class="lead">Beispiel:</span></p>
                            <p>Elektrogeräte unterliegen der VDE Geräteprüfung VDE 0100-600. Nach dieser Verordnung sind Elektrogeräte in 4 Klassen einzuteilen:</p>
                            <ul>
                                <li>Leitungen</li>
                                <li>Klasse 1</li>
                                <li>Klasse 2</li>
                                <li>Klasse 3</li>
                            </ul>
                        </div>
                    </div>
                </div>

@endsection
