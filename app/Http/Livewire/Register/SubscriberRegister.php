<?php

namespace App\Http\Livewire\Register;

use Livewire\Component;
use App\Models\Subscription;

class SubscriberRegister extends Component {
    /**
     * @var mixed
     */
    public $planName;
    /**
     * @var mixed
     */
    public $planList;
    /**
     * @var mixed
     */
    public $planFeature;
    /**
     * @var mixed
     */
    public $planPrice;
    /**
     * @var mixed
     */
    public $billChecked;
    public $freeTrail;
    public $register;

    public function mount() {

        // $this->planList = ;
        // $this->startDate = Carbon::now()->format( 'Y-m-d' );
        $freeTrail = Subscription::where( 'name', 'Trail Plan' )->first();

        $this->planList = Subscription::all();

        $this->planName    = $freeTrail->id;
        $this->planFeature = explode( ',', Subscription::find( $freeTrail->id )->selected_feature );

        $this->freeTrail = true;
        $this->register = false;

        //    dd( Subscription::where('name', 'Trail Plan')->first());

    }

    public function updated() {
        //   dd($this->planName);

        $plan = Subscription::find( $this->planName );

        $featureList = explode( ',', $plan->selected_feature );

        //  dd($featureList);

        //   dd($this->planFeature = $featureList);
        $this->planFeature = $featureList;
        $this->planPrice   = $plan->price;

        $this->freeTrail = false;
        

    }

    /**
     * @param $monthly
     */
    public function changeMonthsBill( $monthly ) {
        $plan = Subscription::find( $this->planName );

        if ( $monthly == 1 ) {
            $this->billChecked = 1;
            $this->planPrice   = $plan->price;
        } else {
            $this->billChecked = 12;
            $this->planPrice   = $plan->price * 12;
        }
    }

    public function nextStep()
    {
        $this->register = true;
    }

    public function render() {

        return view( 'livewire.register.subscriber-register' );
    }
}
