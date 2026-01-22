# Quick Start Guide - Affillink Authentication System

## 🚀 Setup Instructions

### Step 1: Verify Installations
```bash
# Check if JWT package is installed
composer show tymon/jwt-auth

# Expected output: tymon/jwt-auth v2.2.1
```

### Step 2: Clear Cache
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Step 3: Verify Database
```bash
# Check database connection
php artisan tinker
> DB::connection()->getPDO()
# Should not throw error
```

### Step 4: Create Admin Test User (if needed)
```bash
php artisan tinker
> $user = App\Models\User::where('email', 'admin@affiliate.com')->first();
> if (!$user) {
    $role = App\Models\Role::where('name', 'super_admin')->first();
    App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@affiliate.com',
        'password' => bcrypt('password'),
        'role_id' => $role->id,
        'status' => 'active',
        'email_verified_at' => now(),
    ]);
  }
```

---

## 📱 Testing the Authentication System

### Test 1: Access Login Page
```
URL: http://localhost:8000/login
Expected: Login form with email and password fields
Status: 200
```

### Test 2: Access Register Page
```
URL: http://localhost:8000/register
Expected: Register form with name, email, password fields
Status: 200
```

### Test 3: Test Login API
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@affiliate.com",
    "password": "password"
  }'

Expected Response:
{
  "message": "Login berhasil",
  "token": "eyJhbGc...",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@affiliate.com",
    "role": "super_admin"
  }
}
```

### Test 4: Test Register API
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

Expected Response: Status 201
{
  "message": "Pendaftaran berhasil! Selamat datang di Affillink",
  "token": "eyJhbGc...",
  "user": {
    "id": 2,
    "name": "New User",
    "email": "newuser@example.com",
    "role": "affiliate"
  }
}
```

### Test 5: Test Protected Route (Get User Info)
```bash
# Use token from login/register response
curl -X GET http://localhost:8000/api/me \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"

Expected Response:
{
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@affiliate.com",
    "role": "super_admin",
    "commission_rate": 0
  }
}
```

### Test 6: Test Dashboard (Protected Route)
```
URL: http://localhost:8000/dashboard
Required: Valid JWT Token in localStorage
- Open browser developer console (F12)
- Navigate to Application > Local Storage
- Verify 'token' and 'user' are present
- Should see dashboard with user info

If not logged in: Should redirect to /login
```

### Test 7: Test Logout
```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"

Expected Response:
{
  "message": "Logout berhasil"
}
```

---

## 🎨 Frontend Testing Checklist

### Login Page
- [ ] Gradient background visible (Blue to Green)
- [ ] Email input field working
- [ ] Password input field working
- [ ] Password visibility toggle working
- [ ] Remember me checkbox functional
- [ ] Forgot password link present
- [ ] Login button clickable
- [ ] Sign up link works
- [ ] Form validation working
- [ ] Error messages display correctly
- [ ] Responsive on mobile

### Register Page
- [ ] Gradient background visible
- [ ] Name input field working
- [ ] Email input field working
- [ ] Password input field working
- [ ] Confirm password input working
- [ ] Password strength indicator visible
- [ ] Terms checkbox required
- [ ] Sign up button clickable
- [ ] Sign in link works
- [ ] Form validation working
- [ ] Error messages display correctly
- [ ] Responsive on mobile

### Dashboard
- [ ] User name displayed
- [ ] User email displayed
- [ ] User role displayed
- [ ] Commission rate displayed
- [ ] Statistics cards visible
- [ ] Account info table visible
- [ ] Logout button works
- [ ] Protected route checks work

---

## 🔍 Browser Developer Console Tests

### Test 1: Check Token Storage
```javascript
// Open browser console (F12)
// After login, run:
console.log(localStorage.getItem('token'));
console.log(JSON.parse(localStorage.getItem('user')));

// Expected output:
// eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
// {id: 1, name: "Admin", email: "admin@affiliate.com", role: "super_admin"}
```

### Test 2: Verify API Call
```javascript
// In browser console:
fetch('/api/me', {
  headers: {
    'Authorization': 'Bearer ' + localStorage.getItem('token')
  }
})
.then(r => r.json())
.then(d => console.log(d));

// Should return current user object
```

### Test 3: Test Login Process
```javascript
// Simulate login
fetch('/api/login', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value
  },
  body: JSON.stringify({
    email: 'admin@affiliate.com',
    password: 'password'
  })
})
.then(r => r.json())
.then(d => {
  console.log(d);
  if (d.token) {
    localStorage.setItem('token', d.token);
    localStorage.setItem('user', JSON.stringify(d.user));
  }
});
```

---

## ⚙️ Configuration Files

### `.env` Authentication Settings
```env
# JWT Configuration
JWT_ALGORITHM=HS256
JWT_SECRET=JqRcP486AreEsJSDVSMCkjV6PQKAPbzpScJ7QEIKjaz5YV9LzE0YA7PB1lMPSLmI
JWT_TTL=60                           # Token lifetime in minutes
JWT_REFRESH_TTL=20160                # Refresh token lifetime in minutes
JWT_BLACKLIST_ENABLED=true           # Enable token blacklist

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketing_db
DB_USERNAME=root
DB_PASSWORD=
```

### `config/auth.php` Guard Configuration
The default guard should be set to `api`:
```php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

---

## 🐛 Troubleshooting

### Issue: "No route matches" for login/register
**Solution:**
```bash
php artisan route:clear
php artisan route:cache
php artisan cache:clear
```

### Issue: JWT token invalid or expired
**Solution:**
```bash
# Regenerate JWT secret
php artisan jwt:secret

# Update .env and restart server
php artisan serve
```

### Issue: CSRF token mismatch
**Solution:**
- Add `@csrf` directive in forms (already done)
- Pass X-CSRF-TOKEN header in fetch requests (already done)

### Issue: 401 Unauthorized on protected routes
**Solution:**
- Verify token is valid: `curl -X GET http://localhost:8000/api/me -H "Authorization: Bearer YOUR_TOKEN"`
- Check if token is stored in localStorage
- Clear localStorage and re-login

### Issue: 422 Validation error
**Solution:**
- Check error message in response
- Verify input data matches validation rules
- Email must be unique for registration
- Password must be 8+ characters

### Issue: User can access login while already logged in
**Solution:**
- Add `@if(!auth()->check())` to blade template
- Or update AuthController to redirect logged-in users

### Issue: Dashboard shows no user data
**Solution:**
- Check if token is valid
- Verify user data is stored in localStorage
- Check browser console for fetch errors

---

## 📊 Database Structure

### users table
```sql
- id (PK)
- name (string)
- email (unique)
- email_verified_at (timestamp, nullable)
- password (string)
- phone (string, nullable)
- bank_name (string, nullable)
- bank_account (string, nullable)
- bank_account_name (string, nullable)
- role_id (FK → roles.id)
- sales_id (FK → users.id, nullable)
- status (enum: active, inactive)
- commission_rate (decimal)
- total_commission (decimal, default: 0)
- total_withdrawn (decimal, default: 0)
- last_withdraw_date (timestamp, nullable)
- created_at, updated_at (timestamps)
```

### roles table
```sql
- id (PK)
- name (unique: super_admin, sales, affiliate, finance)
- description (text, nullable)
- created_at, updated_at
```

---

## 🎯 URL Endpoints Summary

| Method | URL | Auth | Purpose |
|--------|-----|------|---------|
| GET | `/` | - | Welcome page |
| GET | `/login` | guest | Login form |
| GET | `/register` | guest | Register form |
| POST | `/api/login` | guest | Login (returns JWT) |
| POST | `/api/register` | guest | Register (returns JWT) |
| GET | `/api/me` | required | Get current user |
| POST | `/api/refresh` | required | Refresh JWT token |
| POST | `/api/logout` | required | Logout (invalidate token) |
| GET | `/dashboard` | required | Dashboard |

---

## 💾 File Locations

```
app/Http/Controllers/Auth/AuthController.php    # Controller
app/Models/User.php                              # User model
resources/views/auth/login.blade.php             # Login view
resources/views/auth/register.blade.php          # Register view
resources/views/dashboard.blade.php              # Dashboard
routes/web.php                                   # Web routes
routes/api.php                                   # API routes
.env                                             # Configuration
AUTH_SYSTEM_DOCUMENTATION.md                     # Full docs
QUICK_START_GUIDE.md                             # This file
```

---

## ✅ Success Criteria

Your authentication system is working correctly when:

1. ✅ Can visit `/login` and `/register` without login
2. ✅ Can fill and submit login form
3. ✅ Can fill and submit register form
4. ✅ JWT token is generated and stored in localStorage
5. ✅ Can access `/dashboard` after login
6. ✅ Dashboard displays user information
7. ✅ Can logout and are redirected to login
8. ✅ Cannot access protected routes without login
9. ✅ All error messages display correctly
10. ✅ UI is responsive on mobile/tablet/desktop

---

## 🚢 Production Checklist

Before deploying to production:

- [ ] Update JWT_SECRET with strong random value
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update `APP_URL` to production domain
- [ ] Configure proper database credentials
- [ ] Set up HTTPS/SSL certificate
- [ ] Configure CORS for production domain
- [ ] Enable rate limiting on auth endpoints
- [ ] Set up proper logging and monitoring
- [ ] Backup database before deployment
- [ ] Test all authentication flows
- [ ] Configure email notifications
- [ ] Set up JWT token refresh strategy
- [ ] Implement 2FA for admin accounts

---

## 📞 Support

For issues or questions, refer to:
- AUTH_SYSTEM_DOCUMENTATION.md
- Laravel documentation: https://laravel.com
- JWT Auth documentation: https://jwt-auth.readthedocs.io
- Tailwind CSS docs: https://tailwindcss.com
