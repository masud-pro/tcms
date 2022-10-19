<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OverAllAccountExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles {

    /**
     * @var mixed
     */
    private $q;
    /**
     * @var mixed
     */
    private $month;

    /**
     * @param $q
     * @param $month
     */
    public function __construct( $q, $month ) {
        $this->q     = $q;
        $this->month = $month;
    }

    public function headings(): array
    {
        return [
            'Course Name',
            'Name',
            'Email',
            'Amount',
            'Is Paid',
            'Date',
        ];
    }

    /**
     * @var Account $account
     */
    public function map( $account ): array
    {
        // dd($account);
        return [
            $account->course->name ?? 'Teacher Expense',
            $account->user->name ?? Auth::user()->name,
            $account->user->email ?? '',
            $account->status,
            $account->paid_amount,
            Carbon::parse( $account->month )->format( 'M-Y' ),
        ];
    }

    public function columnWidths(): array{
        return [
            'A' => 22,
            'B' => 20,
            'C' => 25,
            'D' => 12,
            'E' => 11,
            'F' => 10,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles( Worksheet $sheet ) {
        return [
            // Style the first row as bold text.
            1   => [
                'font' => ['bold' => true],
                'alignment'    => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'E' => ['alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]],'D' => ['alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]],
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {

        return Account::select( ["accounts.*", "accounts.id as account_id", "users.id as user_id", "users.name as user_name", "users.email as user_email"] )
            ->with( ["user", "course"] )
            ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
            ->orderBy( "users.name", "asc" )
            ->orderBy( "accounts.created_at", "desc" )
            ->when( $this->q, function ( $query, $q ) {
                $query->where( 'users.name', 'like', '%' . $q . '%' );
            } )
                     // ->where( 'users.name', 'like', '%' . $this->q . '%' )
                     ->when( $this->month, function ( $query, $month ) {
                         $query->whereMonth( "month", $month );
                     } )->get();
    }
}