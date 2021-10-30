<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class FrontPage extends Component
{
    public $title, $content, $urlslug;

    /**
     * The Livewire Mount Function
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function mount($urlslug)
    {
        $this->retrieveContent($urlslug);
    }


    /**
     * Retrieves the content of the page 
     *
     * @param  mixed $urlslug
     * @return void
     */
    public function retrieveContent($urlslug)
    {

        $data  = Page::whereSlug($urlslug)->first();
        $this->title  = $data->title;
        $this->content = $data->content;
    }


    /**
     * The Livewire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.front-page')->layout('layouts.frontend');
    }
}
