<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge"
    >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
          crossorigin="anonymous"
    >
    <title>Inventurbericht</title>
</head>
<body class="container">

<h1>Inventurbericht</h1>
<?php

$sumNew = 0;
$sumTotal = 0;
$sumUsed = 0;
$sumLocked = 0;
$countTotal = 0;
$countLocked = 0;
$countUsed = 0;
?>
<table cellspacing="0"
       cellpadding="3"
       border="1"
       class="table table-responsive-md table-striped"
>
    <thead>
    <tr style="font-size: 11pt; font-weight: bold;">
        <th style="width: 250px">Gerät</th>
        <th style="width: 105px">Inventarnummer</th>
        <th style="width: 100px">Status</th>
        <th style="width: 75px">Gekauft</th>
        <th style=",text-align: right; width: 55px">Abschr</th>
        <th style="text-align: right; width: 80px">Wert neu</th>
        <th style="text-align: right; width: 80px">Wert aktuell</th>
    </tr>
    </thead>
    <tbody>
    @forelse(\App\Equipment::with('EquipmentState')->take(200)->get() as $equipment)
        <?php
        $LaufZeit = 10;
        $deltaYear = date('Y') - date('Y', strtotime($equipment->purchased_at));
        $wert = $equipment->eq_price / $LaufZeit;
        $RestWert = $equipment->eq_price - $wert * $deltaYear;
        $sumNew += $equipment->eq_price;
        $sumTotal += $RestWert;
        $countTotal++;
        if ($equipment->EquipmentState->id === 1 || $equipment->EquipmentState->id === 2) {
            $sumUsed += $RestWert;
            $countUsed++;
        }

        if ($equipment->EquipmentState->id > 2) {
            $sumLocked += $RestWert;
            $countLocked++;
        }

        ?>
        <tr style="font-size: 11pt;">
            <td style="width: 250px">{{ $equipment->eq_name }}</td>
            <td style="width: 105px">{{ str_limit($equipment->eq_inventar_nr,15) }}</td>
            <td style="width: 100px">{{ $equipment->EquipmentState->estat_label }}</td>
            <td style="width: 75px">{{ $equipment->purchased_at }}</td>
            <td style="width: 55px">{{ $LaufZeit }}</td>
            <td style="text-align: right; width: 80px">{{ number_format($equipment->eq_price,2,',','.') }}</td>
            <td style="text-align: right; width: 80px">{{ number_format($RestWert,2,',','.') }}</td>
        </tr>
    @empty

    @endforelse
    </tbody>
</table>
<div style="page-break-before:always">
    <h2>Zusammenfassung</h2>
    <h3>Anzahl Geräte</h3>
    <table cellspacing="0"
           cellpadding="3"
           border="1"
           nobr="true"
    >
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">Gesamt Geräte</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ $countTotal }}</td>
        </tr>
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">davon in Benutzung</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ $countUsed }}</td>
        </tr>
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">in Reparatur / gesperrt</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ $countLocked }}</td>
        </tr>
    </table>

    <h3>Finanziell</h3>
    <table cellspacing="0"
           cellpadding="3"
           border="1"
           nobr="true"
    >
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">Gesamt (Neubeschaffung)</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ number_format($sumNew,2,',','.') }}</td>
        </tr>
        <tr>
            <td colspan="2">Werte (Abschreibung berücksichtigt)</td>
        </tr>
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">Gesamt</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ number_format($sumTotal,2,',','.') }}</td>
        </tr>
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">In Benutzung</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ number_format($sumUsed,2,',','.') }}</td>
        </tr>
        <tr>
            <th style="width: 200px; font-size: 11pt; font-weight: bold;">Gesperrt</th>
            <td style="width: 200px; font-size: 11pt; text-align: right;">{{ number_format($sumLocked,2,',','.') }}</td>
        </tr>


    </table>
</div>

</body>
</html>
