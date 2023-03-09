<?php

namespace App\Http\Livewire\Subscription;

use Livewire\Component;
use App\Models\Subscription;
use Spatie\Permission\Models\Permission;

class Edit extends Component {

    /**
     * @var mixed
     */
    public $subscription, $name, $price, $selectedFeature, $months, $checkedAll;

    /**
     * @var array
     */
    protected $rules = [
        'name'            => ['required', 'string'],
        'price'           => ['required'],
        'selectedFeature' => ['required'],
        'months'          => ['required'],
    ];

    public function mount() {

        $selectedFeature = explode( ',', $this->subscription['selected_feature'] );

        $this->name            = $this->subscription['name'];
        $this->price           = $this->subscription['price'];
        $this->selectedFeature = $selectedFeature;
        $this->months          = $this->subscription['months'];

    }

    public function updatedCheckedAll() {

        if ( $this->checkedAll == true ) {

            $this->selectedFeature = Permission::pluck( 'name' )->toArray();
        } else {
            $this->selectedFeature = [];
        }
    }

    /**
     *
     */
    public function submit() {
        $data = $this->validate();

        $feature = implode( ",", $data['selectedFeature'] );

        $data['selectedFeature'] = $feature;

        $subscription['name']             = $data['name'];
        $subscription['price']            = $data['price'];
        $subscription['months']           = $data['months'];
        $subscription['selected_feature'] = $feature;

        $this->subscription->update( $subscription );
        session()->flash( 'updated', 'Subscription updated successfully.' );
        return redirect()->route( 'subscription.index' );
    }

    public function render() {

        return view( 'livewire.subscription.edit' );
    }
}