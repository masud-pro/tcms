<?php

namespace App\Http\Livewire\Feed;

use Livewire\Component;

class AllFeed extends Component {
    public $course;

    public $perpage = 15;

    public function load() {
        $this->perpage += 15;
    }

    public function render() {

        return view( 'livewire.feed.all-feed', [
            "course" => $this->course,
            "feeds"  => $this->course->feeds()->with("user")->latest()->take( $this->perpage )->get(),
            "total"  => $this->course->feeds()->count(),
        ] );
    }

}
