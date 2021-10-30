<div class="p-6" >
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
      
        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
            <x-jet-button wire:click="createShowModel">
                {{ __('Create') }}
            </x-jet-button>
        </div>

        {{--Data table--}}

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-6" >
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                {{--Table Sector--}}
                
                <table class="min-w-full divide-y divide-gray-200"> 
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider "> Title                        
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider "> 
                                Link
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider "> 
                                Content
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider "> 
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 ">
                        @if ($data->count())
                            
                        @foreach ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{$item->title}}
                                    {!!$item->is_default_home ? '<span class="text-green-400 text-xs font-bold">[Default Home Page]</span>':'' !!}
                                    {!!$item->is_default_not_found ? '<span class="text-red-600 text-xs font-bold">[Default Not Found Page]</span>':'' !!}
                                    
                                    
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        <a href="{{URL::to('/'.$item->slug)}}" class="text-indigo-600 hover:text-indigo-900" 
                                            target="blank">                                    
                                            {{$item->slug}}                                                                        
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">{!! $item->content !!}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <x-jet-button wire:click="updateShowModel({{$item->id}})">
                                            {{ __('Update') }}
                                        </x-jet-button>
                                        <x-jet-danger-button wire:click="deleteShowModel({{$item->id}})">
                                            {{ __('Delete') }}
                                        </x-jet-danger-button>
                                    </td>
                                </tr>
                        @endforeach
                                        
                        @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap" colspan="4">No result found</td>
                                </tr>
                                
                        @endif 
                    
                    </tbody>
                </table>     
                {{--End Table Sector--}}
            </div>
        </div>
    </div>
</div>
<br> 
       
    {{$data->links()}}

        {{--Modal Form--}}
        <x-jet-dialog-modal wire:model="modelFormVisible">
            <x-slot name="title">
                {{ __('Save Page') }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="title" />
                    @error('title') <span class="error"> {{ $message }}</span>                    
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="slug" value="{{ __('Slug') }}" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            http://localhost:8000/
                        </span>
                        <input wire:model="slug" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="url-slug">
                    </div>
                    @error('slug') <span class="error"> {{ $message }}</span>                    
                    @enderror
                </div>

                <div class="mt-4">
                  <label>
                      <input type="checkbox" wire:model="isSetToDefaultHomePage" value="{{$isSetToDefaultHomePage}}">
                      <span class="ml-2 text-sm text-gray-600">Set As the defaut home page</span>
                  </label>
                </div>
                <div class="mt-4">
                  <label for="">
                      <input type="checkbox" wire:model="isSetToDefaultNotFoundPage" value="{{$isSetToDefaultNotFoundPage}}">
                      <span class="ml-2 text-sm text-red-600">Set As the defaut 404 page</span>
                  </label>
                </div>

                <div class="mt-4">
                    <x-jet-label for="title" value="{{ __('Content') }}" />
                    <div class="rounded-md shadow-sm">
                        <div class="mt-1 bg-white">                      
                            <div class="body-content" wire:ignore>                            
                                <trix-editor
                                    class="trix-content"
                                    x-ref="trix"
                                    wire:model.debounce.100000ms="content"
                                    wire:key="trix-content-unique-key"
                                ></trix-editor>
                            </div>
                        </div>
                    </div>
                    @error('content') <span class="error"> {{ $message }}</span>                    
                    @enderror
                </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modelFormVisible')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                @if ($modelId)
                    <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-jet-button>
                @else
                    <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-jet-button>
                @endif

            </x-slot>
        </x-jet-dialog-modal>
  

        {{--The Delete Modal--}}
        
        <x-jet-dialog-modal wire:model="modelConfirmDeleteVisible">
            <x-slot name="title">
                {{ __('Delete Page') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this Paget? Once your page is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your page.') }}

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modelConfirmDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                {{ __('Delete Page') }}
                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>

        {{--The Delete Modal--}}

    </div>


