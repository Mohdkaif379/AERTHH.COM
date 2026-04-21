# Vendor Returned Orders Task (same as cancel-orders)

**Current:** Controller exists but uses deprecated `session('vendor')` (fix to Auth), no route/view.

## Plan:
**Information Gathered:** Controller fetches `status = 'returned'`, expects view `vendor.returned-orders.index`. Typo in folder `ReurnedOrder` (should be ReturnedOrder?). No route/view found.

**Files to Edit:**
1. Fix controller: Use `Auth::guard('vendor')->id()`, add relations, paginate.
2. Add route in `routes/web.php`.
3. Create `resources/views/vendor/returned-orders/index.blade.php` (copy from cancel-orders, adapt for returned).

**Dependent:** None.

**Followup:** Test route after `php artisan route:clear`.

Returned Orders feature complete (matching cancel-orders):
- Controller fixed (Auth guard, formatted).
- Route added: vendor/returned-orders.
- View created w/ filters, dynamic reasons, JS table (yellow theme).

Test /vendor/returned-orders.

