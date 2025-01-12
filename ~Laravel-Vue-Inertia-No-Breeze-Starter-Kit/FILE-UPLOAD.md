# FILE 

# Create an input file with `@input=""` and add an `avatar` property to form.
### Register.vue
> Inertia automatically converts a request data into a FormData Object, automatically add a multipart/form-data.
```
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null
})

const change = (e) => {
    form.avatar = e.target.files[0];
}
        <form @submit.prevent="submit">
            <div>
                <label for="avatar">avatar</label>
                <input type="file" id="avatar" @input="change">
                {{ form.errors.avatar }}
            </div>

...
```

# Add `avatar` to the `create_users_table.php`
### migrations
```
...

Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('avatar')->nullable();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

...
```

# Add
### Model/Users.php
```
...

protected $fillable = [
    'name',
    'avatar',
    'email',
    'password',
];

...
```

### Update the database
```
php artisan migrate:fresh
```

# Add the `avatar` to the validate method and add a `hasFile` method 
```
...

$fields = $request->validate([
    'avatar' => 'file|nullable|max:300',
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255|unique:users',
    'password' => 'required|confirmed',
]);

if($request->hasFile('avatar')){
    $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
}

...
```

### AuthController.php
```
...

public function register(Request $request){

    // validate
    $fields = $request->validate([
        'avatar' => 'file|nullable|max:300',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed',
    ]);

    if($request->hasFile('avatar')){
        $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
    }

    // register
    $user = User::create($fields);

    // login
    Auth::login($user);

    // redirect
    return redirect()->route('dashboard');
}

...
```

# create a `symbolic link` for everyone to access
> This creates an `avatar` folder to the public folder
```
php artisan storage:link
```

# Use Avatar to the Front-end
> Share it by including in the `HandleInertiaRequests.php`
```
...

public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth.user' => fn () => $request->user()
            ? $request->user()->only('id', 'name', 'avatar')
            : null,
    ]);
}
```

# Display it in the Layout
### Layouts/layout.vue
```
...

<img class="avatar" :src="$page.props.auth.user.avatar ? ('storage/' + $page.props.auth.user.avatar) : ('storage/avatars/default.jpg')" width="100" alt="">

...
```

<br>
<hr>
<br>

# Update the Register page
> add a `preview`
```
...
const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null
})

const change = (e) => {
    form.avatar = e.target.files[0];
    form.preview = URL.createObjectURL(e.target.files[0])
}

...

<form @submit.prevent="submit">
            <div class="grid place-items-center">
                <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300">
                    <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer">
                        <span class="bg-white/70 pb-2 text-center">Avatar</span>
                    </label>
                    <input type="file" @input="change" id="avatar" hidden/>

                    <img class="object-cover w-28 h-28" :src="form.preview ?? 'storage/avatars/default.jpg'" alt=""/>
                </div>

                <p class="error mt-2">{{ form.errors.avatar }}</p>
            </div>

...

```