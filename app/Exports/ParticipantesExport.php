<?php
namespace App\Exports;
use App\Models\Participantes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ParticipantesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $participantes;

    public function __construct($participantes)
    {
        $this->participantes = $participantes;
    }

    // Define los encabezados de las columnas
    public function headings(): array
    {
        return [
            'N',
            'Nombre del Postulante',
            'Correo',
            'Teléfono',
            'Edad',
            'Dirección',
            'Escolaridad',
            'CURP',
            'Razón Social',
            'Empresa',
            'RFC Empresa',
            'Puesto',
            'Pago',
            'Estado de Pago',
            'Fecha del Curso',
            'Cursos Inscritos',
        ];
    }

    // Define cómo se mapean los datos
    public function map($participantes): array
    {
        return [
            $participantes->N,
            $participantes->NombredelPostulante,
            $participantes->Correo,
            $participantes->Telefono,
            $participantes->Edad,
            $participantes->Direccion,
            $participantes->Escolaridad,
            $participantes->Curp,
            $participantes->RazónSocial,
            $participantes->Empresa,
            $participantes->RFCEmpresa,
            $participantes->Puesto,
            '$' . number_format((!empty($participantes->Pago) && is_numeric($participantes->Pago)) ? floatval($participantes->Pago) : 0, 2),
            $participantes->EstadoDePago,
            $participantes->FechadelCurso,
            $participantes->cursos->isEmpty() ? 'No hay cursos inscritos' : $participantes->cursos->map(function ($curso) {
                return $curso->NombredelCurso . ' (' . $curso->pivot->FechadelCurso . ')';
            })->implode(', '),
        ];
    }

    // Personaliza el estilo del archivo Excel
    public function styles(Worksheet $sheet)
    {
        // Obtener la última fila
        $lastRow = $sheet->getHighestRow();

        // Estilo para la fila de encabezados
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Texto blanco
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '000000'], // Fondo negro
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        // Aplicar estilo al encabezado
        $sheet->getStyle('A1:P1')->applyFromArray($headerStyle);

        // Ajustar el ancho de las columnas
        $sheet->getColumnDimension('A')->setWidth(5);  // N
        $sheet->getColumnDimension('B')->setWidth(25); // Nombre del Postulante
        $sheet->getColumnDimension('C')->setWidth(25); // Correo
        $sheet->getColumnDimension('D')->setWidth(15); // Teléfono
        $sheet->getColumnDimension('E')->setWidth(10); // Edad
        $sheet->getColumnDimension('F')->setWidth(30); // Dirección
        $sheet->getColumnDimension('G')->setWidth(15); // Escolaridad
        $sheet->getColumnDimension('H')->setWidth(20); // CURP
        $sheet->getColumnDimension('I')->setWidth(25); // Razón Social
        $sheet->getColumnDimension('J')->setWidth(25); // Empresa
        $sheet->getColumnDimension('K')->setWidth(20); // RFC Empresa
        $sheet->getColumnDimension('L')->setWidth(20); // Puesto
        $sheet->getColumnDimension('M')->setWidth(15); // Pago
        $sheet->getColumnDimension('N')->setWidth(15); // Estado de Pago
        $sheet->getColumnDimension('O')->setWidth(20); // Fecha del Curso
        $sheet->getColumnDimension('P')->setWidth(40); // Cursos Inscritos

        // Estilo para las filas de datos
        $dataStyle = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ];

        // Aplicar estilo a las filas de datos
        $sheet->getStyle("A2:P{$lastRow}")->applyFromArray($dataStyle);

        // Alternar colores de fondo para filas de datos
        for ($row = 2; $row <= $lastRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:P{$row}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->setStartColor(new Color('F5F5F5')); // Color gris claro
            }
        }

        // Ajustar altura de las filas
        $sheet->getRowDimension(1)->setRowHeight(30); // Encabezado
        foreach (range(2, $lastRow) as $row) {
            $sheet->getRowDimension($row)->setRowHeight(22); // Filas de datos
        }
    }

    // Obtener los datos de los participantes
    public function collection()
    {
        return $this->participantes;
    }
}
