<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class removedupes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:dupes';

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
        $getdupes1=DB::statement('DELETE contacts FROM contacts
                        INNER JOIN
                    (SELECT 
                        MAX(id) AS lastId,
                            MobileNum,
                            LandlineNum,
                            FirstName,
                            LastName,
                            COUNT(id) AS totals,
                            Email
                    FROM
                        contacts
                    GROUP BY MobileNum , LandlineNum , FirstName , LastName
                    HAVING totals > 1) duplic ON duplic.MobileNum = contacts.MobileNum
                        AND duplic.FirstName = contacts.FirstName
                        AND duplic.LastName = contacts.LastName
                WHERE
                    contacts.id < duplic.lastId;
                ');
        $getdupes2=DB::statement('DELETE contacts FROM contacts
                        INNER JOIN
                    (SELECT 
                        MAX(id) AS lastId,
                            MobileNum,
                            LandlineNum,
                            FirstName,
                            LastName,
                            COUNT(id) AS totals,
                            Email
                    FROM
                        contacts
                    GROUP BY MobileNum , LandlineNum , FirstName , LastName
                    HAVING totals > 1) duplic ON duplic.LandlineNum = contacts.LandlineNum
                        AND duplic.FirstName = contacts.FirstName
                        AND duplic.LastName = contacts.LastName
                WHERE
                    contacts.id < duplic.lastId;
                ');
        echo "Duplicated deleted";
        return 0;
    }
}
