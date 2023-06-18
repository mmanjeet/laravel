One to many relationship
A one-to-many relationship is used to define relationships where a single model is the parent to one or more child models. 

// User.php
public function posts()
{
    return $this->hasMany(Post::class);
}
// Post.php    
public function user()
{
    return $this->belongsTo(User::class);
}

//For insertion    
        $user = new User(['name' => 'John Doe']);
        $user->save();

        // Create posts and associate them with the user
        $posts = [
            new Post(['title' => 'First Post', 'content' => 'Hello, World!']),
            new Post(['title' => 'Second Post', 'content' => 'Another post example']),
        ];

        foreach ($posts as $post) {
            $user->posts()->save($post);
        }


// For update

        $user = User::find($userId);
        $user->name = 'Updated Name';
        foreach ($user->posts as $post) {
            $post->title = 'Updated Title';
            $post->content = 'Updated Content';
            $post->save();
        }

// For Fetch
        //Retrieve a User model with its associated posts:
        $user = User::with('posts')->find($userId);

        //Retrieve a Post model with its associated User:
        $post = Post::with('user')->find($postId);