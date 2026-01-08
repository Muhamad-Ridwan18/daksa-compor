<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateServiceSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for all services that don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $services = Service::whereNull('slug')->orWhere('slug', '')->get();
        
        if ($services->isEmpty()) {
            $this->info('All services already have slugs.');
            return 0;
        }

        $this->info("Generating slugs for {$services->count()} service(s)...");

        $bar = $this->output->createProgressBar($services->count());
        $bar->start();

        foreach ($services as $service) {
            $baseSlug = Str::slug($service->name);
            $slug = $baseSlug;
            $counter = 1;

            // Ensure unique slug
            while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $service->update(['slug' => $slug]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Slugs generated successfully!');

        return 0;
    }
}
