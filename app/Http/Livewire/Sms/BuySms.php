<?php

namespace App\Http\Livewire\Sms;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminAccount;
use App\Models\SubscriptionUser;
use Illuminate\Support\Facades\Auth;

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

        if ( $this->price ) {
            $subscriberId = SubscriptionUser::where( 'user_id', Auth::user()->id )->first();

            $buySms['subscription_user_id'] = $subscriberId->id;
            $buySms['total_price']          = $this->price;
            $buySms['to_date']              = Carbon::now();
            $buySms['purpose']              = 'Buy ' . $this->smsPackage . ' Sms at';
            $buySms['status']               = 1;

            AdminAccount::create( $buySms );

            $setting = getSettingValue( 'remaining_sms' );
            $afterBuyNowSms['value'] = $setting->value + $this->smsPackage;
            $setting->update( $afterBuyNowSms );

            session()->flash( 'success', 'You Buy ' . $this->smsPackage . '  SMS Successfully' );
            // $this->addError( 'success', 'You Buy ' . $this->smsPackage . '  SMS Successfully' );
            // sleep(5);
            return redirect()->route('sms.index');
        } else {

            session()->flash( "error", "Please Select A Package" );
        }

        // $this->addError( 'key', 'asdasdasdasd' );

    }

    public function updated() {
//  dd( $this->smsPackage);

        $this->price = $this->smsPackage * $this->perSms;

// dd( $this->price);

    }

    public function render() {
        return view( 'livewire.sms.buy-sms' );
    }
}