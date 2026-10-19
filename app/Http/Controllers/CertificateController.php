<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use TCPDF;
use App\Jobs\SendCertificateJob;

class CertificateController extends Controller
{
    private function generatePDF($event, $participants)
    {
        $pdf = new TCPDF('L', 'mm', 'A4');
        
        $pdf->SetMargins(0, 0, 0, true);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $templatePath = storage_path('app/public/' . $event->template_path);
        list($r, $g, $b) = sscanf($event->text_color, "#%02x%02x%02x");

        foreach ($participants as $participant) {
            $pdf->AddPage('L', 'A4');
            
            if ($event->template_path && file_exists($templatePath)) {
                $pdf->Image($templatePath, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
            }

            $pdf->SetFont($event->font_family, 'B', $event->font_size);
            $pdf->SetTextColor($r, $g, $b);
            
            $pdf->SetXY(0, $event->y_coord);
            $pdf->Cell(297, 0, mb_strtoupper($participant->full_name, 'UTF-8'), 0, 1, 'C', 0, '', 0, false, 'T', 'T');
        }

        return $pdf;
    }

    public function preview(Event $event)
    {
        $dummyParticipant = new Participant(['full_name' => 'NOMBRE DEL PROTAGONISTA']);
        $pdf = $this->generatePDF($event, [$dummyParticipant]);
        
        if (ob_get_length()) ob_end_clean();
        return response($pdf->Output('vista_previa_' . $event->title . '.pdf', 'D'))->header('Content-Type', 'application/pdf');
    }

    public function downloadIndividual(Participant $participant)
    {
        $event = $participant->event;
        $pdf = $this->generatePDF($event, [$participant]);
        
        if (ob_get_length()) ob_end_clean();
        return response($pdf->Output($participant->full_name . '.pdf', 'D'))->header('Content-Type', 'application/pdf');
    }

    public function downloadBulk(Event $event)
    {
        $participants = $event->participants;
        if($participants->isEmpty()){
            return back()->with('error', 'No existen participantes registrados en este evento.');
        }
        $pdf = $this->generatePDF($event, $participants);
        
        if (ob_get_length()) ob_end_clean();
        return response($pdf->Output('Consolidado_'.$event->title.'.pdf', 'D'))->header('Content-Type', 'application/pdf');
    }

    public function sendBulkEmails(Event $event)
    {
        $participants = $event->participants;
        if($participants->isEmpty()){
            return back()->with('error', 'No existen participantes para enviar correos.');
        }

        foreach ($participants as $participant) {
            SendCertificateJob::dispatch($participant, $event);
        }

        return back()->with('success', 'La emisión de certificados se está procesando en segundo plano.');
    }
}