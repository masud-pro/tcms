<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Account;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentAccountsExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles {

    public $students;
    public $user;

    /**
     * @param $user
     * @param $students
     */
    public function __construct( $user, $students ) {
        $this->user     = $user;
        $this->students = $students;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Batch',
            'Email',
            'Paid Amount',
            'Status',
            'Date',
        ];
    }

    /**
     * @var Account $account
     */
    public function map( $account ): array
    {
        return [
            $account->user->name ?? $account->name,
            $account->course->name ?? "",
            $account->user->email ?? $account->description,
            $account->status,
            $account->paid_amount,
            Carbon::parse( $account->month )->format( 'D-M-Y' ),
        ];
    }

    public function columnWidths(): array{
        return [
            'A' => 20,
            'B' => 20,
            'C' => 25,
            'D' => 12,
            'E' => 8,
            'F' => 15,
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
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            'E' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return Account::when( $this->user, function ( $query, $student ) {
            $query->where( "user_id", $student );
        } )->get();
    }
}
