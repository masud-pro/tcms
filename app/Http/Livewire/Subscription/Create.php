<?php

namespace App\Http\Livewire\Subscription;

use Livewire\Component;
use App\Models\Subscription;
use Spatie\Permission\Models\Permission;

class Create extends Component {

    /**
     * @var mixed
     */
    public $name, $price, $selectedFeature, $checkedAll, $months;

    /**
     * @var array
     */
    protected $rules = [
        'name'            => ['required', 'string', 'unique:subscriptions'],
        'price'           => ['required'],
        'selectedFeature' => ['required'],
        'months'          => ['required'],
    ];

    public function mount() {

        $this->selectedFeature = [];

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

        Subscription::create( $subscription );

        return redirect()->route( 'subscription.index' );
    }

    public function render() {
        return view( 'livewire.subscription.create' );
    }
}