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
    public function mount($urlslug = null)
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
        //get home page if slug is empty
        if (empty($urlslug)) {
            $data = Page::where('is_default_home', true)->first();
        } else {

            //get Page according to the slug value
            $data  = Page::whereSlug($urlslug)->first();

            //if we cant retrieve anything , let's get the default 404 page s
            if (!$data) {
                $data = Page::where('is_default_not_found', true)->first();
            }
        }
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
