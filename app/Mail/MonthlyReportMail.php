<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MonthlyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $totalGastado;
    public $mes;

    public function __construct($totalGastado, $mes)
    {
        $this->totalGastado = $totalGastado;
        $this->mes = $mes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Resumen de Gastos - {$this->mes}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.monthly-report',
        );
    }
}
