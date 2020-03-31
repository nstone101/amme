<?php

namespace App\Console\Commands;

use App\Repository\BlogRepository;
use Illuminate\Console\Command;

class UpdateBlogSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make blog slug if the slug is null';

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
     * @return mixed
     */
    public function handle(BlogRepository $blogRepo)
    {
        $blogRepo->updateBlogSlug();
    }
}
