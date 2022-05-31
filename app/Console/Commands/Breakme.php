<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\Sample;
use Illuminate\Console\Command;

class Breakme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'breakme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger a segmentation fault';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        // Create a user.
        $user = new User([
            'name'      => 'Foo',
            'email'     => time() . '@example.com',
            'password'  => 'xyz',
        ]);
        $user->save();

        // Create a post.
        $user->posts()->create();

        foreach ($user->posts as $post) {

            // This line triggers the segmentation fault; commenting out resolves it.
            $post->setRelation('user', $user);

            Sample::dispatch($user);
        }
    }
}
