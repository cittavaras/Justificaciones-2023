<?php

namespace App\Listeners\Justification\Approved;

use App\Events\Justification\Approved as JustificationApproved;
use App\Mail\Justification\Approved\ToStudent as JustificationApprovedEmail;
use App\Justification;
use Mail;
use DB;

class SendEmailToStudent
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
        $filteredJustifications = $justifications->unique('CORREO_DOC')->pluck('CORREO_DOC');
        $alumno = DB::table('datos_semestre')
            ->where('CORREO_ALUM', $event->justification->CORREO_ALUM)
            ->whereIn('CORREO_DOC', $filteredJustifications)
            ->get();

        $profesores = [];
        foreach ($alumno as $a) {
            array_push($profesores, $a->NOMBRE_DOC.' '.$a->APEP_DOC);
        }

        $alumnoFinal = [
            'RUT_ALU' => $alumno[0]->RUT_ALU,
            'CARRERA' => $alumno[0]->CARRERA,
        ];

        Mail::to($event->justification->CORREO_ALUM)
            ->send(new JustificationApprovedEmail(
                $event->justification,
                $profesores,
                $justifications->pluck('ASIGNATURA')->all(),
                $alumnoFinal
            ));
    }
}
