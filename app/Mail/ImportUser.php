<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImportUser extends Mailable
{
    use Queueable, SerializesModels;

    public $failure, $success;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->failure = session()->get('failedRows');

        $this->success = session()->get('acceptedRows');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('import excel file')->markdown('mails.import');

    }
}
