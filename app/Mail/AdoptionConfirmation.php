<?php
namespace App\Mail;

use App\Models\Pet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdoptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $pet;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('adopt.adoption-confirmation')
                    ->with([
                        'petName' => $this->pet->name,
                    ]);
    }
}
