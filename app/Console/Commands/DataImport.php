<?php

namespace App\Console\Commands;

use App\Models\State;
use App\Models\Pincode;
use App\Models\District;
use Illuminate\Console\Command;

class DataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        $filename = public_path('State_District_Pincode.csv');
        $delimiter = ',';

        if (!file_exists($filename) || !is_readable($filename))
        {
            return false;
        }


        $header = null;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        foreach ($data as $key => $row) 
        {

            try {
                $state = State::firstOrCreate([
                    'name' => $row['StateName'],
                    'country_id' => '1'
                ],[
                    'status' => 'Active'
                ]);
                $district = District::firstOrCreate([
                    'name' => $row['District'],
                    'state_id' => $state->id
                ],['status' => 'Active']);
    
                $state = Pincode::firstOrCreate([
                    'pincode' => $row['Pincode'],
                    'district_id' => $district->id,
                ],['status' => 'Active']);

            } catch (\Throwable $th) {
               dump($row);
            }
        }

    }
}
