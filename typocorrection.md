# Korrektur von Typos und Übersetzungen
Generell werden Typos in den Views, also den eigentlichen Seiten, und den Flash-Messages unterschieden, welche Meldungsfenster sind.

## Localizations
Im Quellcode werden alle Texte, die übersetzt werden sollen in folgendem Format angegeben: 
```php 
__('text')
 
# Beispiel in einem Blade
<h1>{{ __('text') }}</h1>

# Beispiel in einem Controller
$message = __('text');
```

Der Inhalt in den Klammern (im Beipsiel *text*) ist ein Eintrag, welcher in der Sprachdatei z.B. `de.json` enthalten sein muss:

```json 
{
    "text":"übersetzter_text"
}
```

*text* ist der Schlüssel und *übersetzter_text* ist der Wert, der für den Schlüssel eingesetzt wird. Der Schlüssel kann beliebig formuliert werden. **In der testWare ist der Schlüssel gleich dem deutschen Text.**

Fehlt der Eintrag, oder die Schlüsselwörter stimmen nicht überein, so wird der Text nicht übersetzt. Ebenso werden Texte, welche nicht mit `{{ _('` umschlossen werden nicht übersetzt.

Der Prozess zum Beheben von Typos im Quellcode ist wie folgt:
1. Korrektur im Quellcode
2. Korrektur/Ergänzung der Sprachdatei z.B. `de.json`

**WICHTIG**: 
Die Schlüssel der Sprachdateien müssen identisch sein.

```json 
# de.json
{
    "text":"übersetzter_text"
}

# en.json
{
    "text":"translated_text"
}
```

## Views
Alle Views sind unter `/resources/views` abgelegt. Die Objekte wie zum Beispiel Gebäude oder Gerät sind in den entsprechenden Ordnern `building` bzw. `equipment` vertreten. Per Konvention sind in diesen Ordnern mind. 3 verschiedene Dateien zu finden:

- **index**.blade.php  =>  Dies ist die Übersichtsseite aller vorhandenen Einträge des Objektes
- **show**.blade.php => Dies ist die Detailseite eines Objektes
- **create**.blade.php => Dies erstellt ein neues Objekt

 ### Beispiel Typo Produkt
Ist ein Typo in der Detailseite eines Produktes gefunden worden wäre die entsprechende Datei `/resources/views/admin/produkt/show.blade.php`

### Endpunkte
Ist der Typo auf einer anderen View enthalten kann man mit Hilfe des Endpunktes die View ausfindig machen. Dazu benötigt man die `web.php` Datei, welche unter `/routes/` liegt. In dieser sind alle Endpunkte aufgestellt.

```php 
# Beispiel für den Endpunkt  domain.tld/docs/api/endpoints/products 
Route::get('docs/api/endpoints/products', function () {
    return view('docs.api.endpoints.products');
})->name('docs.api.products');
```
Im *return* Wert wird der Speicherort der View angegeben. Durch das Ersetzen der '.' mit '/' erhält man den Pfad. Der letzte Platzhalter ist die Blade Datei im Ordner. Im obigen Beispiel `docs.api.endpoints.products` ist der Speicherort `resources/views/docs/api/endpoints/` und die View `products.blade.php`

## Flash Messages
Meldungen werden über die Session ausgelesen und auf der Seite ausgegeben. Der Inhalt der Meldung kommt in der Regel aus den entsprechenden Controllern.

Diese sind unter `/app/Http/Controllers/` zu finden. Jedes Objekt hat seinen eigenen Controller. Per Konvention haben die Controller mindestens folgende Methoden:

index(), show(), create(), store(), update(), destroy()

### Beispiel Meldung nach Erstellung eines Produktes
Die Meldung `Produkt wurde erfolgreich angelegt` wird in der Methode `store()`erstellt.

```php

 $request->session()->flash('status', __('Das Produkt <strong>:label</strong> wurde angelegt!', ['label' => request('prod_nummer')]));

```
Oft werden dynamische Inhalte in den Meldungen eingesetzt. Diese werden mit Platzhaltern realisiert. Im obigen Beispiel heißt der Platzhalter `label` und wird als Array übergeben. Platzhalter im Text werden mit einem ':' als Prefix ausgewiesen.
```php 

__('text :label1  :label2', ['label1' => 'wert_1', 'label2'=>'wert_2']));

```
In den Sprachdateien werden die Arrays nicht angegeben. Das obige Beispiel wäre in der Sprachdatei entsprechend:

```json 
{
    "text :label1  :label2":"übersetzter_text :label1  :label2"
}
```
