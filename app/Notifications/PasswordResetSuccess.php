<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class PasswordResetSuccess extends Notification implements ShouldQueue
{
    use Queueable;
    
    /*
    * Create a new notification instance.
    */
    public function __construct(){
        //
    }    
    
    /*
    * Get the notification's delivery channels.
    */
    public function via($notifiable){
        return ['mail'];
    }    
    
    //------------ [ Get the mail representation of the notification. ] --------------------

    public function toMail($notifiable)
    {
        return (new MailMessage) 
            ->greeting('أهلا بكم من جديد')
            ->line('لقد قمت بتغيير كلمة المرور بنجاح')
            ->line('إذا قمت بتغيير كلمة المرور لايتطلب منكم القيام بإي إجراء اخر')
            ->line('إذا لم تقم بتغيير كلمة المرور يرجى التواصل معنا فوراً ')
            ->line('أفضل التحيات')
            ->salutation('جيم لحلول البناء');
    }
    
    /*
     * Get the array representation of the notification.
    */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}