<?php

namespace App\Http\Livewire\Sms;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\SubscriptionUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;

class BuySms extends Component {

    /**
     * @var mixed
     */
    public $perSms;
    /**
     * @var mixed
     */
    public $smsPackage;
    /**
     * @var mixed
     */
    public $price;
// public $perSms;

    public function mount() {
        $this->perSms = "0.25";
//    $this->price = "0.25";

//    dd( $this->price);
    }

    public function submit() {
        // dd( $this->price );

        $user = Auth::user();

        if ( $this->price ) {
            $subscriberId = SubscriptionUser::where( 'user_id', $user->id )->first();

            $buySms['subscription_user_id'] = $subscriberId->id;
            $buySms['total_price']          = $this->price;
            $buySms['to_date']              = Carbon::now();
            $buySms['purpose']              = 'Buy ' . $this->smsPackage . ' Sms at';
            $buySms['status']               = 0;

            $adminAccount = AdminAccount::create( $buySms );

            $paymentData['name']             = $user->name;
            $paymentData['email']            = $user->email;
            $paymentData['address']          = $user->address;
            $paymentData['phone_no']         = $user->phone_no;
            $paymentData['amount']           = $this->price;
            $paymentData['admin_account_id'] = $adminAccount->id;
            $paymentData['sms_amount']       = $this->smsPackage;

            $payOptions  = SslCommerzPaymentController::sms_payment( $paymentData );
            $paymentLink = json_decode( $payOptions )->data;

            return redirect( $paymentLink );
            
            // dd( $payOptions );

            // session()->flash( 'success', 'You Buy ' . $this->smsPackage . '  SMS Successfully' );
            // $this->addError( 'success', 'You Buy ' . $this->smsPackage . '  SMS Successfully' );
            // sleep(5);

        } else {

            session()->flash( "error", "Please Select A Package" );
        }

        // $this->addError( 'key', 'asdasdasdasd' );

    }

    public function updated() {
//  dd( $this->smsPackage);

        $this->price = (int) $this->smsPackage * $this->perSms;

// dd( $this->price);

    }

    public function render() {
        return view( 'livewire.sms.buy-sms' );
    }
}