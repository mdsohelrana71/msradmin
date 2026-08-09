# Role & Permission Module

msradmin প্রজেক্টের RBAC (role based access control) সিস্টেম কিভাবে কাজ করে, এবং **নতুন permission কিভাবে যোগ করবেন** — সব এখানে।

---

## ১. আর্কিটেকচার এক নজরে

```
config/permissions.php          ← ★ source of truth (আপনি এখানে লিখবেন)
        │
        │  php artisan db:seed --class=PermissionSeeder
        ▼
permissions টেবিল               ← DB-তে প্রতিটি permission একটা row
        │
        │  permission_role (pivot)   ← Role edit page থেকে টিক দিয়ে সেট হয়
        ▼
roles টেবিল                     ← Admin / Manager / Staff ...
        │
        │  users.role_id             ← এক user = এক role
        ▼
User::hasPermission('brands.edit')  → true / false
        │
        ├── @can('brands.edit')                  → Blade-এ বাটন/মেনু লুকায়   (UX)
        ├── permission:brands.edit  middleware   → রিকোয়েস্ট আটকে 403 দেয়   (Security)
        └── RolePolicy                           → row-নির্ভর extra rule (দরকার হলে)
```

> ডিজাইনটা ইচ্ছাকৃতভাবে সিম্পল: user-এর direct permission নেই, শুধু role-এর permission আছে; আর এক user-এর একটাই role।

---

## ২. নতুন permission যোগ করা — Step by Step

উদাহরণ: একটা **Brand** module বানাচ্ছেন, তার CRUD permission লাগবে।

```
Step 1  config/permissions.php এ লিখুন
Step 2  seeder চালান  →  DB-তে permission তৈরি
Step 3  Controller-এ middleware  →  সার্ভার-সাইড সুরক্ষা
Step 4  Blade-এ @can           →  বাটন/মেনু লুকানো
Step 5  Role edit page থেকে assign করুন
Step 6  দুইটা ভিন্ন user দিয়ে যাচাই করুন
```

---

### Step 1 — `config/permissions.php` এ গ্রুপ যোগ করুন

নাম সবসময় **`module.action`** ফরম্যাটে (নিচে "সতর্কতা" দেখুন, এটা জরুরি)।

```php
// config/permissions.php
return [
    // ... আগের গ্রুপগুলো

    'brands' => [
        'label' => 'Brands',                       // Role edit page-এ গ্রুপের হেডিং
        'permissions' => [
            'brands.view'   => 'View brands',
            'brands.create' => 'Create brands',
            'brands.edit'   => 'Edit brands',
            'brands.delete' => 'Delete brands',
        ],
    ],
];
```

এই ফাইলটাই **একমাত্র জায়গা** যেখানে permission ডিফাইন হয়। কোনো migration লিখতে হবে না।

---

### Step 2 — Seeder চালিয়ে DB-তে নিয়ে আসুন

```bash
php artisan config:clear                          # config cache থাকলে জরুরি
php artisan db:seed --class=PermissionSeeder      # config পড়ে permissions টেবিলে updateOrCreate
php artisan db:seed --class=RoleSeeder            # Admin role-এ সব permission sync করে
```

`PermissionSeeder` **idempotent** — যতবার খুশি চালানো যায়, ডুপ্লিকেট হবে না।

যাচাই:
```bash
php artisan tinker
>>> App\Models\Permission::where('group','Brands')->pluck('name');
# group কলামে গ্রুপের `label` সেভ হয় (key নয়) — তাই 'Brands'
```

---

### Step 3 — Controller-এ middleware (★ আসল সুরক্ষা)

```php
// app/Http/Controllers/Admin/BrandController.php
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BrandController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:brands.view',   only: ['index', 'show']),
            new Middleware('permission:brands.create', only: ['create', 'store']),
            new Middleware('permission:brands.edit',   only: ['edit', 'update']),
            new Middleware('permission:brands.delete', only: ['destroy']),
        ];
    }
}
```

Route ফাইলে কিছু বদলাতে হবে না:
```php
Route::resource('brands', BrandController::class);
```

চেক করুন সব route-এ middleware বসেছে কিনা:
```bash
php artisan route:list --path=admin/brands
```

> **কেন কনস্ট্রাক্টরে নয়?** Laravel 11+ এ base controller থেকে `$this->middleware()` সরিয়ে ফেলা হয়েছে। তাই এই প্রজেক্টে `HasMiddleware` ইন্টারফেস + static `middleware()` মেথড ব্যবহার করা হয় (`UserController`, `RoleController`, `SettingsController` — সবগুলোই এই প্যাটার্নে)।

---

### Step 4 — Blade-এ `@can` দিয়ে বাটন/মেনু লুকান

```blade
@can('brands.create')
    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Add Brand</a>
@endcan

@can('brands.edit')
    <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-warning">Edit</a>
@endcan

@can('brands.delete')
    <button type="submit" class="btn btn-danger">Delete</button>
@endcan

{{-- মেনু গ্রুপ: যেকোনো একটা permission থাকলেই দেখাবে --}}
@canany(['brands.view', 'brands.create'])
    <li class="nav-item">...</li>
@endcanany
```

> ⚠️ `@can` **শুধু UI লুকায়, সুরক্ষা দেয় না** — DevTools দিয়ে বাটন ফিরিয়ে আনা যায়, সরাসরি URL হিট করা যায়। তাই Step 3 বাদ দেওয়া যাবে না। দুটো একসাথে:
> `@can` = ইউজার এমন বাটন দেখবে না যা ক্লিক করলে 403 খাবে · middleware = আসল গার্ড।

---

### Step 5 — Role-এ assign করুন

`/admin/roles/{id}/edit` এ যান → **Brands** গ্রুপটা নিজে থেকেই checkbox হিসেবে দেখাবে → টিক দিয়ে Save।

(কোনো UI কোড লিখতে হবে না — ভিউ `Permission::all()` নিয়ে `groupBy('group')` করে দেখায়।)

---

### Step 6 — যাচাই করুন

```bash
php artisan tinker
>>> App\Models\User::where('email','admin@gmail.com')->first()->hasPermission('brands.edit');
# => true
```

তারপর **দুইটা user দিয়ে** ব্রাউজারে দেখুন:

| যাচাই | permission আছে | permission নেই |
| --- | --- | --- |
| বাটন/মেনু দেখা যায়? | হ্যাঁ | না (Step 4) |
| সরাসরি URL হিট (`/admin/brands/create`) | 200 | **403** (Step 3) |

---

### Step 7 — ডিপ্লয়ের সময়

```bash
php artisan migrate --force
php artisan db:seed --class=PermissionSeeder --force
php artisan db:seed --class=RoleSeeder --force
php artisan config:clear
```

`config/permissions.php` বদলালে প্রোডাকশনে `config:cache` আবার চালাতে হবে, না হলে seeder পুরনো ক্যাশড config পড়বে।

---

## ৩. Policy কখন লাগবে, কখন লাগবে না

| পরিস্থিতি | কী ব্যবহার করবেন | Policy লাগবে? |
| --- | --- | --- |
| "এই permission আছে কিনা" | `@can('brands.edit')` | **না** |
| Route/Controller গার্ড | `permission:brands.edit` middleware | **না** |
| "কোন **row**" তার উপর নির্ভরশীল নিয়ম | `@can('update', $brand)` + `$this->authorize('update', $brand)` | **হ্যাঁ** |

সহজ নিয়ম: **মডেল পাস করলে Policy লাগবে, permission নাম লিখলে লাগবে না।**

Policy দরকার হয় এমন উদাহরণ: "শুধু নিজের তৈরি brand এডিট করা যাবে", "published record ডিলিট করা যাবে না", "Admin role এডিট/ডিলিট করা যাবে না"।

এই প্রজেক্টে **একটাই Policy আছে** — `RolePolicy`, আর তাতে শুধু দুইটা মেথড:

```php
// app/Policies/RolePolicy.php
public function update(User $user, Role $role): bool
{
    if (strcasecmp($role->name, 'admin') === 0) {
        return false;                       // Admin role কখনোই এডিট করা যাবে না
    }
    return $user->hasPermission('roles.edit');
}
```

নতুন Policy বানালে `AuthServiceProvider::$policies` এ ম্যাপ করে দিন:
```php
protected $policies = [
    Role::class  => RolePolicy::class,
    Brand::class => BrandPolicy::class,   // ← নতুন
];
```

---

## ৪. পারমিশন চেক করার সব উপায়

```php
// PHP
$user->hasPermission('brands.edit');       // সরাসরি
$user->can('brands.edit');                 // Gate (Gate::before এর মধ্য দিয়ে)
$this->authorize('update', $brand);        // Policy (মডেল পাস করা হয়েছে)
abort_unless($user->can('brands.edit'), 403);
```

```blade
{{-- Blade --}}
@can('brands.edit') ... @endcan
@canany(['brands.view', 'brands.create']) ... @endcanany
@cannot('brands.delete') ... @endcannot
```

```php
// Route
Route::get('brands', [BrandController::class, 'index'])->middleware('permission:brands.view');
```

মূল ব্যাপারটা `AuthServiceProvider` এ:
```php
Gate::before(function (User $user, string $ability) {
    if ($user->hasPermission($ability)) {
        return true;                       // ability নামটাই permission নাম হলে সরাসরি allow
    }
});                                        // null রিটার্ন করলে Laravel স্বাভাবিক Policy চেকে যায়
```
এই লাইনগুলোর জন্যই **Policy ছাড়াই** `@can('brands.edit')` কাজ করে।

---

## ৫. ফাইলগুলো কী করে

| ফাইল | দায়িত্ব |
| --- | --- |
| `config/permissions.php` | সব permission-এর ডিফিনিশন (গ্রুপ → `label` + `permissions`)। |
| `database/seeders/PermissionSeeder.php` | config পড়ে `Permission::updateOrCreate()` করে। |
| `database/seeders/RoleSeeder.php` | ডিফল্ট role বানায়, Admin role-এ সব permission `sync()` করে। |
| `app/Models/User.php` | `assignedRole()` + `hasPermission()` (per-request cached)। |
| `app/Models/Role.php` | `permissions()` belongsToMany, `users()` hasMany। |
| `app/Providers/AuthServiceProvider.php` | `Gate::before()` + Policy ম্যাপিং। |
| `app/Providers/AppServiceProvider.php` | `permission` alias middleware রেজিস্টার করে। |
| `app/Http/Middleware/EnsurePermission.php` | `$user->can($permission)` না হলে `abort(403)`। |
| `app/Policies/RolePolicy.php` | শুধু `update()`/`delete()` — Admin role protect করে। |
| `app/Services/Admin/RoleService.php` | Role save-এ `permissions()->sync($permission_ids)`। |
| `resources/views/admin/Role/create|edit.blade.php` | permission গুলো `groupBy('group')` করে checkbox দেখায়। |

DB স্ট্রাকচার: `permissions` (name unique, label, group) · `roles` (name unique) · `permission_role` (pivot, cascade delete) · `users.role_id` (FK, nullable, `nullOnDelete`)।

---

## ৬. Permission ডিলিট বা রিনেম

`PermissionSeeder` শুধু create/update করে — **config থেকে মুছে ফেলা permission DB-তে orphan হয়ে থেকে যায়**। দরকার হলে:

```php
App\Models\Permission::whereNotIn('name', collect(config('permissions'))
    ->flatMap(fn ($m) => array_keys($m['permissions']))->all())->delete();
```
pivot-এ cascade delete থাকায় role-এর সাথে সম্পর্কও মুছে যাবে।

রিনেম করলে DB-তে নতুন row তৈরি হয় — পুরনোটা আলাদা করে মুছতে হবে, আর কোডের সব `hasPermission('old.name')` / `@can('old.name')` আপডেট করতে হবে।

---

## ৭. সতর্কতা

1. **`module.action` কনভেনশন কখনো ভাঙবেন না।** `Gate::before` সব Policy-র আগে চলে। কোনো permission-এর নাম যদি plain `update` বা `delete` হয়, তাহলে সেই permission থাকা user-এর জন্য Policy-র deny (যেমন "Admin role এডিট করা যাবে না") **bypass** হয়ে যাবে।
2. **`hasPermission()` per-request cached।** প্রথম কলে role-এর সব permission একবার লোড হয়, তাই মেনু/টেবিলে অনেকগুলো `@can` থাকলেও একটাই query হয়। রানটাইমে permission বদলালে সেই request-এ পুরনো মান দেখাবে।
3. **Admin role নাম দিয়ে protect করা** (`strcasecmp($role->name, 'admin')`) — role রিনেম করলে সুরক্ষা চলে যাবে। `id` বা `is_system` কলাম দিয়ে চেক করা বেশি নিরাপদ।
4. **এক user = এক role।** একাধিক role দরকার হলে `role_user` pivot বানিয়ে `hasPermission()` রিরাইট করতে হবে।
5. **শুধু `@can` দিয়ে কাজ শেষ ভাববেন না** — middleware ছাড়া module unprotected।
