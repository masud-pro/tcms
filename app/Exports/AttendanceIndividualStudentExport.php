<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceIndividualStudentExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles, WithTitle {


    private $student;
    private $month;

    /**
     * @param $student
     * @param $month
     */
    public function __construct( $student, $month ) {
        $this->student = $student;
        $this->month  = $month;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Batch Name',
            'Email',
            'Date',
            'Attendance',
        ];
    }

    /**
     * @var Attendance $attendance
     */
    public function map( $attendance ): array
    {
        // dd($attendance);
        return [
            $attendance->user->name,
            $attendance->course->name,
            $attendance->user->email,
            $attendance->date,
            $attendance->attendance === 0 ? 'Absent' : 'Present',
        ];
    }

    public function columnWidths(): array{
        return [
            'A' => 20,
            'B' => 20,
            'C' => 30,
            'D' => 20,
            'E' => 15,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles( Worksheet $sheet ) {
        return [
            // Style the first row as bold text.
            1 => [
                'font'      => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    
     /**
     * @return string
     */
    public function title(): string
    {
        return 'Attendance Report Of Individual Student -';
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return Attendance::with( "user" )->when( $this->student, function ( $query, $student ) {
            $query->where( "user_id", $student );
        } )->when( $this->month, function ( $query, $month ) {
            $query->whereMonth( "date", $month );
        } )->get();
    }
}
