<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DeleteBlanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:blanks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::delete('DELETE from contacts where MobileNum is NULL and LandlineNum is NULL and FirstName is null and LastName is null and Email is NULL');
        echo "deleted";
        return 0;
    }
}
