<?php

namespace App\Http\Controllers;

use App\ControlEquipment;
use App\ControlEvent;
use App\Equipment;
use App\EquipmentDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Location;
use App\Building;
use App\Room;

class PdfGenerator extends Controller
{
    static function makePDFEquipmentDataSheet($euqipment_id) {
        $title = __('Datenblatt');
        $html = view('pdf.html.datasheet_equipment',['equipment_id'=>$euqipment_id])->render();
        PDF::SetLineWidth( 1 );
        PDF::setHeaderCallback(function ($pdf) use ($title,$euqipment_id) {
            $inv = Equipment::find($euqipment_id)->eq_inventar_nr;
            $std_id= Equipment::find($euqipment_id)->standort->std_id;
            $val = $std_id . '||' . $inv;
            $style = array(
                'border' => 0,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            $pdf->SetTextColor(0);
            $pdf->ln(5);
            $pdf->SetFont('Helvetica', '', 22);
            $pdf->Cell(0, 14, $title, 0, 1, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, __('Druckdatum') .': '. date('d.m.Y') . ' | '.__('Lizenz-Nr').':  | '.__('Dokument-Nr').'.', 0, 1);
            //        $pdf->write1DBarcode($pdf->anlagenID,'C39',150, 10,50,5);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
            $pdf->write2DBarcode($val, 'QRCODE,M', 180, 5, 20, 20,  $style, 'N');

        });
        PDF::setFooterCallback(function ($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c)' . date('Y') . ' bitpack GmbH - testWare', 0, 0, 'L');
            $pdf->Cell(0, 5, __('Seite') . "{:png:} - {:ptg:}", 0, 1, 'R');
        });
        PDF::startPageGroup();
        PDF::SetTitle($title);
        PDF::SetAutoPageBreak(true, 50);
        PDF::SetMargins(24, 30, 10);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output($title.'_Stand_'.date('Y-m-d').'.pdf');


    }

    static function makePDFEquipmentControlReport(ControlEvent $controlEvent)
    {

        $controlEquipment = ControlEquipment::withTrashed()->find($controlEvent->control_equipment_id);

  //   dd($controlEquipment->equipment_id);

        $html = view('pdf.html.control_event_report',['controlEvent'=>$controlEvent])->render();
        PDF::SetLineWidth( 1 );
        $reportNo = 'PR'.str_pad($controlEvent->id,5,'0',STR_PAD_LEFT);

        PDF::setHeaderCallback(function ($pdf) use ($controlEquipment,$controlEvent,$reportNo) {
            $inv = Equipment::find($controlEquipment->equipment_id)->eq_inventar_nr;
            $std_id= Equipment::find($controlEquipment->equipment_id)->standort->std_id;
            $val = $std_id . '||' . $inv;
            $style = array(
                'border' => 0,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            $pdf->SetY(5);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, __('Druckdatum') .': '. date('d.m.Y') . ' | '.__('Lizenz-Nr').':  | '.__('Dokument-Nr'). $reportNo, 0, 1);
//            $pdf->write2DBarcode($val, 'QRCODE,M', 180, 5, 15, 15,  $style, 'N');
            $pdf->ImageSVG($file = '/img/icon/testWareLogo_greenYellow.svg', $x = 180, $y = 5, $w = '', $h = 10, '', $align = '', $palign = '', $border = 0, $fitonpage = false);

        });
        PDF::setFooterCallback(function ($pdf) use($controlEvent){
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c)' . date('Y') . ' bitpack GmbH - testWare', 0, 0, 'L');
            $pdf->Cell(0, 5, __('Seite') . "{:png:} - {:ptg:}", 0, 1, 'R');

        });

        PDF::startPageGroup();
        PDF::SetTitle('Prüfbericht');
        PDF::SetAutoPageBreak(true, 50);
        PDF::SetMargins(20, 25, 10);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        $y1 = PDF::GetY() ;

        $img_base64_encoded = explode('data:image/png;base64,',$controlEvent->control_event_controller_signature );

        PDF::Image('@'.base64_decode($img_base64_encoded[1]),10,$y1,90,40);
//
//        $pdf->SetAbsXY($pdf->GetX(),$y1+40);
//        $pdf->Cell(90, 5, $sig->sigName, 0, 0, 'L');

        EquipmentDoc::addReport(
            $controlEquipment->equipment_id,
            $reportNo.'.pdf',
            $reportNo
        );


        PDF::Output(storage_path('/app/equipment_docu/'.$controlEquipment->equipment_id.'/'.$reportNo.'.pdf'),'F');
        PDF::Output($reportNo.'.pdf');







    }

    static function makePDFEquipmentLabel($euqipment_id)
    {

        $html = view('pdf.html.qrcode_Equipment',['equipment'=>$euqipment_id])->render();
        PDF::SetLineWidth( 1 );

        PDF::setHeaderCallback(function ($pdf) use ($euqipment_id) {
            $inv = Equipment::find($euqipment_id)->eq_inventar_nr;
            $std_id= Equipment::find($euqipment_id)->standort->std_id;
            $val = $std_id . '||' . $inv;
            $style = array(
                'border' => 0,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );
            //        $pdf->write1DBarcode($pdf->anlagenID,'C39',150, 10,50,5);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 32, $y = 64, $w = '', $h = 20, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
            $pdf->write2DBarcode($val, 'QRCODE,M', 2, 22, 50, 50,  $style, 'N');
            $pdf->setY(5);
            $pdf->cell(0,5, __('Inventarnummer') .': ',0,1);
            $pdf->SetFont('Helvetica', '', 22);
            $pdf->cell(0,10, $inv,0,1);
        });

        PDF::SetAutoPageBreak(false);
        PDF::SetMargins(5, 5, 2);
        PDF::AddPage('P','E8');
        PDF::writeHTML($html, true, false, true, false, '');
        // D is the change of these two functions. Including D parameter will avoid
        // loading PDF in browser and allows downloading directly
        PDF::Output('QRCODE_'.date('Y-m-d').'.pdf');
    }


    static function makePDF($view,$title)
    {
//        dd($view,$title);

        $html = view('pdf.html.'.$view)->render();
        PDF::SetLineWidth( 1 );
        PDF::setHeaderCallback(function ($pdf) use ($title) {
            $pdf->SetTextColor(0);
            $pdf->ln(5);
            $pdf->SetFont('Helvetica', '', 22);
            $pdf->Cell(0, 14, $title, 0, 1, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, __('Druckdatum') .': '. date('d.m.Y') . ' | '.__('Lizenz-Nr').':  | '.__('Dokument-Nr').'.', 0, 1);
            //        $pdf->write1DBarcode($pdf->anlagenID,'C39',150, 10,50,5);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
        });
        PDF::setFooterCallback(function ($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c)' . date('Y') . ' bitpack.io GmbH - testWare', 0, 0, 'L');
            $pdf->Cell(0, 5, __('Seite') . "{:png:} - {:ptg:}", 0, 1, 'R');
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
