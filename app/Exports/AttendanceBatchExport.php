<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceBatchExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles, WithProperties {

    private $batch;
    private $date;

    /**
     * @param $batch
     * @param $date
     */
    public function __construct( $batch, $date ) {
        $this->batch = $batch;
        $this->date  = $date;
    }

    public function headings(): array
    {
        return [
            'Batch Name',
            'Name',
            'Attendance',
            'Email',
            'Date',
        ];
    }

    /**
     * @var Attendance $attendance
     */
    public function map( $attendance ): array
    {
        // dd($attendance);
        return [
            $attendance->course->name,
            $attendance->user->name,
            $attendance->attendance === 0 ? 'Absent' : 'Present',
            $attendance->user->email ?? '',
            $attendance->date,
        ];
    }

    public function columnWidths(): array{
        return [
            'A' => 25,
            'B' => 20,
            'C' => 15,
            'D' => 25,
            'E' => 15,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles( Worksheet $sheet ) {
        return [
            // Style the first row as bold text.
            1   => [
                'font'      => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function properties(): array{
        return [
            'title' => 'Attendance Report Of Batch-',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return Attendance::select( ["attendances.*", "attendances.id as account_id", "users.name as user_name", "users.email as user_email"] )
            ->with( "user" )
            ->leftJoin( "users", "attendances.user_id", "=", "users.id" )
            ->orderBy( "users.name", "asc" )
            ->when( $this->batch, function ( $query, $batch ) {
                $query->where( "course_id", $batch );
            } )
            ->when( $this->date, function ( $query, $date ) {
                $query->where( "date", $date );
            } )->get();

    }
}