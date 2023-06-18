# Many to many relationship
a many-to-many relationship is a user that has many roles and those roles are also shared by other users in the application

# 1): Set up your models and migrations:

    1->Create the User and Role models using the make:model Artisan command.
    2->Generate migrations for both tables using the make:migration Artisan command.
    3->Create a migration for the pivot table using the make:migration command, which should have columns for the foreign keys of both tables.
php artisan make:model User
php artisan make:model Role
php artisan make:migration create_users_table
php artisan make:migration create_roles_table
php artisan make:migration create_user_role_table

# 2):Define relationships in the models:
    In the User model, define the roles relationship using the belongsToMany method, specifying the Role model and the name of the pivot table.
      // User.php
    
        namespace App\Models;

        use Illuminate\Database\Eloquent\Model;

        class User extends Model
        {
            public function roles() : BelongsToMany
            {
                return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id', 'id', 'id');
            }
        }
    
        Let's break down the parameters:

        Role::class: The related model class that the User model is associated with. In this example, we assume the related model is Role.

        'role_user': The name of the pivot table that connects the User and Role models.

        'user_id': The foreign key column name in the pivot table that references the User model.

        'role_id': The foreign key column name in the pivot table that references the Role model.

        'id': The local key column name in the User model. It represents the primary key of the User model.

        'id': The related key column name in the Role model. It represents the primary key of the Role model.



    In the Role model, define the users relationship in the same way.
        
        // Role.php
    
        namespace App\Models;

        use Illuminate\Database\Eloquent\Model;

        class Role extends Model
        {
            public function users(): BelongsToMany
            {
                return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id', 'id', 'id');
            }
        }
    
        Let's explain the parameters:

        User::class: The related model class that the Role model is associated with. In this example, we assume the related model is User.

        'role_user': The name of the pivot table that connects the Role and User models.

        'role_id': The foreign key column name in the pivot table that references the Role model.

        'user_id': The foreign key column name in the pivot table that references the User model.

        'id': The local key column name in the Role model. It represents the primary key of the Role model.

        'id': The related key column name in the User model. It represents the primary key of the User model.


# 3): Run the migrations to create the tables.
     
       php artisan migrate
      
# Inserting records with relationships:
        
            $user = new User();
            $user->name = 'John Doe';
            $user->email = 'john@example.com';
            $user->save();
            $roleIds = [2, 3, 4];
            $user->roles()->attach($roleIds);
        

# Updating records with relationships:
    Retrieve the user you want to update:
            $user = User::find(1);
    Retrieve the role IDs you want to update. For example, if you have an array of updated role IDs:
            $updatedRoleIds = [2, 4, 6];
    Sync the roles for the user:
            $user->roles()->sync($updatedRoleIds);
    This will update the records in the pivot table to associate the user with the updated roles. 
Full Example:
        
            $user = User::find(1);
            $updatedRoleIds = [2, 4, 6];
            $user->roles()->sync($updatedRoleIds);
        

# Fetch Records:
    To Retrieve all roles associated with a user: 
    
            $user = User::with('roles')->find(1);
            $roles = $user->roles;
          
    To Retrieve all users associated with a role:
    
            $role = Role::with('users')->find(1);
            $users = $role->users;
         
    To retrieve users who have a specific role using the whereHas method.
    
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->get();
           

       
             



 
        

