<?php

namespace App\Http\Livewire\Subscription;

use Livewire\Component;
use App\Models\Subscription;
use Spatie\Permission\Models\Permission;

class Edit extends Component {

    /**
     * @var mixed
     */
    public $subscription;

    /**
     * @var mixed
     */
    public $name;
    /**
     * @var mixed
     */
    public $price;
    /**
     * @var mixed
     */
    public $selectedFeature;
    /**
     * @var mixed
     */
    public $days;
    /**
     * @var mixed
     */
    public $checkedAll;

    /**
     * @var array
     */
    protected $rules = [
        'name'            => ['required', 'string'],
        'price'           => ['required'],
        'selectedFeature' => ['required'],
        'days'            => ['required'],
    ];

    public function mount() {

        $selectedFeature = explode( ',', $this->subscription['selected_feature'] );

        $this->name            = $this->subscription['name'];
        $this->price           = $this->subscription['price'];
        $this->selectedFeature = $selectedFeature;
        $this->days            = $this->subscription['days'];

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
        $subscription['days']             = $data['days'];
        $subscription['selected_feature'] = $feature;

        $this->subscription->update( $subscription );
        session()->flash( 'updated', 'Subscription updated successfully.' );
        return redirect()->route( 'subscription.index' );
    }

    public function render() {

        return view( 'livewire.subscription.edit' );
    }
}