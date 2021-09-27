<?php

namespace App\Notifications;

use App\Equipment;
use App\EquipmentEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentEventCreated extends Notification
{
    use Queueable;

    protected $equipmentEvent;

    /**
     * Create a new notification instance.
     *
     * @param  EquipmentEvent $eevent
     */
    public function __construct(EquipmentEvent $equipmentEvent)
    {
        $this->equipmentEvent = $equipmentEvent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $equipment = Equipment::find($this->equipmentEvent->equipment_id)->first();
        $url = 'http://testware.hub.bitpack.io/equipment/'.$equipment->eq_inventar_nr;
        return (new MailMessage)
            ->subject('testWare Serviceinfo: Neue Schadensmeldung eingegangen!')
            ->greeting('Hallo !')
                    ->line('Es wurde eine Schadensmeldung für ein Geräte erzeugt. Bitte prüfen Sie den Vorgang in der testWare.')
                    ->action('Direkter Link zum Gerät', url($url))
                    ->line('Diese Meldung erscheint auch in Ihrem Dashboard, wenn Sie sich das nächste mal anmelden!')
                    ->line('Ihr testWare Team');
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
            'userid'=>$this->equipmentEvent->equipment_event_user,
            'message'=>$this->equipmentEvent->equipment_event_item_text,
            'header'=>__('Neues Ereignis'),
            'eventid'=>$this->equipmentEvent->equipment_event_id,
            'detailLink'=>route('event.show',$this->equipmentEvent->equipment_event_id)
        ];
    }
}
