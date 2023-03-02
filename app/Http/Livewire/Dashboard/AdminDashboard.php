<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\SubscriptionUser;
use Spatie\Permission\Models\Role;

class AdminDashboard extends Component {

    /**
     * @var mixed
     */
    public $totalRegisterTeacher, $thisMonthIncome, $thisMonthSubscriptionExpire;

    public function mount() {
        $teacherRole = Role::where( 'name', 'Teacher' )->first();

        $this->totalRegisterTeacher = User::role( $teacherRole )->count();

        $this->thisMonthIncome = AdminAccount::where( 'status', 1 )->whereMonth( 'created_at', Carbon::now()->month )
                                                                 ->sum( 'total_price' );

        $this->thisMonthSubscriptionExpire = SubscriptionUser::whereMonth( 'expiry_date', Carbon::now()->month )->get();

    }

    public function render() {
        return view( 'livewire.dashboard.admin-dashboard' );
    }
}