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
        $pdf->SetMargins(0, 0, 0, true);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $templatePath = storage_path('app/public/' . $this->event->template_path);

        $pdf->AddPage('L', 'A4');
        $pdf->Image($templatePath, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);

        list($r, $g, $b) = sscanf($this->event->text_color, "#%02x%02x%02x");
        $pdf->SetFont($this->event->font_family, 'B', $this->event->font_size);
        $pdf->SetTextColor($r, $g, $b);
        
        $pdf->SetXY(0, $this->event->y_coord);
        $pdf->Cell(297, 0, mb_strtoupper($this->participant->full_name, 'UTF-8'), 0, 1, 'C', 0, '', 0, false, 'T', 'T');

        $fileName = 'certificados_temp/cert_' . $this->participant->id . '.pdf';
        Storage::disk('local')->put($fileName, $pdf->Output('', 'S'));

        Mail::to($this->participant->email)->send(new CertificateMail($this->participant, $this->event, storage_path('app/' . $fileName)));

        Storage::disk('local')->delete($fileName);
    }
}