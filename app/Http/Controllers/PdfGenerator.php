<?php

namespace App\Http\Controllers;

use App\ControlEquipment;
use App\ControlEvent;
use App\Equipment;
use App\EquipmentDoc;
use App\EquipmentLabel;
use App\EquipmentUid;
use App\Produkt;
use App\Report;
use App\TestReportFormat;
use PDF;

class PdfGenerator extends Controller
{
    static function makePDFEquipmentDataSheet($euqipment_id)
    {
        $inv = Equipment::find($euqipment_id)->eq_inventar_nr;
        $title = __('Datenblatt') . ' ' . $inv;
        $html = view('pdf.html.datasheet_equipment', ['equipment_id' => $euqipment_id])->render();
        PDF::SetLineWidth(1);
        PDF::setHeaderCallback(function ($pdf) use ($title, $euqipment_id) {
            $inv = Equipment::find($euqipment_id)->eq_inventar_nr;
            $storage_uid = Equipment::find($euqipment_id)->storage->storage_uid;
            $val = $storage_uid . '||' . $inv;
            $style = [
                'border'        => 0,
                'vpadding'      => 'auto',
                'hpadding'      => 'auto',
                'fgcolor'       => [
                    0,
                    0,
                    0
                ],
                'bgcolor'       => false,
                //array(255,255,255)
                'module_width'  => 1,
                // width of a single module in points
                'module_height' => 1
                // height of a single module in points
            ];
            $pdf->SetTextColor(0);
            $pdf->ln(5);
            $pdf->SetFont('Helvetica', '', 22);
            $pdf->Cell(0, 14, $title, 0, 1, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, __('Druckdatum') . ': ' . date('d.m.Y'), 0, 1);
            //        $pdf->write1DBarcode($pdf->anlagenID,'C39',150, 10,50,5);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
            $pdf->write2DBarcode($val, 'QRCODE,M', 180, 5, 20, 20, $style, 'N');
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

        PDF::Output($title . '_Stand_' . date('Y-m-d') . '.pdf');
    }

    static function makePDFEquipmentControlReport(ControlEvent $controlEvent)
    {
        $controlEquipment = ControlEquipment::withTrashed()->find($controlEvent->control_equipment_id);

        //   dd($controlEquipment->equipment_id);

        $reportNo = (new TestReportFormat)->makeTestreportNumber($controlEvent->id);
        $html = view('pdf.html.control_event_report', [
            'controlEvent' => $controlEvent,
            'reportNo' =>$reportNo,
        ])->render();
        PDF::SetLineWidth(1);


        PDF::setHeaderCallback(function ($pdf) use ($reportNo) {
            $pdf->SetY(5);
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, __('Druckdatum') . ': ' . date('d.m.Y') . ' | ' . __('Dokument-Nr') . ': ' . $reportNo, 0, 1);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
        });
        PDF::setFooterCallback(function ($pdf) use ($controlEvent) {
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c)' . date('Y') . ' bitpack GmbH - testWare', 0, 0, 'L');
            $pdf->Cell(0, 5, __('Seite') . "{:png:} - {:ptg:}", 0, 1, 'R');
        });

        PDF::startPageGroup();
        PDF::SetTitle(__('Prüfbericht') . ' ' . $reportNo);
        PDF::SetAutoPageBreak(true, 30);
        PDF::SetMargins(24, 10, 10);
        PDF::AddPage();

        if ($controlEvent->control_event_controller_signature) {
            $img_base64_encoded = explode('data:image/png;base64,', $controlEvent->control_event_controller_signature);

            PDF::Image('@' . base64_decode($img_base64_encoded[1]), 24, 170, 100, '');
            //
            //        $pdf->SetAbsXY($pdf->GetX(),$y1+40);
            //        $pdf->Cell(90, 5, $sig->sigName, 0, 0, 'L');
        }
        PDF::writeHTML($html, true, false, true, false, '');
        EquipmentDoc::addReport($controlEquipment->equipment_id, $reportNo . '.pdf', $reportNo);


        PDF::Output(storage_path('/app/equipment_files/' . $controlEquipment->equipment_id . '/' . $reportNo . '.pdf'), 'F');
        PDF::Output($reportNo . '.pdf');
    }

    static function makePDFLabel(int $label_id, int $equipment_id = NULL)
    {

        if (!$label_id) return false;
        if (isset($equipment_id)){
            $equipment = Equipment::find($equipment_id);
            $data = [
                'uid' => EquipmentUid::where('equipment_id', $equipment_id)->first()->equipment_uid,
                'inventary' => $equipment->eq_inventar_nr,
                'location' => $equipment->storage->storage_label,
            ];
        } else {
            $data = [
                'uid' => '',
                'inventary' => '5584828.12-1',
                'location' => 'PAS1223254',
            ];
        }

        PdfGenerator::makePDFEquipmentLabel($data, EquipmentLabel::find($label_id));
        PDF::Output('QRCODE_' . $data['inventary'] . '_' . date('Y-m-d') . '.pdf','I');

    }

    static function printEquipmentLabels(Produkt $produkt){
        $label_id = $produkt->equipment_label_id;
        foreach(Equipment::where('produkt_id', $produkt->id)->get() as $equipmemnt){
            PdfGenerator::makePDFLabel($label_id,$equipmemnt->id);
        }
    }


    static function makePDFEquipmentLabel(array $data, EquipmentLabel $equipmentLabel)
    {

        $ratio = ($equipmentLabel->Label_h >= $equipmentLabel->label_w) ? 'P' : 'L';
//        $html = view('pdf.html.qrcode_Equipment', ['equipment' => $euqipment_id])->render();
        PDF::SetLineWidth(1);
        PDF::setHeaderCallback(function ($pdf) use ($data, $equipmentLabel, $ratio) {
            $hRatio = 12;
            $thRatio = 8;
            $valRatio = 5;

            $val = env('APP_URL') . '/edata/' . env('APP_HSKEY') . $data['uid'];

            $style = [
                'border'        => 0,
                'vpadding'      => 0,
                'hpadding'      => 0,
                'fgcolor'       => [
                    0,
                    0,
                    0
                ],
                'bgcolor'       => false,
                //array(255,255,255)
                'module_width'  => 1,
                // width of a single module in points
                'module_height' => 1
                // height of a single module in points
            ];

            if ($equipmentLabel->logo_svg!=='') {
                $pdf->ImageSVG('@' . $equipmentLabel->logo_svg, $x = $equipmentLabel->logo_x, $y = $equipmentLabel->logo_y, $w = $equipmentLabel->logo_w, $h = $equipmentLabel->logo_h, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
            }

            $qrCodeQidth = $equipmentLabel->label_w - $equipmentLabel->label_ml - $equipmentLabel->label_mr -2;

            $pdf->write2DBarcode($val, 'QRCODE,H',   ($equipmentLabel->qrcode_x + $equipmentLabel->label_mt), ($equipmentLabel->qrcode_y + $equipmentLabel->label_ml) , $qrCodeQidth, $qrCodeQidth, $style, 'N');

            if ($equipmentLabel->show_labels) {
                $pdf->SetFont('Helvetica', '', $equipmentLabel->Label_h/$thRatio);
                $pdf->Cell(0, $equipmentLabel->Label_h/$hRatio, __('Inventarnummer ').': ', 0,1);
            }

            if ($equipmentLabel->show_inventory) {
                $pdf->SetFont('Helvetica', 'B', $equipmentLabel->Label_h/$valRatio);
                // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
                $pdf->MultiCell(0, $equipmentLabel->Label_h/$hRatio, $data['inventary'], 0, 'L', 0, 1);
            }

            if ($equipmentLabel->show_labels) {
                $pdf->SetFont('Helvetica', '', $equipmentLabel->Label_h/$thRatio);
                $pdf->cell(0, $equipmentLabel->Label_h/$hRatio, __('Stellplatz').': ', 0, 1);
            }

            if ($equipmentLabel->show_location) {
                $pdf->SetFont('Helvetica', 'B', $equipmentLabel->Label_h/$valRatio);
                $pdf->MultiCell(0, $equipmentLabel->Label_h/$hRatio, $data['location'], 0,'L',0, 1);
            }
        });
        PDF::setTitle('QRCODE_' . $data['inventary'] . '_' . date('Y-m-d'));
        PDF::SetAutoPageBreak(false);
        PDF::SetMargins($equipmentLabel->label_ml, $equipmentLabel->label_mt, $equipmentLabel->label_mr);
        PDF::AddPage($ratio, [
            $equipmentLabel->Label_h,
            $equipmentLabel->label_w
        ]);
        //        PDF::writeHTML($html, true, false, true, false, '');
        // D is the change of these two functions. Including D parameter will avoid
        // loading PDF in browser and allows downloading directly
    }


    static function makePDF($view, $title)
    {
        //        dd($view,$title);

        $html = view('pdf.html.' . $view)->render();
        PDF::SetLineWidth(1);
        PDF::setHeaderCallback(function ($pdf) use ($title) {
            $pdf->SetTextColor(0);
            $pdf->ln(5);
            $pdf->SetFont('Helvetica', '', 22);
            $pdf->Cell(0, 14, $title, 0, 1, 'L');
            $pdf->SetFont('Helvetica', '', 8);
            $pdf->Cell(0, 5, __('Druckdatum') . ': ' . date('d.m.Y') . ' | ' . __('Lizenz-Nr') . ':  | ' . __('Dokument-Nr') . '.', 0, 1);
            //        $pdf->write1DBarcode($pdf->anlagenID,'C39',150, 10,50,5);
            $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
        });
        PDF::setFooterCallback(function ($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c) 2020 - ' . date('Y') . ' bitpack.io GmbH - testWare', 0, 0, 'L');
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
        PDF::Output($title . '_Stand_' . date('Y-m-d') . '.pdf');
    }

    static function printReport($id)
    {
        $report = Report::find($id);
        $title = $report->name;
        $html = view('reports.view.' . $report->view)->render();

        PDF::SetLineWidth(1);
        PDF::setHeaderCallback(function ($pdf) use ($report) {
            $pdf->SetTextColor(0);
            $pdf->ln(5);
            $pdf->SetFont('Helvetica', '', 11);
            $pdf->Cell(100, 14, $report->label, 0, 0, 'L');
            $pdf->Cell(0, 14, $report->name, 0, 1, 'R');
            $pdf->SetFont('Helvetica', '', 8);
            ($report->orientation === 'P') ? $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 24, $y = 282, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false) : $pdf->ImageSVG($file = '/img/icon/bitpackio.svg', $x = 10, $y = 195, $w = '', $h = 15, '', $align = '', $palign = '', $border = 0, $fitonpage = false);
        });
        PDF::setFooterCallback(function ($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('Helvetica', '', 8);
            //Page number
            $pdf->Cell(0, 5, '(c) 2020 - ' . date('Y') . ' bitpack.io GmbH - testWare', 0, 0, 'L');
            $pdf->Cell(0, 5, __('Seite') . "{:png:} - {:ptg:}", 0, 1, 'R');
        });
        PDF::startPageGroup();
        PDF::SetTitle($title);
        if ($report->orientation === 'P') {
            PDF::SetAutoPageBreak(true, 50);
            PDF::SetMargins(24, 30, 10);
        } else {
            PDF::SetAutoPageBreak(true, 20);
            PDF::SetMargins(10, 10, 10);
        }

        PDF::AddPage($report->orientation);
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output($report->view . '_printed_' . date('Y-m-d') . '.pdf');
    }
}
