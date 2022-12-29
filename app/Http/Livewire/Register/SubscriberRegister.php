<?php

namespace App\Http\Livewire\Register;

use Livewire\Component;
use App\Models\Subscription;

class SubscriberRegister extends Component {
    public $planName;
    public $planList;
    public $planFeature;
    public $planPrice;
    public $billChecked;
    public $freeTrail;
    public $register;
    public $nextStep;
    
    //
    public $fName;
    public $lName;
    public $phoneNumber;
    public $userName;
    public $emailAddress;
    public $dob;
    public $gender;
    public $curriculum;
    public $teachingLevel;
    public $address;
    public $password;

    public function mount() {

        // $this->planList = ;
        // $this->startDate = Carbon::now()->format( 'Y-m-d' );
        $freeTrail = Subscription::where( 'name', 'Trail Plan' )->first();

        $this->planList = Subscription::all();

        $this->planName    = $freeTrail->id;
        $this->planFeature = explode( ',', Subscription::find( $freeTrail->id )->selected_feature );

        $this->freeTrail = true;
        $this->register  = false;

        //    dd( Subscription::where('name', 'Trail Plan')->first());

    }

    // public function updatedBillChecked() {

    // }

    public function updated() {
        // dump( $this->billChecked );

        $plan = Subscription::find( $this->planName );

        $featureList = explode( ',', $plan->selected_feature );

        //  dd($featureList);

        //   dd($this->planFeature = $featureList);
        $this->planFeature = $featureList;
        $this->planPrice   = $plan->price;

        $this->freeTrail = false;

        if ( $this->billChecked ) {
            $this->changeMonthsBill( 1 );
        } elseif ( $this->billChecked ) {
            $this->changeMonthsBill( 12 );
        }

    }

    /**
     * @param $monthly
     */
    public function changeMonthsBill( $is_yearly ) {
        $plan = Subscription::find( $this->planName );

        if ( $is_yearly ) {
            $this->planPrice = $plan->price * 12;
        } else {
            $this->planPrice = $plan->price;
        }
    }

    public function nextStep() {
        $this->register = true;
        $this->nextStep = true;
    }

    protected function rules() {
        return [
            'fName' => ['required'],
            'lName' => ['required'],
        ];
    }

    public function submit() {
        $this->validate();
        // $this->validate([
        //     'fName' => ['required'],
        //     'lName' => ['required'],
        // ]);

        // $this->register = true;
    }

    public function render() {

        return view( 'livewire.register.subscriber-register' );

    }
}