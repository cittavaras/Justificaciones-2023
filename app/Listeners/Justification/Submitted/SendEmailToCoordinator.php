<?php

namespace App\Listeners\Justification\Submitted;

use App\Events\Justification\Submitted as JustificationSubmitted;
use App\Mail\Justification\Submitted\ToCoordinator as JustificationSubmittedEmail;
use App\Justification;
use Mail;
use DB;

class SendEmailToCoordinator
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
    public function handle(JustificationSubmitted $event)
    {
        $justifications = Justification::whereFolio($event->folio)->get();
        $student = DB::table('datos_semestre')
            ->where('correo_alum', $justifications[0]->CORREO_ALUM)
            ->whereIn('CORREO_DOC', $justifications->unique('CORREO_DOC')->pluck('CORREO_DOC'))
            ->get();

        $teachers = [];
        foreach ($student as $a) {
            array_push($teachers, $a->NOMBRE_DOC.' '.$a->APEP_DOC);
        }

        Mail::to($justifications[0]->CORREO_COR)->send(new JustificationSubmittedEmail(
            $student, $teachers, $justifications[0], $justifications->pluck('ASIGNATURA')->all()
        ));
    }
}
