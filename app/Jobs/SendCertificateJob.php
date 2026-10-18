<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Participant;
use App\Mail\CertificateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;

class SendCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $participant;
    protected $event;

    public function __construct(Participant $participant, Event $event)
    {
        $this->participant = $participant;
        $this->event = $event;
    }

    public function handle(): void
    {
        $pdf = new Fpdi('L', 'mm', 'A4');
        $pdf->SetAutoPageBreak(false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $templatePath = storage_path('app/public/' . $this->event->template_path);
        $ext = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));

        $pdf->AddPage('L', 'A4');
        if ($ext === 'pdf') {
            $pdf->setSourceFile($templatePath);
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 297, 210);
        } else {
            $pdf->Image($templatePath, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        }

        $pdf->SetFont('helvetica', 'B', 24);
        $pdf->SetTextColor(13, 71, 161);
        $pdf->SetXY(0, $this->event->y_coord);
        $pdf->Cell(297, 10, mb_strtoupper($this->participant->full_name, 'UTF-8'), 0, 1, 'C');

        $fileName = 'certificados_temp/cert_' . $this->participant->id . '.pdf';
        Storage::disk('local')->put($fileName, $pdf->Output('', 'S'));

        Mail::to($this->participant->email)->send(new CertificateMail($this->participant, $this->event, storage_path('app/' . $fileName)));

        Storage::disk('local')->delete($fileName);
    }
}