


One to one relationship
Define the relationships in the models:

In the User model, define a hasOne relationship to the Profile model. This indicates that a user has one profile.
In the Profile model, define a belongsTo relationship to the User model. This establishes the reverse relationship, indicating that a profile belongs to a user.
Here's an example of how the relationships can be defined in the models:

// User.php

class User extends Model
{
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }
}

// Profile.php

class Profile extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

For Insert:
    by Only User Model with hasOne relationship: 
                $user = new User();
                $user->name = 'John Doe';
                $user->email = 'john@example.com';
                $user->password = bcrypt('password');
                $user->save();

                $profile = new Profile();
                $profile->bio = 'A brief bio';
                $profile->website = 'https://example.com';
                $user->profile()->save($profile);
    By Using  belongsTo relationship: 
                $user = new User();
                $user->name = 'John Doe';
                $user->email = 'john@example.com';
                $user->password = bcrypt('password');
                $user->save();

                $profile = new Profile();
                $profile->bio = 'A brief bio';
                $profile->website = 'https://example.com';
                $profile->user()->associate($user);
                $profile->save();    
                
                
For Update:                 
    By Only User Model with hasOne relationship:  
                $user = User::find($userId);
                $user->name = 'Updated Name';
                $user->email = 'updated@example.com';
                $user->save();

                $user->profile->bio = 'Updated bio';
                $user->profile->website = 'https://updated.com';
                $user->profile->save();
    By Using  belongsTo relationship: 
                $user = User::find($userId);
                $user->name = 'Updated Name';
                $user->email = 'updated@example.com';
                $user->save();

                $profile = $user->profile;
                $profile->bio = 'Updated bio';
                $profile->website = 'https://updated.com';
                $profile->save();

For Fetch:
    By Only User Model with hasOne relationship: 
                $user = User::with('profile')->find($userId);
                NOTE: You can then access the user's attributes like $user->name, $user->email, and the associated profile's attributes like $user->profile->bio, $user->profile->website, etc.
    By Using  belongsTo relationship:
                $profile = Profile::with('user')->find($profileId);
                NOTE: You can then access the profile's attributes like $profile->bio, $profile->website, and the associated user's attributes like $profile->user->name, $profile->user->email, etc.