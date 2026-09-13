# Tara Travel — Admin Dashboard

A separate Laravel app that reads and writes the **same Supabase Postgres
database** as the `tara-travel-Android` Flutter app. It doesn't touch your
mobile app's code or its Supabase migrations — it just connects to the same
database as a second client, the way a Laravel app would connect to any
Postgres database.

Covers: **Users & trips** (search, detail, trip status moderation),
**Expenses & settlements** (approve/reject queue, settlement confirmation),
**Destinations & content** (full CRUD — this feeds the app's Explore tab
directly), and an **Analytics** dashboard (signups/trips growth chart, top
destinations, key stats).

## Before you start — what's here vs. what isn't

This was built in a sandbox with no access to Packagist, so `composer
install` couldn't be run or verified here. What you're getting is complete,
hand-written application code — every plain PHP file passed `php -l` syntax
checking — but it hasn't booted against a real Laravel installation yet.
The steps below get you there in about five minutes.

## 1. Scaffold a fresh Laravel app

```bash
composer create-project laravel/laravel tara-admin
cd tara-admin
```

This gives you `vendor/`, `artisan`, `public/index.php`, and everything
else Composer needs to manage — none of that is included here since it's
generated, not hand-written.

## 2. Drop in this project's files

Copy everything from this delivery **on top of** the fresh install,
overwriting where prompted:

```
app/Models/               → app/Models/
app/Http/Controllers/Admin/ → app/Http/Controllers/Admin/
app/Http/Middleware/       → app/Http/Middleware/
bootstrap/app.php          → bootstrap/app.php   (overwrite)
config/database.php        → config/database.php (overwrite)
config/auth.php            → config/auth.php     (overwrite)
database/migrations/       → database/migrations/ (add the one new file)
database/seeders/          → database/seeders/    (overwrite both)
resources/views/admin/     → resources/views/admin/
routes/web.php             → routes/web.php      (overwrite)
routes/console.php         → routes/console.php  (overwrite)
composer.json               — reference only, see note below
.env.example                → merge into your .env
```

**About `composer.json`:** don't overwrite the one `laravel new` generates
— it already has the right lockfile-matched versions. The one in this
delivery is there so you can see exactly what's required (Laravel 13,
`laravel/tinker`) in case you want to diff it.

## 3. Configure your `.env`

Copy the `DB_*` block from `.env.example` into your real `.env`, then fill
in your actual Supabase values from **Supabase → Settings → Database**:

- `DB_HOST` / `DB_PORT` — use the **pooler** host on port `6543` for normal
  app traffic (`DB_POOLED=true`), or the **direct** host on port `5432` for
  the one-off migration below.
- `DB_USERNAME` — looks like `postgres.your-project-ref`
- `DB_PASSWORD` — your database password (not the anon/service-role API key)

```bash
php artisan key:generate
```

## 4. Create the admin_users table

This is the **only** schema change this project makes — one new table in the
Supabase `"Admin"` schema for dashboard logins, unrelated to Supabase Auth or
`public.users`. Run it against the **direct** connection, not the pooler
(DDL and transaction poolers don't mix well):

```bash
php artisan migrate --database=pgsql_admin::direct
```

## 5. Create your login

```bash
# in .env, temporarily:
ADMIN_SEED_EMAIL=you@example.com
ADMIN_SEED_PASSWORD=choose-a-real-password
ADMIN_SEED_NAME=Spencer

php artisan db:seed --class=Database\\Seeders\\AdminSeeder
```

Feel free to remove those three `ADMIN_SEED_*` lines from `.env` afterward
— the seeder only reads them at run time.

## 6. Run it

```bash
php artisan serve
```

Visit `http://localhost:8000/admin` and sign in.

## Design notes / things I deliberately did or didn't do

- **`TravelUser` (public.users) hides `phone`, `gcash_number`,
  `health_notes`, `blood_type`.** These are AES-encrypted app-side; this
  dashboard has no way to decrypt them and shouldn't display the raw
  ciphertext even if it could.
- **No ban/suspend action on users.** The real schema has no status column
  for it — I didn't want to invent one and silently alter your live
  traveler table. If you want that, it's a small additive migration
  (`is_suspended`, `suspended_reason`) and I'm happy to build it.
- **Expense approve/reject leaves `approved_by`/`rejected_by` null** when
  done from the dashboard. Those columns are foreign keys into
  `public.users` (a trip's treasurer/organizer) — an admin's id lives in a
  different table and isn't a valid value there.
- **Approving an expense doesn't need to call the push-notification
  logic itself** — your `expense-approved` Edge Function is already wired
  to a database webhook on that column, so updating the row is enough.
- **Tailwind and Alpine load from CDN**, no npm build step. For an
  internal tool this keeps it to zero moving parts; say the word if you'd
  rather have a compiled Vite/Tailwind pipeline instead.
- **Sessions, cache, and queue default to file/sync**, not database — so
  this project's own bookkeeping doesn't add tables to the Supabase
  database beyond `admin_users`.

## If something doesn't line up

Supabase occasionally changes small things about pooler behavior, and I
built this against the schema in your `supabase/migrations/*.sql` files as
of today — if you've since applied a migration I haven't seen, a model's
`$fillable` list is the most likely thing to need a one-line update.
