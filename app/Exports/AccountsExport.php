<?php

namespace App\Exports;

use App\Models\Account;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AccountsExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles, WithProperties {

    private $q;
    private $batch;
    private $month;

    public function __construct( $q, $batch, $month ) {
        $this->q     = $q;
        $this->batch = $batch;
        $this->month = $month;
    }

    public function headings(): array{
        return [
            'Student Name',
            'Course Name',
            'Status',
            'Amount',
            'Month',
        ];
    }

    public function map( $account ): array{
        return [
            $account->user->name,
            $account->course->name,
            $account->status,
            $account->paid_amount,
            Carbon::parse( $account->month )->format( 'M-Y' ),
            // $account->created_at->format('d M,Y g:i A'),
        ];
    }

    public function columnWidths(): array{
        return [
            'A' => 35,
            'B' => 25,
            'C' => 15,
            'D' => 15,
            'E' => 15,
        ];
    }

    public function styles( Worksheet $sheet ) {
        return [
            // Style the first row as bold text.
            1   => ['font' => ['bold' => true]],
            'D' => ['alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]],
        ];
    }

    public function properties(): array{
        return [
            'title' => 'Account Report - ' . $this->month,
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return Account::select( ["accounts.*", "accounts.id as account_id", "users.id as user_id", "users.name as user_name", "users.email as user_email"] )
            ->with( "user" )
            ->whereHas( "user", function ( $query ) {
                $query->where( 'name', 'like', '%' . $this->q . '%' )
                    ->orWhere( 'id', 'like', '%' . $this->q . '%' );
            } )
            ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
            ->orderBy( "users.name", "asc" )
            ->when( $this->batch, function ( $query, $batch ) {
                $query->where( "course_id", $batch );
            } )
            ->when( $this->month, function ( $query, $month ) {
                $query->whereMonth( "month", $month );
            } )
            ->where( function ( $query ) {
                $query->where( "status", "Paid" );
                $query->orWhere( "status", "Unpaid" );
                $query->orWhere( "status", "Pending" );
            } )->get();
    }

}
