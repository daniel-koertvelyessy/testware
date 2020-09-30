<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Location;
use App\Building;
use App\Room;

class PdfGenerator extends Controller
{


    static function makePDF($view,$title)
    {
//        dd($view,$title);

        $html = view('pdf.html.'.$view)->render();
        PDF::SetLineWidth( 1 );
        PDF::setHeaderCallback(function ($pdf) {
            $pdf->SetTextColor(0);
            $pdf->ln(5);
            $pdf->SetFont('Helvetica', '', 22);
            $pdf->Cell(0, 14, 'Standortbericht ', 0, 1, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, 'Druckdatum: ' . date('d.m.Y') . ' | Lizenz-Nr:  | Dokument-Nr.', 0, 1);
            //        $pdf->write1DBarcode($pdf->anlagenID,'C39',150, 10,50,5);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
        });
        PDF::setFooterCallback(function ($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c)' . date('Y') . ' bitpack GmbH - testWare', 0, 0, 'L');
            $pdf->Cell(0, 5, 'Seite ' . "{:png:} - {:ptg:}", 0, 1, 'R');
        });
        PDF::startPageGroup();
        PDF::SetTitle($title);
        PDF::SetAutoPageBreak(true, 50);
        PDF::SetMargins(24, 30, 10);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        // D is the change of these two functions. Including D parameter will avoid
        // loading PDF in browser and allows downloading directly
        PDF::Output($title.'_Stand_'.date('Y-m-d').'.pdf');

    }

}
