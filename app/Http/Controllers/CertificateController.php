<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use setasign\Fpdi\Tcpdf\Fpdi;
use App\Jobs\SendCertificateJob;

class CertificateController extends Controller
{
    private function generatePDF($event, $participants)
    {
        $pdf = new Fpdi('L', 'mm', 'A4');
        $pdf->SetAutoPageBreak(false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $templatePath = storage_path('app/public/' . $event->template_path);
        $ext = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));

        foreach ($participants as $participant) {
            $pdf->AddPage('L', 'A4');
            
            if ($ext === 'pdf') {
                $pdf->setSourceFile($templatePath);
                $tplIdx = $pdf->importPage(1);
                $pdf->useTemplate($tplIdx, 0, 0, 297, 210);
            } else {
                $pdf->Image($templatePath, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
            }

            $pdf->SetFont('helvetica', 'B', 24);
            $pdf->SetTextColor(13, 71, 161); // Azul oscuro CNFD
            
            // Si quieres que el texto esté centrado, la coordenada X debería ser 0 y le damos el ancho total
            $pdf->SetXY(0, $event->y_coord);
            $pdf->Cell(297, 10, mb_strtoupper($participant->full_name, 'UTF-8'), 0, 1, 'C');
        }

        return $pdf;
    }

    public function preview(Event $event)
    {
        $dummyParticipant = new Participant(['full_name' => 'NOMBRE DEL PROTAGONISTA DE PRUEBA']);
        $pdf = $this->generatePDF($event, [$dummyParticipant]);
        return response($pdf->Output('preview.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }

    public function downloadIndividual(Participant $participant)
    {
        $event = $participant->event;
        $pdf = $this->generatePDF($event, [$participant]);
        return response($pdf->Output($participant->full_name . '.pdf', 'D'))->header('Content-Type', 'application/pdf');
    }

    public function downloadBulk(Event $event)
    {
        $participants = $event->participants;
        if($participants->isEmpty()){
            return back()->with('error', 'No hay participantes registrados todavía.');
        }
        $pdf = $this->generatePDF($event, $participants);
        return response($pdf->Output('Consolidado_'.$event->title.'.pdf', 'D'))->header('Content-Type', 'application/pdf');
    }

    public function sendBulkEmails(Event $event)
    {
        $participants = $event->participants;
        if($participants->isEmpty()){
            return back()->with('error', 'Ideay, no hay a quién enviarle correos.');
        }

        foreach ($participants as $participant) {
            SendCertificateJob::dispatch($participant, $event);
        }

        return back()->with('success', 'Los certificados se están enviando en segundo plano. Podés seguir usando el sistema.');
    }
}