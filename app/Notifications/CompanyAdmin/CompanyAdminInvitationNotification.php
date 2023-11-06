<?php

namespace App\Notifications\CompanyAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompanyAdminInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $user, public $company, public $password, public $lang)
    {
        //
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
        //             ->subject('Admin Invitation')
        //             ->line('You have been invited as a company admin.')
        //             ->line('Please use this password for login: '.$this->password)
        //             ->action('Login', route('login'))
        //             ->line('Thank you for using our application!');

        return (new MailMessage)
            ->subject(trans('OnDoc Company Admin Access Invitation', [], $this->lang))
            ->view('mail.auth.company-admin.company-admin-invitation', [
                'user'=>$this->user, 'company'=> $this->company, 'lang'=>$this->lang, 'password'  => $this->password
            ])
            ;
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
}
