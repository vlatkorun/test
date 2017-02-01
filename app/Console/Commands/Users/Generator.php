<?php

namespace App\Console\Commands\Users;

use Illuminate\Console\Command;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class Generator extends Command
{
    protected $signature = 'users:generate';

    protected $description = 'Generate fake users';

    private $factory;

    public function __construct(Faker $faker)
    {
        $this->factory = EloquentFactory::construct($faker);
        parent::__construct();
    }

    public function handle()
    {
        $count = $this->ask('Enter users number');

        if((int) $count === 0)
        {
            $this->error('Please enter number greater than 0!');
            return;
        }

        $this->line(sprintf('%d users will be created.', $count));

        if($this->confirm('Please confirm? [y|N]'))
        {
            $users = $this->factory->of(User::class)->times($count)->create();

            $this->line(sprintf('%d users were created:', $count));

            $this->table(['Name', 'Email'], $users->map(function($user) { return [$user->name, $user->email]; })->all());
        }
    }
}