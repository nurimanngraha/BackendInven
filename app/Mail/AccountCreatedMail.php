<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $logoBase64;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        // Ambil gambar dan ubah ke base64
        $path = public_path('images/sanditel-logo.png');
        $this->logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($path));

        return $this->subject('Akun Anda Berhasil Dibuat di BackendInven')
                    ->view('emails.account-created')
                    ->with([
                        'user' => $this->user,
                        'logoBase64' => $this->logoBase64,
                    ]);
    }
}
