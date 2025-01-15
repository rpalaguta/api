<?php

namespace App\Mail;

use App\Models\TimeSlot;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TimeSlotReserved extends Mailable
{
    use Queueable, SerializesModels;

    public $timeSlot;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\TimeSlot $timeSlot
     */
    public function __construct(TimeSlot $timeSlot)
    {
        $this->timeSlot = $timeSlot;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Time Slot Reserved')
                    ->view('emails.timeslot_reserved')
                    ->with(['timeSlot' => $this->timeSlot]);
    }
}
