# Role & Permission Module — কিভাবে কাজ করে

এই ডকুমেন্টে msradmin প্রজেক্টের role/permission (RBAC) সিস্টেম কিভাবে কাজ করে সেটা ব্যাখ্যা করা হয়েছে, এবং শেষে নতুন permission যোগ করার step-by-step প্রসেস দেওয়া আছে।

---

## ১. এক নজরে আর্কিটেকচার

```
config/permissions.php   →  permission-এর source of truth (গ্রুপ + নাম + লেবেল)
        │  (php artisan db:seed --class=PermissionSeeder)
        ▼
permissions টেবিল        →  DB-তে প্রতিটি permission-এর একটি row
        │
        │  permission_role (pivot টেবিল)
        ▼
roles টেবিল              →  Admin / Manager / Moderator / Staff ...
        │
        │  users.role_id  (একজন user = একটি role)
        ▼
User::hasPermission()    →  role → permissions → নাম মিলিয়ে true/false
        │
        ├── Gate::before()  (AuthServiceProvider)  → সব Gate/Policy চেকে permission নাম কাজ করে
        ├── Policy ক্লাস    (RolePolicy, UserPolicy) → authorizeResource / @can
        └── `permission:` middleware (EnsurePermission) → route-level গার্ড
```

মডেলটা ইচ্ছাকৃতভাবে সিম্পল: **user-এর direct permission নেই, শুধু role-এর permission আছে**, এবং **এক user-এর এক role** (`users.role_id`)।

---

## ২. ফাইলগুলো কী করে

| ফাইল | দায়িত্ব |
| --- | --- |
| `config/permissions.php` | সব permission-এর ডিফিনিশন। গ্রুপ (products/users/roles/settings) → `label` + `permissions` map (`name => label`)। |
| `database/migrations/..._create_permissions_table.php` | `permissions` টেবিল: `name` (unique), `label`, `group`। |
| `database/migrations/..._create_roles_table.php` | `roles` টেবিল: `name` (unique)। |
| `database/migrations/..._create_permission_role_table.php` | pivot: `role_id` + `permission_id`, composite primary key, cascade delete। |
| `database/migrations/..._add_role_id_to_users_table.php` | `users.role_id` FK, nullable, `nullOnDelete`। |
| `database/seeders/PermissionSeeder.php` | `config/permissions.php` পড়ে `Permission::updateOrCreate()` করে — অর্থাৎ **config-ই সত্য, seeder শুধু DB-তে sync করে**। |
| `database/seeders/RoleSeeder.php` | ডিফল্ট role তৈরি করে এবং **Admin role-এ সব permission `sync()` করে**। |
| `app/Models/Permission.php` | `roles()` belongsToMany। |
| `app/Models/Role.php` | `permissions()` belongsToMany, `users()` hasMany। |
| `app/Models/User.php` | `assignedRole()` belongsTo + `hasPermission(string $name): bool`। |
| `app/Providers/AuthServiceProvider.php` | Policy ম্যাপিং + `Gate::before()` যেখানে ability নামকে সরাসরি permission নাম হিসেবে চেক করা হয়। |
| `app/Providers/AppServiceProvider.php` | `permission` alias middleware রেজিস্টার করে। |
| `app/Http/Middleware/EnsurePermission.php` | `$user->can($permission)` না হলে `abort(403)`। |
| `app/Policies/RolePolicy.php`, `UserPolicy.php` | CRUD ability → `hasPermission('roles.view')` ইত্যাদি। |
| `app/Http/Controllers/Admin/RoleController.php` | Role CRUD UI; কনস্ট্রাক্টরে `authorizeResource(Role::class, 'role')`। |
| `app/Services/Admin/RoleService.php` | Role create/update-এ `permissions()->sync($permission_ids)`। |
| `resources/views/admin/Role/create|edit.blade.php` | permission গুলো `groupBy('group')` করে checkbox হিসেবে দেখায়। |

---

## ৩. রানটাইমে চেকটা আসলে কিভাবে হয়

### ৩.১ মূল ফাংশন

```php
// app/Models/User.php
public function hasPermission(string $permission): bool
{
    if (! $this->assignedRole) return false;
    return $this->assignedRole->permissions()->where('name', $permission)->exists();
}
```

প্রতিবার একটা DB query হয় (কোনো cache নেই) — একই রিকোয়েস্টে অনেকবার চেক করলে অনেকগুলো query হবে।

### ৩.২ Gate::before — সবচেয়ে গুরুত্বপূর্ণ অংশ

```php
// app/Providers/AuthServiceProvider.php
Gate::before(function (User $user, string $ability) {
    if ($user->hasPermission($ability)) {
        return true;
    }
});
```

এর মানে **যেকোনো** `$user->can('X')` / `@can('X')` কলে যদি `X` একটা permission নাম হয় (যেমন `products.view`) এবং role-এ সেটা থাকে, তাহলে policy ক্লাস ছাড়াই allow হয়ে যায়। `null` রিটার্ন করলে (permission নেই) Laravel স্বাভাবিক Policy/Gate চেকে চলে যায়।

### ৩.৩ তিনটা এনফোর্সমেন্ট লেয়ার

1. **Route middleware**
   ```php
   Route::get('products', [ProductController::class, 'index'])
       ->middleware('permission:products.view');
   ```
2. **Controller / Policy** — `authorizeResource(Role::class, 'role')` দিলে `index → viewAny`, `create/store → create`, `show → view`, `edit/update → update`, `destroy → delete` ম্যাপ হয় এবং সংশ্লিষ্ট Policy মেথড কল হয়।
3. **Blade** — `@can('update', $role)` (policy) বা `@can('products.create')` (Gate::before দিয়ে সরাসরি permission নাম)।

---

## ৪. একজন user কিভাবে permission পায়

1. `users.role_id` → একটি Role।
2. Role → `permission_role` pivot → Permissions।
3. Admin role-কে `RoleSeeder` সব permission দিয়ে দেয়, তাই **নতুন permission seed করার পর Admin স্বয়ংক্রিয়ভাবে পাবে (seeder আবার চালালে)** — অন্য role-গুলোতে UI থেকে টিক দিতে হবে।
4. Role UI (`/admin/roles/{id}/edit`) থেকে checkbox দিয়ে permission assign হয়, `RoleService::update()` → `permissions()->sync()`।

ডিফল্ট লগইন (`DatabaseSeeder`): `admin@gmail.com` / `12345678`, `role_id = 1` (Admin)।

---

## ৫. নতুন Permission যোগ করার প্রসেস (step by step)

উদাহরণ: **Products module-এ একটা নতুন `products.export` permission** যোগ করবো।

### Step 1 — `config/permissions.php`-এ ডিফাইন করুন

```php
'products' => [
    'label' => 'Products',
    'permissions' => [
        'products.view' => 'View products',
        'products.create' => 'Create products',
        'products.edit' => 'Edit products',
        'products.delete' => 'Delete products',
        'products.approve' => 'Approve products',
        'products.export' => 'Export products',   // ← নতুন
    ],
],
```

নতুন module হলে পুরো নতুন গ্রুপ যোগ করুন:

```php
'orders' => [
    'label' => 'Orders',
    'permissions' => [
        'orders.view' => 'View orders',
        'orders.create' => 'Create orders',
        'orders.edit' => 'Edit orders',
        'orders.delete' => 'Delete orders',
    ],
],
```

নামকরণের কনভেনশন: `module.action` — ছোট হাতের অক্ষর, dot দিয়ে আলাদা।

### Step 2 — Seeder চালিয়ে DB-তে sync করুন

```bash
php artisan db:seed --class=PermissionSeeder
```

`updateOrCreate` ব্যবহার হয়, তাই বারবার চালানো নিরাপদ (কোনো ডুপ্লিকেট হবে না)।

### Step 3 — Admin role-কে নতুন permission দিন

```bash
php artisan db:seed --class=RoleSeeder
```

এটা Admin role-এ সব permission আবার `sync()` করে। (শুধু `PermissionSeeder` চালালে permission DB-তে থাকবে ঠিকই, কিন্তু কোনো role-এ attach হবে না — তখন Admin-ও 403 পাবে।)

### Step 4 — কোডে এনফোর্স করুন

যেভাবে দরকার, যেকোনো একটা/একাধিক:

**(ক) Route middleware:**
```php
Route::get('products/export', [ProductController::class, 'export'])
    ->name('products.export')
    ->middleware('permission:products.export');
```

**(খ) Controller-এর ভেতরে:**
```php
$this->authorize('products.export');            // Gate::before দিয়ে কাজ করবে
// অথবা
abort_unless(auth()->user()->can('products.export'), 403);
```

**(গ) Policy মেথড** (resource CRUD-এর জন্য প্রেফারড):
```php
// app/Policies/ProductPolicy.php
public function export(User $user, Product $product): bool
{
    return $user->hasPermission('products.export');
}
```
নতুন Policy বানালে `AuthServiceProvider::$policies`-এ ম্যাপ করে দিন:
```php
protected $policies = [
    User::class => UserPolicy::class,
    Role::class => RolePolicy::class,
    Product::class => ProductPolicy::class,   // ← নতুন
];
```

**(ঘ) Blade UI (বাটন/মেনু লুকানো):**
```blade
@can('products.export')
    <a href="{{ route('admin.products.export') }}" class="btn btn-secondary">Export</a>
@endcan
```

### Step 4.1 — UI-তে বাটন/মেনু লুকানোর সবচেয়ে সহজ নিয়ম

`Gate::before` থাকার কারণে **Policy ছাড়াই permission নাম সরাসরি `@can`-এ দেওয়া যায়** — এটাই সবচেয়ে কম কোডের উপায়:

```blade
@can('settings.edit')
    <button type="submit" class="btn btn-primary">Save Settings</button>
@endcan

@can('products.export')
    <a href="{{ route('admin.products.export') }}">Export</a>
@endcan

{{-- একাধিকের যেকোনো একটা থাকলে (যেমন পুরো মেনু গ্রুপ) --}}
@canany(['users.view', 'users.create'])
    <li class="nav-item">...</li>
@endcanany
```

মডেল-নির্ভর চেকে (row-per-row বাটন) Policy ব্যবহার করুন, কারণ ওখানে অতিরিক্ত নিয়ম থাকতে পারে (যেমন Admin role এডিট করা যাবে না):

```blade
@can('update', $user)  <a href="...">Edit</a>  @endcan
@can('delete', $role)  <button>Delete</button> @endcan
```

> মনে রাখুন: `@can` শুধু UI লুকায়, সুরক্ষা দেয় না। সার্ভার-সাইডে middleware/`authorize()` অবশ্যই রাখতে হবে।

### Step 5 — অন্য role-গুলোতে assign করুন

`/admin/roles/{id}/edit` → নতুন permission-টা তার group-এর নিচে checkbox হিসেবে দেখাবে → টিক দিয়ে Save। (`create/edit` ভিউ DB থেকে `Permission::all()` নিয়ে `groupBy('group')` করে, তাই আলাদা কোনো UI চেঞ্জ লাগবে না।)

### Step 6 — যাচাই করুন

```bash
php artisan tinker
>>> App\Models\User::where('email','admin@gmail.com')->first()->hasPermission('products.export');
# => true
```
তারপর permission নেই এমন একটি role-এর user দিয়ে লগইন করে দেখুন 403 আসছে কিনা, এবং বাটনটা লুকানো আছে কিনা।

### Step 7 — ডিপ্লয়

ডিপ্লয় স্ক্রিপ্টে seeder দুটো চালাতে ভুলবেন না:

```bash
php artisan migrate --force
php artisan db:seed --class=PermissionSeeder --force
php artisan db:seed --class=RoleSeeder --force
php artisan config:clear   # config cache থাকলে
```

> মনে রাখুন: `config/permissions.php` পরিবর্তন করলে প্রোডাকশনে `php artisan config:cache` আবার চালাতে হবে, না হলে seeder পুরনো ক্যাশড config পড়বে।

---

## ৬. Permission ডিলিট/রিনেম করার সময়

- `PermissionSeeder` শুধু create/update করে, **config থেকে মুছে ফেলা permission DB-তে থেকে যায়** (orphan)। দরকার হলে ম্যানুয়ালি ডিলিট করুন:
  ```php
  App\Models\Permission::whereNotIn('name', collect(config('permissions'))
      ->flatMap(fn ($m) => array_keys($m['permissions']))->all())->delete();
  ```
  pivot cascade delete থাকায় role-এর সাথে সম্পর্কও মুছে যাবে।
- রিনেম করলে DB-তে নতুন row তৈরি হবে; পুরনোটা আলাদা করে মুছতে হবে এবং কোডের সব `hasPermission('old.name')` আপডেট করতে হবে।

---

## ৭. খেয়াল রাখার মতো কিছু বিষয় / সম্ভাব্য ইস্যু

1. **`settings.view` / `settings.edit` কেন কাজ করছিল না (এখন ঠিক করা হয়েছে)।** `SettingsController` এ `authorizeResource(Option::class, 'option')` ছিল, যা `index → viewAny` এবং `update → update` ability চেক করে — permission নাম দুটো নয়। `Gate::before` তখন `hasPermission('viewAny')` খুঁজত (এটা কোনো permission নয়) → `null`, আর `OptionPolicy` না থাকায় Gate সব সময় deny করত। ফলে **সব permission থাকা Admin-ও `/admin/settings` এ 403 পেত**, আর `settings.view` / `settings.edit` কখনোই চেক হতো না। ফিক্স: `OptionPolicy` (`viewAny → settings.view`, `update → settings.edit`) যোগ করা, `AuthServiceProvider::$policies` এ ম্যাপ করা, এবং কন্ট্রোলারে `authorizeResource` এর বদলে সরাসরি `$this->authorize('viewAny', Option::class)` / `$this->authorize('update', Option::class)` কল করা (settings route গুলো resource route নয়, তাই `option` নামে কোনো route-model binding নেই)।
2. **`hasPermission()` এখন per-request cached।** প্রথম কলে role-এর সব permission নাম একবার লোড হয়ে `$permissionNames`-এ রাখা হয়, তাই মেনু/টেবিলে অনেকগুলো `@can` থাকলেও একটাই query হয়। Role-এর permission রানটাইমে বদলালে সেই request-এ পুরনো মান দেখাবে (পরের request-এ ঠিক হয়ে যাবে)।
3. **`Gate::before` সবকিছুর আগে চলে।** কোনো Policy যদি ইচ্ছাকৃতভাবে deny করতে চায় (যেমন `RolePolicy::update()` Admin role এডিট আটকায়), সেটা তখনই কাজ করে যখন ability নামটা permission নাম নয় (`update`, `delete` — এগুলো permission নাম নয়, তাই নিরাপদ)। কিন্তু ভবিষ্যতে কোনো permission-এর নাম যদি `update`-এর মতো plain হয়, guard bypass হয়ে যাবে — তাই সবসময় `module.action` কনভেনশন মেনে চলুন।
4. **Admin role protected**: `RolePolicy` Admin নামের role-কে edit/delete করতে দেয় না, কিন্তু `roles` টেবিলে `id=1`-এর বদলে নাম দিয়ে চেক হয় (`strcasecmp`)। Admin role রিনেম করলে সুরক্ষা চলে যাবে।
5. **একজন user-এর একটাই role।** একাধিক role দরকার হলে `role_user` pivot বানিয়ে `hasPermission()` রিরাইট করতে হবে।

---

## ৮. দ্রুত চিটশিট

```bash
# নতুন permission যোগ করার পর
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RoleSeeder
php artisan config:clear
```

```php
// চেক করার তিন উপায়
auth()->user()->hasPermission('products.export');   // সরাসরি
auth()->user()->can('products.export');             // Gate::before হয়ে
Route::...->middleware('permission:products.export');
```
