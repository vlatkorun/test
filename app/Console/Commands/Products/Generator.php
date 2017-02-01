<?php

namespace App\Console\Commands\Products;

use Illuminate\Console\Command;
use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class Generator extends Command
{
    protected $signature = 'products:generate';

    protected $description = 'Generate fake products';

    private $factory;

    public function __construct(Faker $faker)
    {
        $this->factory = EloquentFactory::construct($faker);
        parent::__construct();
    }

    public function handle()
    {
        $count = $this->ask('Enter products number');

        if((int) $count === 0)
        {
            $this->error('Please enter number greater than 0!');
            return;
        }

        $this->line(sprintf('%d products will be created.', $count));

        if($this->confirm('Please confirm? [y|N]'))
        {
            $this->factory->of(Product::class)->times($count)->create();
            $this->line(sprintf('%d products were created:', $count));
        }
    }
}