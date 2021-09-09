@extends('layout.layout-login')

@section('content')

@php
// Grundlegende Abfolge bei LDAP ist verbinden, binden, suchen,
// interpretieren des Sucheergebnisses, Verbindung schließen

echo "<h3>LDAP query Test</h3>";
echo "Verbindung ...";
$ds=ldap_connect("dc01.bln.thermo-control.com");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
echo "Ergebnis der Verbindung: ".$ds."<br />";




if ($ds) {
    echo "Bindung ...";
    $r=ldap_bind($ds);     // das ist ein "anonymer" bind,
    // typischerweise nur Lese Zugriff
    echo "Ergebnis der Bindung ".$r."<br />";

    $dn = "DC=bln.thermo-control,DC=com";
    $filter = "(CN=*)";
    $result = ldap_search($ds, $dn, $filter);
#    echo "Ergebnis der Suche ".$sr."<br />";
#
    echo "Anzahl gefundenen Einträge ".ldap_count_entries($ds,$sr)."<br />";
#
#    echo "Einträge holen ...<br />";
#    $info = ldap_get_entries($ds, $sr);
#    echo "Daten für ".$info["count"]." Items gefunden:<br />";
#
#    for ($i=0; $i<$info["count"]; $i++) {
#        echo "dn ist: ". $info[$i]["dn"] ."<br />";
#        echo "erster cn Eintrag: ". $info[$i]["cn"][0] ."<br />";
#        echo "erster email Eintrag: ". $info[$i]["mail"][0] ."<br /><hr />";
#    }

    echo "Verbindung schließen";
    ldap_close($ds);

} else {
    echo "<h4>Verbindung zum LDAP Server nicht möglich</h4>";
}

@endphp

@endsection
