<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Model\PasswordReset;

class WelcomeNotification extends Notification
{
    use Queueable;
	
	private $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data  = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
                    // ->line('The introduction to the notification.')
                    // ->action('Notification Action', url('/'))
                    // ->line('Thank you for using our application!');
					
		$subject = 'Welcome to '. env('APP_NAME','Laravel');
		
		return (new MailMessage)
            ->subject($subject)
            ->line('You are receiving this email an account for you was created.')
            ->action('Set initial password', url($this->generateUrl()))
            ->line('This welcome link will expire after set initial password.');			
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
            //
        ];
    }
	
	private function generateToken(){
		//Generate a new reset password token
		$token = app('auth.password.broker')->createToken($this->data);
		PasswordReset::where(['email'=>$this->data->email])->update(['token'=>$token]);
		return $token; 
		
	}
	
	private function generateUrl(){
		return url('password/set/'.$this->generateToken().'?email='.$this->data->email);
	}
}
