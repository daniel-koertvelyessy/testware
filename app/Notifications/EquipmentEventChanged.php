<?php

namespace App\Notifications;

use App\EquipmentEventItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentEventChanged extends Notification
{
    use Queueable;

    protected $equipmentEventItem;

    /**
     * Create a new notification instance.
     */
    public function __construct(EquipmentEventItem $equipmentEventItem)
    {
        $this->equipmentEventItem = $equipmentEventItem;
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
            'userid' => $this->equipmentEventItem->equipment_event_user,
            'message' => $this->equipmentEventItem->equipment_event_item_text,
            'header' => __('Ereignis geändert'),
            'eventid' => $this->equipmentEventItem->equipment_event_id,
            'detailLink' => route('event.show', $this->equipmentEventItem->equipment_event_id),
        ];
    }
}
