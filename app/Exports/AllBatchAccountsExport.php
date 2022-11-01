<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Account;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllBatchAccountsExport implements FromCollection, WithMapping, WithHeadings, WithColumnWidths, WithStyles, WithProperties {
   
    private $q;

    /**
     * @param $q
     */
    public function __construct( $q ) {
        $this->q = $q;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Status',
            'Course',
            'Email',
            'Amount',
        ];
    }

    /**
     * @var Account $account
     */
    public function map( $account ): array
    {
        return [
            $account->user->name ?? '',
            $account->status,
            $account->course->name ?? $account->name,
            $account->user->email ?? '',
            $account->paid_amount,
        ];
    }

    public function columnWidths(): array{
        return [
            'A' => 20,
            'B' => 15,
            'C' => 25,
            'D' => 30,
            'E' => 10,
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
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,],
            ],
            'E' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,]],
            'D' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,]],
        ];
    }

    public function properties(): array{
        return [
            'title' => 'Account Report Of All Batch - ',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return Account::select( ["accounts.*", "accounts.id as account_id", "users.id as user_id", "users.name as user_name", "users.email as user_email"] )
            ->with( "user" )
            ->whereMonth( "accounts.created_at", Carbon::today() )
            ->whereHas( "user", function ( $query ) {
                $query->where( 'name', 'like', '%' . $this->q . '%' )
                      ->orWhere( 'id', 'like', '%' . $this->q . '%' );
            } )
            ->leftJoin( "users", "accounts.user_id", "=", "users.id" )
            ->orderBy( "users.name", "asc" )
            ->simplePaginate( 50 );
    }
}