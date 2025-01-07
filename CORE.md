## Commands

```
composer create-project --prefer-dist laravel/laravel:11^ ProjectName
```

```
composer require laravel/breeze --dev
```

```
php artisan breeze:install vue
```

<hr>

# Contents

- [Creating Pages](#creating-pages)
- [Different Routing](#different-routing)
- [Form helper (post, put, delete) directed to route](#form-helper-post-put-delete-directed-to-route)
- [Form Processing](#form-processing)
- [Data Validation](#data-validation)
- [Flash Message](#flash-message)

# Creating Pages

<img src="./assets/Creating-Pages.png">

<br>

# Different Routing

<img src="./assets/Different-Routing-Through-Pages.png">

<br>

# Form helper (post, put, delete) directed to route

<img src="./assets/Form-Helper.png">

<br>

# Data Validation

1. ### We want to prevent this kind of error to pop-up when inputting a wrong data to an input field and to have a display message instead.

<img src="./assets/Validation.png">

2. ### This is our store function without a validation.

<img src="./assets/Validation-1.png">

3. ### And in order to get the data for our display message, we need to include validate() to our controller.

<img src="./assets/Validation-2.png">

4. ### Then use it to our Frontend.

<img src="./assets/Validation-3.png">

5. ### as you can see, we have now a validation error display on our Frontend.

<img src="./assets/Validation-4.png">

<br>

# Form Processing
### prevents the mutiple insertion of data upon clicking request.

```
<button
    type="submit"
    :disabled="form.processing"
    class="bg-blue-500 text-white py-2 px-5 rounded mb-4"
>
    <span v-if="form.processing">Saving...</span>
    <span v-else>Save</span>
</button> 
```
### now we can have this pending state after clicking the button
<img src="./assets/Form-Processing.png">

<br>

# Flash Message
### messages stored in the session only for the next request, display a message in the frontend after a successful request.

### Search for `HandleInertiaRequests` and add `flash` to the `share()` function

<img src="./assets/Shared-Data.png">

### Set a return message to your frontend as you redirected
> AnyController.php
```
return redirect()->to('/products')->with('message', 'Product updated successfully.');
```

### And add this to your Layout where you redirected after a successful request.
> Layout.vue
```
<div v-if="$page.props.flash.message" class="alert text-green-600 mt-4 ml-4">
    {{ $page.props.flash.message }}
</div>
```

<img src="./assets/Shared-Data-1.png">

### Output as per successful request

<img src="./assets/Shared-Data-3.png">
