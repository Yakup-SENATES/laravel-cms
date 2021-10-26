<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pages extends Component
{
    public $slug, $title, $content;
    public  $modelFormVisible = false;


    /**
     * Show the form modal of the create function
     * 
     * ctr+shift+ı ile yapılıyor
     * 
     * @return void
     */
    public function createShowModel()
    {
        $this->modelFormVisible = true;
    }

    /**
     * The live-wire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages');
    }
}
