# Authentication System Documentation - Affillink

## Overview
Complete JWT-based authentication system with modern, responsive UI for Affillink affiliate platform. Includes Login, Register, and Dashboard pages with Tailwind CSS styling.

## Features

### 1. **Modern & Responsive UI**
- Gradient background (Dark Blue #1E3A5F → Green #4CAF50)
- Glass-effect cards with blur backdrop filter
- Mobile-first responsive design
- Smooth transitions and hover effects
- Professional Poppins font family
- Accessible form inputs with icons

### 2. **JWT Authentication**
- Token-based authentication using `tymon/jwt-auth` package
- Automatic token generation on login/register
- Token refresh capability
- Secure password hashing with Laravel's Hash facade
- Token storage in localStorage (frontend)

### 3. **Form Validation**
- Email format and uniqueness validation
- Password strength requirements (min 8 characters)
- Password confirmation on registration
- Real-time error display
- Indonesian error messages
- Password strength indicator on register form

### 4. **Security Features**
- User status validation (only active users can login)
- Automatic affiliate role assignment on registration
- Guest middleware prevents authenticated users from accessing auth pages
- Protected routes with `auth:api` middleware
- CSRF token validation

### 5. **Interactive Features**
- Password visibility toggle (eye icon)
- Remember me checkbox
- Form submission via fetch API
- Auto-login after registration
- Redirect to dashboard on successful authentication
- Auto-redirect to login if session expires

---

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       └── Auth/
│           └── AuthController.php          # Authentication controller
└── Models/
    ├── User.php                             # User model with affiliate fields
    ├── Role.php                             # Role model
    └── ...                                  # Other models

routes/
├── web.php                                  # Web routes (views)
└── api.php                                  # API routes (JSON endpoints)

resources/
└── views/
    ├── auth/
    │   ├── login.blade.php                 # Login form
    │   └── register.blade.php              # Register form
    └── dashboard.blade.php                 # Dashboard (protected)

config/
└── auth.php                                 # Authentication configuration
```

---

## Installation & Setup

### 1. Install JWT Package
```bash
composer require tymon/jwt-auth
```

### 2. Generate JWT Secret
```bash
php artisan jwt:secret
```

### 3. Update Environment Variables
```env
JWT_ALGORITHM=HS256
JWT_SECRET=JqRcP486AreEsJSDVSMCkjV6PQKAPbzpScJ7QEIKjaz5YV9LzE0YA7PB1lMPSLmI
```

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Seed Initial Data
```bash
php artisan db:seed
```

---

## API Endpoints

### Public Endpoints

#### 1. **Login**
- **Route:** `POST /api/login`
- **Headers:** 
  - `Content-Type: application/json`
  - `X-CSRF-TOKEN: {csrf_token}`
- **Body:**
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- **Response (200):**
  ```json
  {
    "message": "Login berhasil",
    "token": "eyJhbGc...",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "affiliate"
    }
  }
  ```

#### 2. **Register**
- **Route:** `POST /api/register`
- **Headers:** 
  - `Content-Type: application/json`
  - `X-CSRF-TOKEN: {csrf_token}`
- **Body:**
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }
  ```
- **Response (201):**
  ```json
  {
    "message": "Pendaftaran berhasil! Selamat datang di Affillink",
    "token": "eyJhbGc...",
    "user": {
      "id": 2,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "affiliate"
    }
  }
  ```

### Protected Endpoints

#### 3. **Get Current User**
- **Route:** `GET /api/me`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**
  ```json
  {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "role": "affiliate",
      "commission_rate": 15
    }
  }
  ```

#### 4. **Refresh Token**
- **Route:** `POST /api/refresh`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**
  ```json
  {
    "message": "Token refreshed successfully",
    "token": "eyJhbGc..."
  }
  ```

#### 5. **Logout**
- **Route:** `POST /api/logout`
- **Headers:** `Authorization: Bearer {token}`
- **Response (200):**
  ```json
  {
    "message": "Logout berhasil"
  }
  ```

---

## Web Routes

### Public Routes

```php
GET  /                  # Welcome page
GET  /login             # Login form (guest only)
GET  /register          # Register form (guest only)
```

### Protected Routes

```php
GET  /dashboard         # Dashboard (authenticated users only)
```

---

## AuthController Methods

### 1. `showLoginForm()`
- Returns login view template
- Accessible only by guest users

### 2. `showRegisterForm()`
- Returns register view template
- Accessible only by guest users

### 3. `login(Request $request)`
- Validates email and password
- Checks if user exists and status is active
- Generates JWT token
- Returns user data and token

### 4. `register(Request $request)`
- Validates name, email, password, and confirmation
- Creates new user with affiliate role
- Sets email as verified and status as active
- Auto-generates JWT token (auto-login)
- Returns user data and token

### 5. `logout()`
- Invalidates current JWT token
- Clears user session

### 6. `refresh()`
- Refreshes expired JWT token
- Returns new valid token

### 7. `me()`
- Returns current authenticated user data
- Includes role and commission information

---

## Frontend Implementation

### Login Form Features
```html
- Email input with email icon
- Password input with toggle visibility
- Remember me checkbox
- Forgot password link
- Submit button with gradient style
- Sign up link for new users
- Error message display
```

### Register Form Features
```html
- Full name input with user icon
- Email input with email icon
- Password input with strength indicator
- Confirm password input with toggle visibility
- Terms & Conditions checkbox
- Submit button with gradient style
- Sign in link for existing users
- Error message display
```

### Dashboard Features
```html
- User information display
- Navigation bar with user profile
- Statistics cards (Commission, Withdrawn, Links)
- Account information table
- Logout button with confirmation
- Auto-fetch user data from API
- Automatic redirect if session expires
```

---

## CSS Styling

### Design System

**Colors:**
- Primary Blue: `#1E3A5F` (Dark Blue / Biru Tua)
- Secondary Green: `#4CAF50` (Green / Hijau)
- Gradient: `135deg, #1E3A5F 0%, #4CAF50 100%`

**Typography:**
- Font Family: `Poppins, sans-serif`
- Primary Heading: `text-3xl font-bold`
- Secondary Heading: `text-lg font-bold`
- Body Text: `text-sm to text-base`

**Components:**
- Card: `glass-effect` with `backdrop-filter: blur(10px)`
- Input: Border-2 with focus state highlighting
- Button: Gradient background with hover transform effect
- Icons: SVG with color transitions

**Responsive Breakpoints:**
- Mobile: Default styles
- Tablet: `md:` prefix (768px)
- Desktop: `lg:` prefix (1024px)

---

## Error Handling

### Validation Errors
All errors are returned with 422 status code and include error messages:

```json
{
  "errors": {
    "email": ["Email atau password salah."],
    "password": ["Password minimal 8 karakter"]
  }
}
```

### Input Validation Rules

**Login:**
- Email: required, valid email format, must exist in database
- Password: required, minimum 8 characters

**Register:**
- Name: required, maximum 255 characters
- Email: required, valid email format, must be unique
- Password: required, minimum 8 characters, must be confirmed

### Error Messages (Indonesian)
- `Email harus diisi` - Email is required
- `Format email tidak valid` - Invalid email format
- `Email tidak terdaftar` - Email not registered
- `Email sudah terdaftar` - Email already registered
- `Password harus diisi` - Password is required
- `Password minimal 8 karakter` - Password minimum 8 characters
- `Password tidak sesuai` - Passwords do not match
- `Nama lengkap harus diisi` - Full name is required
- `Akun Anda sedang dinonaktifkan` - Your account is inactive

---

## Token Storage & Usage

### Frontend Token Management
```javascript
// Store token
localStorage.setItem('token', data.token);
localStorage.setItem('user', JSON.stringify(data.user));

// Use token in requests
const token = localStorage.getItem('token');
fetch('/api/me', {
    headers: {
        'Authorization': `Bearer ${token}`
    }
});

// Clear on logout
localStorage.removeItem('token');
localStorage.removeItem('user');
```

### Token Expiration
- Default expiration: 60 minutes
- Use `/api/refresh` to get new token before expiration
- Automatically refresh on each dashboard load

---

## Testing

### Login Test
1. Navigate to `/login`
2. Enter email: `admin@affiliate.com`
3. Enter password: `password`
4. Click "Log In"
5. Should redirect to `/dashboard`

### Register Test
1. Navigate to `/register`
2. Fill in all fields
3. Password must be minimum 8 characters
4. Click "Create Account"
5. Should auto-login and redirect to `/dashboard`

### Protected Routes Test
1. Try to access `/dashboard` without logging in
2. Should redirect to `/login`
3. After login, dashboard should be accessible

---

## Browser Support
- Chrome/Edge: Full support
- Firefox: Full support
- Safari: Full support
- Mobile browsers: Full support (responsive design)

---

## Performance Considerations
- CSS is inline for faster initial load
- Tailwind CSS is CDN-based (consider building for production)
- JWT tokens reduce server load (stateless)
- LocalStorage used for client-side token storage
- Fetch API used for efficient async operations

---

## Security Best Practices
1. Always use HTTPS in production
2. Store JWT in secure, httpOnly cookies (recommended for production)
3. Implement rate limiting on login/register endpoints
4. Use CSRF tokens on all POST requests
5. Validate all input on both client and server
6. Implement 2FA for sensitive accounts
7. Log all authentication attempts
8. Regular security audits

---

## Future Enhancements
- [ ] Email verification flow
- [ ] Password reset functionality
- [ ] Two-factor authentication (2FA)
- [ ] Social login (Google, GitHub)
- [ ] Remember device feature
- [ ] Session management dashboard
- [ ] Login activity log
- [ ] Account recovery options
- [ ] Biometric authentication
- [ ] Progressive Web App (PWA) support

---

## Dependencies
- Laravel 11+
- tymon/jwt-auth v2.2.1
- Tailwind CSS 3+
- PHP 8.2+
- MySQL 5.7+

---

## Support & Troubleshooting

### Issue: Token not found
**Solution:** Ensure JWT secret is set in `.env` file

### Issue: CORS errors
**Solution:** Configure CORS in `config/cors.php`

### Issue: Session expires too quickly
**Solution:** Adjust `JWT_TTL` in `.env` (in minutes)

### Issue: Password validation fails
**Solution:** Ensure password is at least 8 characters with confirmation match

### Issue: Can't access protected routes
**Solution:** Ensure token is properly set in Authorization header

---

## License
© 2024 Affillink. All rights reserved.
