<?php

namespace App\Notifications;

use App\Models\Incidencia;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncidenciaResuelta extends Notification
{
    use Queueable;

    protected $incidencia;

    public function __construct(Incidencia $incidencia)
    {
        $this->incidencia = $incidencia;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $nombre = isset($notifiable->name) ? $notifiable->name : 'Equipo de Operaciones';

        $mail = (new MailMessage)
            ->subject('Incidencia Resuelta - RENOSA Flota')
            ->greeting('¡Hola ' . $nombre . '!')
            ->line('Te informamos que el reporte de la unidad con placa ' . $this->incidencia->placa . ' ha sido solventado.')
            ->line('Detalle del reporte: ' . $this->incidencia->descripcion);

        if (!empty($this->incidencia->comentarios)) {
            $mail->line('Nota de resolución: ' . $this->incidencia->comentarios);
        }

        return $mail
            ->action('Ver Muro Operativo', url('/muro'))
            ->line('Gracias por colaborar en la gestión de flota.')
            ->salutation('Atentamente,' . PHP_EOL . 'Auxiliar de Operaciones');
    }
}