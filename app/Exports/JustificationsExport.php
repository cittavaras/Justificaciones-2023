<?php

namespace App\Exports;

use App\Justification;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class JustificationsExport implements FromQuery, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Justification::query();
    }



    /**
   * @var Justification $justification
   */
    public function map($justification): array
   {
       return [
           $justification->NFOLIO,
           $justification->FEC_JUS,
           $justification->RUT_ALU,
           $justification->NOMBRE_ALUM,
           $justification->CORREO_ALUM,
           $justification->CELULAR_ALUM,
           $justification->ASIGNATURA,
           $justification->CORREO_DOC,
           $justification->TIPO_INASISTENCIA == 1?'SI':'NO',
           $justification->MOTIVO,
           $justification->ESTADO,
           $justification->FEC_SOL,
           $justification->CORREO_COR,


       ];
   }


    public function headings(): array
    {
        return [

            'Folio',
            'Fecha Justificacion',
            'RUT Alumno',
            'Nombre Alumno',
            'Correo Alumno',
            'Celular Alumno',
            'Asignatura',
            'Correo Docente',
            'Evaluacion',
            'Motivo',
            'Estado',
            'Fecha Solucion',
            'Correo Coordinador',
        ];
    }


    public function registerEvents(): array
   {

     $headStyleArray = [
         'font' => [
            'bold'  => true,
            'name'  => 'Arial',
            'size'  => 11,
        ]
    ];

    $bodyStyleArray = [
          'borders' => [
              'allBorders' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                  'color' => ['argb' => '000000'],
              ],
          ],
    ];

       return [
           // Handle by a closure.
           AfterSheet::class => function(AfterSheet $event) use($headStyleArray, $bodyStyleArray) {
              $event->sheet->getStyle('A1:M1')->applyFromArray($headStyleArray);
              $event->sheet->getStyle('A1:M'.(Justification::count()+1))->applyFromArray($bodyStyleArray);

           },
       ];
   }


}
