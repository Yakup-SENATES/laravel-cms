<?php


namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

use Livewire\WithPagination;

class CustomCrud extends Component
{
	use WithPagination;
	public $modalFormVisible;
	public $modalConfirmDeleteVisible;

	public $modelId;



	/**
	 * The validation rules
	 *
	 * @return void
	 */
	public function rules()
	{
		return [];
	}


	/**
	 * Loads the model data
	 * of this component.
	 *
	 * @return void
	 */
	public function loadModel()
	{
		$data = User::find($this->modelId);
		//Assign the variables here 
	}

	/**
	 * The data for the model mapped
	 * in this component.
	 *
	 * @return void
	 */
	public function modelData()
	{
		return [];
	}


	/**
	 * The create function.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->validate();
		User::create($this->modelData());
		$this->modalFormVisible = false;
		$this->reset();
	}

	/**
	 * The read function.
	 *
	 * @return void
	 */
	public function read()
	{
		return User::paginate(5);
	}

	/**
	 * The update function
	 *
	 * @return void
	 */
	public function update()
	{
		$this->validate();
		User::find($this->modelId)->update($this->modelData());
		$this->modalFormVisible = false;
	}

	/**
	 * The delete function.
	 *
	 * @return void
	 */
	public function delete()
	{
		User::destroy($this->modelId);
		$this->modalConfirmDeleteVisible = false;
		$this->resetPage();
	}

	/**
	 * Shows the create modal
	 *
	 * @return void
	 */
	public function createShowModal()
	{
		$this->resetValidation();
		$this->reset();
		$this->modalFormVisible = true;
	}

	/**
	 * Shows the form modal
	 * in update mode.
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function updateShowModal($id)
	{
		$this->resetValidation();
		$this->reset();
		$this->modalFormVisible = true;
		$this->modelId = $id;
		$this->loadModel();
	}

	/**
	 * Shows the delete confirmation modal.
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function deleteShowModal($id)
	{
		$this->modelId = $id;
		$this->modalConfirmDeleteVisible = true;
	}

	public function render()
	{
		return view('livewire.custom-crud', [
			'data' => $this->read(),
		]);
	}
}
