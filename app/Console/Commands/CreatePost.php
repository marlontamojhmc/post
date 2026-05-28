<?php
    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use App\Models\Post;

    class CreatePost extends Command
    {
        protected $signature = 'post:create {title} {content}';

        protected $description = 'Create a new post';

        public function handle()
        {
            $post = Post::create([
                'title' => $this->argument('title'),
                'description' => $this->argument('content'),
            ]);

            $this->info("Post created with ID: " . $post->id);
        }
    }