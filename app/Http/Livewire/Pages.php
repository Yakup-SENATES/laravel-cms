<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;
    public $slug, $title, $content, $modelId;
    public  $modelFormVisible = false;
    public  $modelConfirmDeleteVisible = false;


    /**
     * The Validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')->ignore($this->modelId)],
            'content' => 'required'
        ];
    }

    /**
     * The Livewire mount function
     * 
     *
     * @return void
     */
    public function mount()
    {
        // Resets the pagination after reloading the page
        $this->resetPage();
    }

    /**
     * runs every time the 
     * title variables updated.  
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedTitle($value)
    {
        $this->generateSlug($value);
    }

    /**
     * create Page 
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Page::create($this->modelData());
        $this->modelFormVisible = false;
        $this->resetVars();
    }

    /**
     * The read function
     *
     * @return void
     */
    public function read()
    {
        return Page::paginate(5);
    }


    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        Page::find($this->modelId)->update($this->modelData());
        $this->modelFormVisible = false;
        //$this->resetValidation();
    }

    /**
     * The page delete function 
     *
     * @return void
     */
    public function delete()
    {
        Page::destroy($this->modelId);
        $this->modelConfirmDeleteVisible = false;
        $this->resetPage();
    }


    /**
     * Resets all variables 
     * to null
     *
     * @return void
     */
    public function resetVars()
    {
        $this->modelId = null;
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }

    /**
     * Generates a url slug 
     * base on the title.
     *
     * @param  mixed $value
     * @return void
     */
    private function generateSlug($value)
    {
        $process1 =  str_replace(' ', '-', $value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
    }

    /**
     * Show the form modal of the create function
     * 
     * ctr+shift+ı ile yapılıyor
     * 
     * @return void
     */
    public function createShowModel()
    {
        $this->resetValidation();
        //update den sonra veriler temizlenmeli
        $this->resetVars();
        $this->modelFormVisible = true;
    }


    /**
     * Shows the form model 
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModel($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId  = $id;
        $this->modelFormVisible = true;
        $this->loadModel();
    }

    /**
     * Shows the delete
     * confirmation modal   
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModel($id)
    {

        $this->modelId = $id;
        $this->modelConfirmDeleteVisible = true;
    }



    /**
     * Loads the model data 
     *  of this component
     * 
     * @return void
     */
    public function loadModel()
    {
        $data = Page::find($this->modelId);
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->content = $data->content;
    }



    /**
     * The Data for the model mapped
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ];
    }




    /**
     * The live-wire render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.pages', [
            'data' => $this->read(),
        ]);
    }
}
