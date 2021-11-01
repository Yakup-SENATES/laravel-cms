<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class LivewireCustomCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jacopx {nameOfClass? : The name of the class.} ,
     {nameOfTheModelClass? : The name of the Model class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Created By Jacop Handler';

    /*
     *Our Custom class Properties here!
     *
     */
    protected $nameOfClass, $nameOfTheModelClass, $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file  = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Gathers all parameters
        $this->gatherParameters();

        //Generates the livewire Class file
        $this->generateLivewireCrudClassFile();


        //Generates the livewire View file

        $this->generateLivewireCrudViewFile();
    }

    protected function gatherParameters()
    {
        $this->nameOfClass = $this->argument('nameOfClass');
        $this->nameOfTheModelClass = $this->argument('nameOfTheModelClass');

        // if you didn't input the name of the class

        if (!$this->nameOfClass) {
            $this->nameOfClass = $this->ask('Enter class name');
        }
        if (!$this->nameOfTheModelClass) {
            $this->nameOfTheModelClass = $this->ask('Enter the model class name');
        }
        //convert to studly(pascal) case

        $this->nameOfClass = Str::studly($this->nameOfClass);
        $this->nameOfTheModelClass = Str::studly($this->nameOfTheModelClass);

        $this->info($this->nameOfClass . " " . $this->nameOfTheModelClass);
    }

    /** 
     * Generates The Crud Files
     *
     * @param  mixed $var
     * @return void
     */
    protected function generateLivewireCrudClassFile()
    {
        //set the origin and destination for the livewire class file

        $fileOrigin  = base_path('/stubs/custom.livewire.crud.stub');
        $fileDestination  = base_path('/app/Http/Livewire/' . $this->nameOfClass . '.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This class file already exist .. ' . $this->nameOfClass . '.php');
            return false;
        }



        //Get The original String Content of the file 
        $fileOriginalString = $this->file->get($fileOrigin);

        //Replace the strings specified in the array sequentially 
        $replaceFileOriginalString = Str::replaceArray(
            '{{}}',
            [
                $this->nameOfTheModelClass, //name of the model class 
                $this->nameOfClass,         // name of the class
                $this->nameOfTheModelClass, //name of the model class 
                $this->nameOfTheModelClass, //name of the model class 
                $this->nameOfTheModelClass, //name of the model class 
                $this->nameOfTheModelClass, //name of the model class 
                $this->nameOfTheModelClass, //name of the model class 
                Str::kebab($this->nameOfClass), //From FooBar To foo-bar
            ],
            $fileOriginalString
        );

        //$this->info($fileOriginalString);

        //put the content into the destination directory

        $this->file->put($fileDestination, $replaceFileOriginalString);
        $this->info('Livewire class file created :' . $fileDestination);
    }

    /**
     * generateLivewireCrudViewFile
     *
     * @return void
     */
    protected function generateLivewireCrudViewFile()
    {
        //set the origin and destination for the livewire class file

        $fileOrigin  = base_path('/stubs/custom.livewire.crud.view.stub');
        $fileDestination  = base_path('/resources/views/livewire/' . Str::kebab($this->nameOfClass) . '.blade.php');

        if ($this->file->exists($fileDestination)) {
            $this->info('This view file already exist .. ' . Str::kebab($this->nameOfClass) . '.php');
            return false;
        }

        //copy file to destination

        $this->file->copy($fileOrigin, $fileDestination);

        $this->info('Livewire view file  created :  ' . $fileDestination);
    }
}
