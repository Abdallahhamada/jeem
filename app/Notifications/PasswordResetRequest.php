<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetRequest extends Notification implements ShouldQueue
{
    use Queueable;    
    
    protected $token;    
    
    /*
    * Create a new notification instance.
    */   
    public function __construct($token){
        $this->token = $token;
    }    
    
    /*
    * Get the notification's delivery channels.
    */
    public function via($notifiable){
        return ['mail'];
    }     
    
    //------------ [ Get the mail representation of the notification. ] --------------------

    public function toMail($notifiable){

        /*
        |----------------------------------------------------------------------------------------
        |whenever request is handled from frontend, kindly check first config/app.php file line 
        |number 240 and then do the same toggle comment here on line 42 and 43
        |----------------------------------------------------------------------------------------
        */

        $password = config('app.passwordpath');

        // $url = url($password.$this->token);
        $url = url($password.'newpass/'.$this->token);        
        return (new MailMessage)
                    ->subject('Reset Password Request')
                    ->greeting('السلام عليكم')
                    ->salutation('جيم لحلول البناء')
                    ->line('لقد تلقينا طلبكم لإستعادة كلمة السر لحسابكم في موقع جيم')
                    ->action('إستعادة كلمة المرور الان', url($url))
                    ->line('إذا لم تقم بطلب إستعادة كلمة السر لايتطلب منك إتخاذ إي اجراء الان')
                    ->line('أفضل التحيات');
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