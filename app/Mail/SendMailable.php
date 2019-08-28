<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $reference_number;
    public $type;
    public $attatch;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $reference_number, $type, $UserCompany, $company, $attatch, $path)
    {
        $this->name = $name;
        $this->reference_number = $reference_number;
        $this->type = $type;
        $this->company = $company;
        $this->attatch = $attatch;
        $this->path = $path;
        $this->userCompany = $UserCompany;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vinventory.pvtltd@gmail.com', config('adminlte.title', 'AdminLTE 2'))
            ->subject($this->type . ' (' . $this->reference_number . ') From ' . $this->company)
            ->markdown($this->path)
            ->with([
                'name' => $this->name,
                'reference_number' => $this->reference_number,
                'company' => $this->company,
                'userCompany' => $this->userCompany,
            ])->attachData($this->attatch, $this->reference_number . '.pdf');
    }
}
