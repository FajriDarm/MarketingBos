# 📋 Dokumentasi Database Affiliate System

## 📊 Struktur Database Marketing_DB

Sistem affiliate ini memiliki struktur database yang komprehensif dengan 17 tabel utama untuk mengelola:
- User Management dengan 4 Role berbeda
- Produk dan Affiliate Links
- Transaksi Pelanggan
- Sistem Komisi dengan 3 Stage Approval
- Manajemen Penarikan Dana
- Audit dan Notifikasi

---

## 🗂️ Daftar Tabel dan Relasi

### 1️⃣ **Users & Roles System**

#### Tabel: `users`
Field utama untuk affiliate system:
- `role_id` - FK ke table roles
- `sales_id` - FK ke table users (self-referencing untuk sales-affiliate relationship)
- `status` - enum: active, inactive, suspended
- `commission_rate` - Persentase komisi affiliate (decimal 5,2)
- `total_commission` - Total komisi yang sudah diperoleh
- `total_withdrawn` - Total komisi yang sudah ditarik
- `bank_name`, `bank_account`, `bank_account_name` - Info rekening untuk penarikan

**Relasi:**
```
User has one Role
User has many AffiliateLinks (affiliate_id)
User has many Commissions (affiliate_id)
User has many WithdrawRequests (affiliate_id)
User has many approvedCommissions (approved_by)
User belongsTo User as Sales (sales_id)
User has many Affiliates (sales_id) - inverse
```

#### Tabel: `roles`
```
id, name (unique), display_name, description
```
- Super Admin
- Sales
- Affiliate
- Finance

#### Tabel: `permissions`
```
id, name (unique), guard_name
```

#### Tabel: `role_has_permissions`
Pivot table untuk relasi many-to-many antara roles dan permissions.

#### Tabel: `model_has_roles`
Pivot table untuk mengelola role pada model (fleksibel).

---

### 2️⃣ **Products & Affiliate Marketing**

#### Tabel: `products`
```
id, name, description, price, image_url, status (active/inactive), created_by (FK), timestamps
```

**Relasi:**
```
Product belongsTo User (created_by)
Product has many AffiliateLinks
Product has many Transactions
```

#### Tabel: `affiliate_links`
Setiap affiliate mendapat unique code untuk setiap produk.
```
id, affiliate_id (FK), product_id (FK), unique_code (unique), 
short_url, total_clicks, total_conversions, timestamps
```

**Relasi:**
```
AffiliateLink belongsTo User (affiliate_id)
AffiliateLink belongsTo Product (product_id)
```

---

### 3️⃣ **Customers & Transactions**

#### Tabel: `customers`
```
id, name, email (unique), phone, address, timestamps
```

#### Tabel: `transactions`
Status flow: pending → dp_paid → shipped → completed
```
id, transaction_code (unique), customer_id (FK), affiliate_id (FK nullable),
product_id (FK), sales_id (FK nullable), total_amount, dp_amount,
dp_paid_at, dp_proof_url, status, shipping_proof_url, shipped_at,
completed_at, notes, timestamps
```

**Relasi:**
```
Transaction belongsTo Customer
Transaction belongsTo User (affiliate_id)
Transaction belongsTo User (sales_id)
Transaction belongsTo Product
Transaction has many ChatHistories
Transaction has many Commissions
```

#### Tabel: `chat_histories`
Tracking chat antara customer dan sales.
```
id, transaction_id (FK), customer_id (FK), sales_id (FK nullable),
message (text), sender_type (enum: customer/sales/system),
is_order_intent (boolean - flag untuk detect order intent),
read_at (nullable), timestamps
```

**Relasi:**
```
ChatHistory belongsTo Transaction
ChatHistory belongsTo Customer
ChatHistory belongsTo User (sales_id)
```

---

### 4️⃣ **Commission Management System**

#### Tabel: `commission_stages`
Konfigurasi 3 tahap pemberian komisi.
```
id, stage_number (1-3), name, description,
commission_percentage (persentase dari total),
min_amount (nullable), max_amount (nullable),
is_active (boolean), created_by (FK), timestamps
```

**Data Default:**
- Stage 1: Chat Intent (5%)
- Stage 2: DP Paid (10%)
- Stage 3: Product Shipped (15%)

#### Tabel: `commissions`
Detail komisi per transaksi.
```
id, transaction_id (FK), affiliate_id (FK), stage_id (FK),
amount (decimal 12,2), status (enum: pending/approved/rejected/ready_for_withdraw/paid),
approved_by (FK nullable - sales yang approve), approved_at (nullable),
rejected_by (FK nullable), rejected_at (nullable),
rejection_reason (text nullable), notes (text nullable),
payout_date (date nullable - tanggal payout bulan ini), timestamps
```

**Status Flow:**
```
pending → approved → ready_for_withdraw → paid
              ↓
           rejected
```

**Relasi:**
```
Commission belongsTo Transaction
Commission belongsTo User (affiliate_id)
Commission belongsTo CommissionStage (stage_id)
Commission belongsTo User (approved_by)
Commission belongsTo User (rejected_by)
Commission has many CommissionLogs
```

#### Tabel: `commission_logs`
History perubahan status komisi untuk audit.
```
id, commission_id (FK), old_status, new_status,
changed_by (FK - User yang ubah), notes (text nullable), timestamps
```

---

### 5️⃣ **Withdrawal & Payment System**

#### Tabel: `withdraw_requests`
Permintaan penarikan komisi oleh affiliate.
```
id, code (unique), affiliate_id (FK), amount (decimal 12,2),
status (enum: pending/processing/completed/rejected),
payment_method (enum: bank_transfer/ewallet/cash),
finance_id (FK nullable - finance yang proses),
processed_at (nullable), completed_at (nullable),
rejection_reason (text nullable), notes (text nullable), timestamps
```

**Relasi:**
```
WithdrawRequest belongsTo User (affiliate_id)
WithdrawRequest belongsTo User (finance_id)
WithdrawRequest has many WithdrawItems
```

#### Tabel: `withdraw_items`
Detail item komisi yang ada di withdraw request.
```
id, withdraw_request_id (FK), commission_id (FK),
amount (decimal 12,2), timestamps
```

**Relasi:**
```
WithdrawItem belongsTo WithdrawRequest
WithdrawItem belongsTo Commission
```

#### Tabel: `payout_batches`
Batch pembayaran akhir bulan (untuk proses batch payment).
```
id, batch_code (unique), month (tinyint), year (year),
total_amount (decimal 12,2), total_affiliates (int),
status (enum: draft/processing/completed/cancelled),
finance_id (FK), processed_at (nullable), completed_at (nullable),
notes (text nullable), timestamps
```

**Relasi:**
```
PayoutBatch belongsTo User (finance_id)
PayoutBatch has many PayoutBatchItems
```

#### Tabel: `payout_batch_items`
Item detail dalam batch pembayaran.
```
id, payout_batch_id (FK), withdraw_request_id (FK),
amount (decimal 12,2), timestamps
```

**Relasi:**
```
PayoutBatchItem belongsTo PayoutBatch
PayoutBatchItem belongsTo WithdrawRequest
```

---

### 6️⃣ **Audit & Notifications**

#### Tabel: `audit_logs`
Logging semua aktivitas untuk audit trail.
```
id, user_id (FK nullable), action (varchar 100),
model_type (varchar 255 nullable), model_id (bigint nullable),
old_values (json nullable), new_values (json nullable),
ip_address (varchar 45 nullable), user_agent (text nullable), timestamps
```

**Relasi:**
```
AuditLog belongsTo User (nullable)
```

#### Tabel: `notifications`
Notifikasi untuk user (commission approved, withdrawal completed, dll).
```
id, user_id (FK), type (varchar 100), title (varchar 255),
message (text), data (json nullable),
read_at (timestamp nullable), timestamps
```

**Relasi:**
```
Notification belongsTo User
```

---

## 🔗 Relationship Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                        USERS (dengan 4 role)               │
│  (super_admin, sales, affiliate, finance)                  │
└─────────────────────────────────────────────────────────────┘
              │
              ├─ ROLES ── PERMISSIONS ─┐
              │         (many-to-many)  │
              │                         └─ ROLE_HAS_PERMISSIONS
              │
              ├─ AFFILIATE_LINKS (affiliate creates)
              │        ├─ PRODUCTS
              │        └─ TRANSACTIONS (via product)
              │
              ├─ TRANSACTIONS (as affiliate_id, sales_id)
              │        ├─ CUSTOMERS
              │        ├─ PRODUCTS
              │        ├─ CHAT_HISTORIES (sales manage chat)
              │        └─ COMMISSIONS (generate per stage)
              │
              ├─ COMMISSIONS (affiliate receives)
              │        ├─ COMMISSION_STAGES (3 stages)
              │        └─ COMMISSION_LOGS (history)
              │
              ├─ WITHDRAW_REQUESTS (affiliate request)
              │        └─ WITHDRAW_ITEMS (items in request)
              │             └─ COMMISSIONS (source)
              │
              ├─ PAYOUT_BATCHES (finance manage)
              │        └─ PAYOUT_BATCH_ITEMS
              │             └─ WITHDRAW_REQUESTS
              │
              ├─ AUDIT_LOGS (track changes)
              │
              └─ NOTIFICATIONS (receive updates)
```

---

## 📐 Query Patterns

### Dashboard Affiliate - Total Komisi Pending per Stage:
```sql
SELECT 
    cs.stage_number,
    cs.name as stage_name,
    COUNT(c.id) as total_pending,
    SUM(c.amount) as total_amount
FROM commissions c
JOIN commission_stages cs ON c.stage_id = cs.id
WHERE c.affiliate_id = :affiliate_id 
AND c.status = 'pending'
GROUP BY cs.stage_number, cs.name;
```

### Dashboard Sales - Komisi Pending untuk di-Approve:
```sql
SELECT 
    c.id,
    t.transaction_code,
    cus.name as customer_name,
    cs.stage_number,
    cs.name as stage_name,
    c.amount,
    u.name as affiliate_name
FROM commissions c
JOIN transactions t ON c.transaction_id = t.id
JOIN customers cus ON t.customer_id = cus.id
JOIN commission_stages cs ON c.stage_id = cs.id
JOIN users u ON c.affiliate_id = u.id
WHERE c.status = 'pending'
ORDER BY c.created_at DESC;
```

### Dashboard Finance - Withdraw Requests Ready:
```sql
SELECT 
    wr.code,
    u.name as affiliate_name,
    u.email,
    wr.amount,
    wr.payment_method,
    wr.status
FROM withdraw_requests wr
JOIN users u ON wr.affiliate_id = u.id
WHERE wr.status IN ('pending', 'processing')
ORDER BY wr.created_at DESC;
```

---

## 🎯 Workflow Proses Komisi

```
1. AFFILIATE CREATES TRANSACTION
   Affiliate shares affiliate_link → Customer clicks → Transaction created
   
2. STAGE 1: CHAT INTENT
   Customer chat with sales → Sales mark order intent flag
   → Commission stage 1 created (5%) with status 'pending'

3. STAGE 2: DP PAID
   Customer uploads DP proof → Sales verifies & updates status
   → Commission stage 2 created (10%) with status 'pending'

4. STAGE 3: PRODUCT SHIPPED
   Sales uploads shipping proof → Updates transaction status
   → Commission stage 3 created (15%) with status 'pending'

5. SALES APPROVAL
   Sales reviews all commissions → Clicks approve
   → Status changes: pending → approved → ready_for_withdraw

6. AFFILIATE WITHDRAWAL
   Affiliate requests withdraw → System groups ready_for_withdraw commissions
   → Creates withdraw_request with withdraw_items

7. FINANCE PROCESSING
   Finance processes withdraw requests → Creates payout_batch
   → Updates withdraw_request status → ready_for_withdraw → paid

8. FINAL: PAYMENT COMPLETE
   Affiliate receives payment → Status: paid
   → History tracked in commission_logs, audit_logs, notifications
```

---

## 🗄️ Database Indexes (Performance)

```sql
CREATE INDEX idx_users_role_id ON users(role_id);
CREATE INDEX idx_users_sales_id ON users(sales_id);
CREATE INDEX idx_transactions_affiliate_id ON transactions(affiliate_id);
CREATE INDEX idx_transactions_sales_id ON transactions(sales_id);
CREATE INDEX idx_transactions_status ON transactions(status);
CREATE INDEX idx_commissions_affiliate_status ON commissions(affiliate_id, status);
CREATE INDEX idx_commissions_status ON commissions(status);
CREATE INDEX idx_commissions_transaction_id ON commissions(transaction_id);
CREATE INDEX idx_withdraw_requests_affiliate_status ON withdraw_requests(affiliate_id, status);
CREATE INDEX idx_chat_histories_transaction_id ON chat_histories(transaction_id);
CREATE INDEX idx_chat_histories_is_order_intent ON chat_histories(is_order_intent);
CREATE INDEX idx_affiliate_links_unique_code ON affiliate_links(unique_code);
```

---

## ✅ Setup Checklist

- ✅ Database `marketing_db` dibuat
- ✅ 17 migration tables berhasil dijalankan
- ✅ Data awal (roles, admin user, commission stages) sudah di-seed
- ✅ Semua Models sudah dibuat dengan relasi yang tepat
- ✅ Indexes sudah terdefinisi untuk performa
- ✅ Siap untuk development Controller, Repository, Service, dan API

---

## 🚀 Next Steps

1. **Buat Controllers:**
   - AffiliateController
   - SalesController
   - FinanceController
   - AdminController

2. **Buat Services/Repository:**
   - CommissionService
   - WithdrawService
   - TransactionService

3. **Buat API Routes:**
   - RESTful endpoints untuk setiap role

4. **Buat Middleware:**
   - RoleMiddleware untuk authorization

5. **Implementasi Events & Listeners:**
   - Untuk generate komisi otomatis
   - Untuk notifikasi

---

Generated: 2024-01-22
Database: marketing_db
Status: ✅ READY FOR DEVELOPMENT
