<?php

namespace App\Http\Livewire\Administrator;

use App\Models\User;
use Livewire\Component;

class Index extends Component {

    public function render() {
        return view( 'livewire.administrator.index', [
            "administrators" => User::where( "role", "Admin" )
                ->latest()->paginate( 20 ),
        ] );
    }
}