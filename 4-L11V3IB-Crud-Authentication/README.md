special mentions,

- validations
- error trapping
- javascript challenge / basic to hard
- php challenge / basic to hard

--------------------------------------------

# crud operation

# web.php
> setup a route
```
Route::resource('products', ProductController::class);
```

# Create a Model, Migration, and Controller file with Resource in it (functions)
> mcr (model, controller, resource)
```
php artisan make:model Product -mcr
```

#  Migration file
```
Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->timestamps();
        });
```
# Migrate the newly created migration file to the database
> run
```
php artisan migrate
```

#  Configure the Model
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        "name", 
        "price"
    ];
}
```

# Configure the Controller for Index
```
public function index()
    {
        return Inertia::render('Frontend/Products/Index');
    }
```

# Create an Index.vue Layout

```
<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Products"/>

    <FrontendLayout>
        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h5>Product Lists</h5>
                <Link :href="route('products.create')" 
                class="bg-blue-500 text-white p-3 rounded mb-4">Add Product</Link>
            </div>
            <table class="w-full bg-white border border-gray-200 shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left border">Id</th>
                        <th class="py-2 px-4 text-left border">Name</th>
                        <th class="py-2 px-4 text-left border">Price</th>
                        <th class="py-2 px-4 text-left border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4 border">1</td>
                        <td class="py-2 px-4 border">Apple</td>
                        <td class="py-2 px-4 border">150</td>
                        <td class="py-2 px-4 border">
                            <Link 
                                :href="route('products.create')" 
                                class="px-2 py-1 text-sm bg-blue-300 text-dark me-2 rounded inline-block"
                            >
                                Show
                            </Link>

                            <Link 
                                :href="route('products.create')" 
                                class="px-2 py-1 text-sm bg-green-500 text-white me-2 rounded inline-block"
                            >
                                Edit
                            </Link>

                            <button
                                type="submit"
                                class="px-2 py-1 text-sm bg-danger-500 text-white me-2 rounded inline-block"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </FrontendLayout>
</template>
```

# Configure the Controller for Create
```
public function index()
    {
        return Inertia::render('Frontend/Products/Create');
    }
```

# Create a Create.vue Layout
### https://inertiajs.com/forms
```
<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    price: ''
});

const saveProduct = () => {
    const res = form.post(route('products.store'));

    if(res){
        form.reset();
    }
}

</script>

<template>

    <Head title="Create Product"/>

    <FrontendLayout>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h5>Product Lists</h5>
                <Link :href="route('products.index')" class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block">Back</Link>
            </div>
            
            <form @submit.prevent="saveProduct()">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" v-model="form.name" class="py-1 w-full" />
                        </div>
                        <div class="mb-3">
                            <label>Product Price</label>
                            <input type="text" v-model="form.price" class="py-1 w-full" />
                        </div>
                        <div class="mb-3">
                            <Link 
                                :href="route('products.index')" 
                                class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block"
                            >
                                Back
                            </Link>
                            <button
                                type="submit"
                                class="bg-blue-500 text-white py-2 px-5 rounded mb-4"
                            >
                                Save
                            </button> 
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </FrontendLayout>

</template>
```

# Configure the Controller for Store
```
public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer'
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->to('/products')->with('message', 'Product created successfully.');
    }
```

# Validation
### https://inertiajs.com/validation
> Create.vue
```
defineProps({ 
    errors: Object 
});
```
```
<div class="mb-3">
    <label>Product Name</label>
    <input type="text" v-model="form.name" class="py-1 w-full" />
    <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</div>
</div>
<div class="mb-3">
    <label>Product Price</label>
    <input type="text" v-model="form.price" class="py-1 w-full" />
    <div v-if="errors.price" class="text-red-500 text-sm">{{ errors.price }}</div>
</div>
```

# Sharing data
### https://inertiajs.com/shared-data#sharing-data
> HandleInertiaRequest.php (flash)
> add flash to share function
```
public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
        ];
    }
```
> Layouts/FrontendLayout.vue
```
<script setup>
import Navbar from '@/Components/Navbar.vue';
</script>

<template>
    <div>
        <Navbar />

        <div v-if="$page.props.flash.message" class="alert text-green-600 mt-4 ml-4">
            {{ $page.props.flash.message }}
        </div>

        <slot />
    </div>
</template>
```

<hr/>
<br>

# Display Products from the Database
> ProductController.php
```
public function index()
    {
        $products = Product::all();

        return Inertia::render('Frontend/Products/Index', [
            'products' => $products
        ]);
    }
```

# Implement the data in the front-end and change the <body> part using v-for.
> Index.vue
```
<tbody>
    <tr 
        v-for="(item, index) in products" :key="index"
    >
        <td class="py-2 px-4 border">{{ item.id }}</td>
        <td class="py-2 px-4 border">{{ item.name }}</td>
        <td class="py-2 px-4 border">{{ item.price }}</td>
        <td class="py-2 px-4 border">
            <Link 
                :href="route('products.show', item.id)" 
                class="px-2 py-1 text-sm bg-blue-300 text-dark me-2 rounded inline-block"
            >
                Show
            </Link>

            <Link 
                :href="route('products.edit', item.id)" 
                class="px-2 py-1 text-sm bg-green-500 text-white me-2 rounded inline-block"
            >
                Edit
            </Link>

            <button
                type="submit"
                class="px-2 py-1 text-sm bg-red-600 text-white me-2 rounded inline-block"
            >
                Delete
            </button>
        </td>
    </tr>
</tbody>
```

# Implementation of `Edit` function
> ProductController.php
```
public function edit(Product $product)
    {
        return Inertia::render('Frontend/Products/Edit', [
            'product' => $product
        ]);
        
    }
```

# Create an Edit.vue Layout
> copy the Create.vue Layout and change some parts 
```
<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ 
    errors: Object,
    product: Object
});

const form = useForm({
    name: props.product.name,
    price: props.product.price
});

const updateProduct = () => {
    const res = form.put(route('products.update', props.product.id));

    if(res){
        form.reset();
    }
}

</script>

<template>

    <Head title="Edit Product"/>

    <FrontendLayout>

        <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
        </div>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h5>Edit Product</h5>
                <Link :href="route('products.index')" class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block">Back</Link>
            </div>
            
            <form @submit.prevent="updateProduct()">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" v-model="form.name" class="py-1 w-full" />
                            <div v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</div>
                        </div>
                        <div class="mb-3">
                            <label>Product Price</label>
                            <input type="text" v-model="form.price" class="py-1 w-full" />
                            <div v-if="errors.price" class="text-red-500 text-sm">{{ errors.price }}</div>
                        </div>
                        <div class="mb-3">
                            <Link 
                                :href="route('products.index')" 
                                class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block"
                            >
                                Back
                            </Link>
                            <button
                                type="submit"
                                class="bg-blue-500 text-white py-2 px-5 rounded mb-4"
                            >
                                Update
                            </button> 
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </FrontendLayout>

</template>
```

# Implementation of `Update` function
> ProductController.php
```
public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer'
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        return redirect()->to('/products')->with('message', 'Product updated successfully.');
    }
```

# Submission Trapping for the `Update` and `Save` Buttons
### https://inertiajs.com/forms#form-helper
> This is basically to prevent button spamming. 
> Create.vue

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

> Edit.vue

```
<button
    type="submit"
    :disabled="form.processing"
    class="bg-blue-500 text-white py-2 px-5 rounded mb-4"
>
    <span v-if="form.processing">Updating...</span>
    <span v-else>Update</span>
</button> 
```

img /////////////////////////////////////////////////////////////////////////////////////////

# Implementation of `Show` function
> ProductController.php

```
public function show(Product $product)
    {
        return Inertia::render('Frontend/Products/Show', [
            'product' => $product
        ]);
    }
```

# Create a Show.vue Layout
> copy the Edit.vue Layout and change some parts 
```
<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({ 
    errors: Object,
    product: Object
});

</script>

<template>

    <Head title="Show Product"/>

    <FrontendLayout>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h5>Show Product</h5>
                <Link :href="route('products.index')" class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block">Back</Link>
            </div>
            
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <div class="mb-3">
                        <label>Product Name</label>
                        <p>
                            {{ product.name }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label>Product Price</label>
                        <p>
                            {{ product.price }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </FrontendLayout>

</template>
```

# Implementation of `Delete` function
> Index.vue
```
const form = useForm({});

const deleteProduct = (productId) => {
    if(confirm('Are you sure you want to delete this product?')){
        form.delete(route('products.destroy', productId));
    }
}

<button
    type="submit"
    class="px-2 py-1 text-sm bg-red-600 text-white me-2 rounded inline-block"
    @click="deleteProduct(item.id)"
>
    Delete
</button>
```

> ProductController.php
```
public function destroy(Product $product)
{
    $product->delete();

    return redirect()->to('/products')->with('message', 'Product deleted successfully.');
}
```

# Congratulations!