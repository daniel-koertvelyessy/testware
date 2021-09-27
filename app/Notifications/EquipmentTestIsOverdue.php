<?php

namespace App\Notifications;

use App\ControlEquipment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentTestIsOverdue extends Notification
{
    use Queueable;

    public $controlEquipment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ControlEquipment $controlEquipment)
    {
        $this->controlEquipment = $controlEquipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'userid'=>NULL,
            'message'=>__('Die Prüfung :testname des Gerätes :eqname ist überfällig. Das Geräte wurde daher gesperrt!',
                [
                    'eqname'=>$this->controlEquipment->Equipment->eq_name,
                    'testname'=>$this->controlEquipment->Anforderung->an_name,
                ]),
            'eventid'=>$this->controlEquipment->id,
            'header'=>__('Prüfung überfällig'),
            'detailLink'=>route('equipment.show',$this->controlEquipment->Equipment->eq_inventar_nr)
        ];
    }
}
