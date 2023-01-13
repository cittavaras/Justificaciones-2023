<?php

namespace App\Listeners\Justification\Approved;

use App\Events\Justification\Approved as JustificationApproved;
use App\Mail\Justification\Approved\ToTeacher as JustificationApprovedEmail;
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
    public function handle(JustificationApproved $event)
    {
        $justifications = Justification::whereFolio($event->justification->NFOLIO)->get();
        $student = DB::table('datos_semestre')
            ->where('CORREO_ALUM', $event->justification->CORREO_ALUM)
            ->where('NOM_ASIG', $event->justification->ASIGNATURA)
            ->first();

        foreach ($justifications as $justification) {
            $email = $justification->CORREO_DOC;
            Mail::to($email)->send(new JustificationApprovedEmail(
                $justification, $student
            ));
        }
    }
}
