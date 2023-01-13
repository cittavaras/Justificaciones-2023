<?php

namespace App\Listeners\Justification\Rejected;

use App\Events\Justification\Rejected as JustificationRejected;
use App\Mail\Justification\Rejected\ToTeacher as JustificationRejectedEmail;
use App\Justification;
use Mail;
use DB;

class SendEmailToTeacher
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(JustificationRejected $event)
    {
        $justifications = Justification::whereFolio($event->justification->NFOLIO)->get();
        $student = DB::table('datos_semestre')
            ->where('CORREO_ALUM', $event->justification->CORREO_ALUM)
            ->where('NOM_ASIG', $event->justification->ASIGNATURA)
            ->first();

        foreach ($justifications as $justification) {
            $email = $justification->CORREO_DOC;
            Mail::to($email)->send(new JustificationRejectedEmail(
                $justification, $student
            ));
        }
    }
}
