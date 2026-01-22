# 🎯 AFFILIATE SYSTEM - DATABASE MIGRATION COMPLETED

## ✅ Status: SELESAI - Database siap untuk development!

Tanggal: **22 Januari 2026**  
Database: **marketing_db** (MySQL)  
Total Tabel: **17 tabel utama**  
Models: **13 models** dengan relasi lengkap  
Seeders: Data awal sudah ter-populate

---

## 📋 Quick Information

### Database Connection
```
Host: 127.0.0.1
Port: 3306
Database: marketing_db
Username: root
Password: (empty)
Driver: MySQL
```

### Default Admin Account
```
Email: admin@affiliate.com
Password: password
Role: Super Admin
```

### 4 Roles Available
```
1. Super Admin    - Akses penuh ke sistem
2. Sales          - Mengelola transaksi & approval komisi
3. Affiliate      - Rekomendasi produk & lihat komisi
4. Finance        - Proses withdraw & pembayaran
```

### 3 Commission Stages
```
Stage 1: Chat Intent (5% komisi)      - Order intent confirmed
Stage 2: DP Paid (10% komisi)         - DP sudah masuk
Stage 3: Product Shipped (15% komisi) - Produk dikirim
Total: 30% dari harga transaksi
```

---

## 📊 17 Tabel Database

| # | Tabel | Fungsi |
|---|-------|--------|
| 1 | `users` | User dengan extended fields untuk affiliate |
| 2 | `roles` | Role system (4 role) |
| 3 | `permissions` | Permission management |
| 4 | `role_has_permissions` | Pivot: role-permissions |
| 5 | `model_has_roles` | Pivot: model-roles |
| 6 | `products` | Master produk |
| 7 | `affiliate_links` | Unique link per affiliate-product |
| 8 | `customers` | Data pembeli |
| 9 | `transactions` | Pesanan/transaksi |
| 10 | `chat_histories` | Chat customer-sales |
| 11 | `commission_stages` | Konfigurasi 3 tahap komisi |
| 12 | `commissions` | Detail komisi per transaksi-stage |
| 13 | `commission_logs` | History komisi (audit) |
| 14 | `withdraw_requests` | Permintaan penarikan komisi |
| 15 | `withdraw_items` | Items dalam withdraw request |
| 16 | `payout_batches` | Batch pembayaran akhir bulan |
| 17 | `payout_batch_items` | Items dalam batch pembayaran |
| 18 | `audit_logs` | Audit trail semua aktivitas |
| 19 | `notifications` | Notifikasi user |

---

## 📁 File yang Dibuat/Dimodifikasi

### Migration Files (17 files)
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php (modified)
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2024_01_01_000001_create_roles_table.php
├── 2024_01_01_000002_alter_users_table_for_affiliate.php
├── 2024_01_01_000003_create_permissions_tables.php
├── 2024_01_01_000004_create_products_table.php
├── 2024_01_01_000005_create_customers_table.php
├── 2024_01_01_000006_create_affiliate_links_table.php
├── 2024_01_01_000007_create_transactions_table.php
├── 2024_01_01_000008_create_chat_histories_table.php
├── 2024_01_01_000009_create_commission_stages_table.php
├── 2024_01_01_000010_create_commissions_table.php
├── 2024_01_01_000011_create_commission_logs_table.php
├── 2024_01_01_000012_create_withdraw_requests_table.php
├── 2024_01_01_000013_create_withdraw_items_table.php
├── 2024_01_01_000014_create_payout_batches_table.php
├── 2024_01_01_000015_create_payout_batch_items_table.php
├── 2024_01_01_000016_create_audit_logs_table.php
└── 2024_01_01_000017_create_notifications_table.php
```

### Model Files (13 models created)
```
app/Models/
├── User.php (updated)
├── Role.php (new)
├── Permission.php (new)
├── Product.php (updated)
├── AffiliateLink.php (new)
├── Customer.php (updated)
├── Transaction.php (updated)
├── Commission.php (new)
├── CommissionLog.php (new)
├── ChatHistory.php (new)
├── WithdrawRequest.php (new)
├── WithdrawItem.php (new)
├── PayoutBatch.php (new)
├── PayoutBatchItem.php (new)
├── AuditLog.php (new)
└── Notification.php (new)
```

### Seeder
```
database/seeders/DatabaseSeeder.php (updated)
```

### Documentation
```
root/
├── MIGRATION_SUMMARY.md (informasi ringkas)
└── DATABASE_DOCUMENTATION.md (dokumentasi lengkap)
```

---

## 🔗 Model Relationships

```
User
  ├── Role (has one)
  ├── AffiliateLinks (has many)
  ├── Commissions (has many as affiliate_id)
  ├── ApprovedCommissions (has many as approved_by)
  ├── WithdrawRequests (has many)
  ├── ChatHistories (has many as sales_id)
  └── Affiliates (has many, self-referencing as sales_id)

Transaction
  ├── Customer (belongs to)
  ├── Affiliate (belongs to as user)
  ├── Sales (belongs to as user)
  ├── Product (belongs to)
  ├── ChatHistories (has many)
  └── Commissions (has many)

Commission
  ├── Transaction (belongs to)
  ├── Affiliate (belongs to as user)
  ├── Stage (belongs to)
  ├── ApprovedBy (belongs to as user)
  ├── RejectedBy (belongs to as user)
  └── Logs (has many)
```

---

## 🔄 Commission Workflow

```
AFFILIATE CREATES LINK
        ↓
CUSTOMER CLICKS & MAKES TRANSACTION
        ↓
STAGE 1: Chat Intent (5%)
   ├─ Customer chat intent confirmed
   └─ Commission created: pending
        ↓
STAGE 2: DP Paid (10%)
   ├─ DP payment received
   └─ Commission created: pending
        ↓
STAGE 3: Product Shipped (15%)
   ├─ Product shipped
   └─ Commission created: pending
        ↓
SALES APPROVAL
   ├─ Review all 3 stages
   └─ Status: pending → approved → ready_for_withdraw
        ↓
AFFILIATE REQUESTS WITHDRAWAL
   ├─ Create withdraw request
   └─ Group commissions: ready_for_withdraw
        ↓
FINANCE PROCESS
   ├─ Create payout batch (monthly)
   ├─ Update withdraw: completed
   └─ Status: ready_for_withdraw → paid
        ↓
PAYMENT COMPLETE ✓
   └─ Affiliate receives money
```

---

## 🎯 Fitur Utama yang Sudah Ready

✅ Multi-role user system (4 roles)  
✅ Affiliate link tracking (unique codes)  
✅ 3-stage commission system  
✅ Commission approval workflow  
✅ Withdrawal request management  
✅ Monthly payout batches  
✅ Chat history tracking  
✅ Commission logs & audit trails  
✅ Comprehensive relationships  
✅ Data validation via casts & fillable  
✅ Query scopes untuk filtering  

---

## 🚀 Langkah Selanjutnya

1. **Buat Controllers** untuk setiap role:
   ```bash
   php artisan make:controller AffiliateController
   php artisan make:controller SalesController
   php artisan make:controller FinanceController
   php artisan make:controller AdminController
   ```

2. **Buat API Routes** di `routes/api.php`

3. **Buat Services** untuk business logic:
   - CommissionService
   - WithdrawService
   - TransactionService

4. **Buat Middleware** untuk authorization:
   ```bash
   php artisan make:middleware RoleMiddleware
   ```

5. **Implement Events & Listeners** untuk automasi

6. **Setup Authentication** (Sanctum/Passport untuk API)

---

## 🧪 Testing Database

### Cek tabel users
```bash
php artisan tinker
>>> App\Models\User::all();
```

### Cek roles
```bash
>>> App\Models\Role::all();
```

### Cek commission stages
```bash
>>> App\Models\CommissionStage::all();
```

### Membuat affiliate baru
```bash
>>> $role = App\Models\Role::where('name', 'affiliate')->first();
>>> App\Models\User::create([
    'name' => 'Afiliasi 1',
    'email' => 'afiliasi1@test.com',
    'password' => Hash::make('password'),
    'role_id' => $role->id,
    'status' => 'active',
    'commission_rate' => 30.00
]);
```

---

## 📞 Database Info

**Generated on:** 22 January 2026  
**Database Version:** marketing_db  
**Laravel Version:** 11+  
**PHP Version:** 8.2+  

**Total Migrations:** 20 (including default Laravel)  
**All Status:** ✅ Ran  

---

## 💾 Backup Database

```bash
# Dump database untuk backup
mysqldump -u root marketing_db > backup_marketing_db.sql

# Restore dari backup
mysql -u root marketing_db < backup_marketing_db.sql
```

---

**Database Migration Status: ✅ COMPLETE & READY FOR DEVELOPMENT**

Untuk dokumentasi lebih lengkap, lihat: [DATABASE_DOCUMENTATION.md](DATABASE_DOCUMENTATION.md)
