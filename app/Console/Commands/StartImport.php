<?php

namespace App\Console\Commands;

use App\Imports\JobsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class StartImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:job-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command use to execute import of jobs from CSV file located in storage/app';

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
        $this->output->title('Starting import');

        if (Storage::exists('sample_data.csv')) {
            $file = storage_path('app\sample_data.csv');

            try {
                (new JobsImport)->withOutput($this->output)->import($file);
                $this->output->success('Import successful');
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                $message = 'The following errors receive please check values and try again: ';
                foreach ($failures as $failure) {
                    if ($failure->errors() && count($failure->errors()) > 0) {
                        $message .= "{$failure->errors()[0]} | ";
                    }
                }
                $this->output->newLine();
                $this->output->title($message);
            }
            return;
        }

        $this->info('-- File not found!');
    }
}
