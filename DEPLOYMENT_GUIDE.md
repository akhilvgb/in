# 🚀 Export Platform - Complete Deployment Guide

## Overview

This guide provides step-by-step instructions for deploying the Export Platform to any web hosting service. The platform is optimized for shared hosting environments and includes all necessary files and configurations.

---

## 📋 Pre-Deployment Requirements

### Hosting Requirements

- **PHP**: 8.3 or higher
- **MySQL**: 8.0 or higher
- **Storage**: Minimum 1GB available space
- **Memory**: 256MB PHP memory limit
- **Upload**: 10MB file upload limit

### Required PHP Extensions

- ✅ PDO & PDO MySQL
- ✅ JSON
- ✅ mbstring
- ✅ GD or Imagick
- ✅ ZIP
- ✅ cURL
- ✅ OpenSSL

### Domain Setup

- Domain or subdomain configured
- SSL certificate installed (recommended)
- DNS properly pointed to hosting

---

## 📦 Step 1: Download & Prepare Deployment Package

### Option A: Create Package from Source

```bash
# Run the package creator
php scripts/create_deployment_package.php
```

### Option B: Use Pre-built Package

Download the `export-platform-deployment.zip` file provided.

### Extract and Review

```bash
# Extract the package
unzip export-platform-deployment-*.zip

# Review contents
ls -la export-platform-deployment-*/
```

**Package Contents:**

```
export-platform-deployment/
├── .htaccess                    # Web server configuration
├── .env.example                # Environment template
├── composer.json               # PHP dependencies
├── config.php                  # Deployment configuration
├── index.php                   # Main entry point
├── install.sh                  # Auto-installer script
├── verify_deployment.php       # Post-deployment verification
├── app/                        # Core application
│   ├── Core/                   # Business logic
│   ├── Realtime/               # SSE implementation
│   ├── config/                 # Configuration
│   └── public_api.php          # REST API
├── public/                     # Public assets
│   ├── admin/                  # Admin dashboard
│   ├── uploads/                # File storage
│   └── sse.php                 # Real-time endpoint
├── scripts/                    # Deployment scripts
├── storage/                    # Application storage
│   ├── logs/                   # Log files
│   ├── backups/                # Database backups
│   └── cache/                  # Application cache
└── vendor/                     # Dependencies
```

---

## 🌐 Step 2: Web Hosting Setup

### For cPanel Hosting

1. **Login to cPanel**
2. **Create Database**:

   - Go to MySQL Databases
   - Create database: `username_export_platform`
   - Create user: `username_export_user`
   - Set strong password
   - Grant all privileges

3. **Create Subdomain** (Optional):
   - Go to Subdomains
   - Create: `workspace.yourdomain.com`
   - Document Root: `/public_html/workspace/`

### For DirectAdmin Hosting

1. **Login to DirectAdmin**
2. **Database Setup**:

   - Go to MySQL Management
   - Create database and user
   - Note connection details

3. **Domain Configuration**:
   - Configure subdomain if needed
   - Set document root

### For Other Hosting Panels

- Follow similar steps for database and domain setup
- Ensure PHP 8.3+ is selected
- Enable required PHP extensions

---

## 📁 Step 3: Upload Files

### Method 1: File Manager (Recommended for Beginners)

1. **Access File Manager** in hosting control panel
2. **Navigate to** public_html (or your domain's root)
3. **Upload** the deployment ZIP file
4. **Extract** the ZIP file
5. **Move contents** from extracted folder to domain root

### Method 2: FTP/SFTP

```bash
# Using command line (Linux/Mac)
scp -r export-platform-deployment/* user@yourhost:/path/to/domain/

# Using FileZilla or similar FTP client
# Upload all files maintaining directory structure
```

### Method 3: SSH (Advanced)

```bash
# Connect via SSH
ssh user@yourhost

# Navigate to domain directory
cd /path/to/your/domain/

# Upload and extract
wget https://yourdomain.com/export-platform-deployment.zip
unzip export-platform-deployment.zip
mv export-platform-deployment/* ./
```

---

## ⚙️ Step 4: Environment Configuration

### Create Environment File

```bash
# Copy the example environment file
cp .env.example .env
```

### Edit .env Configuration

Open `.env` file and configure:

```env
# Application Settings
APP_NAME="Export Platform"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_SECRET=your-super-secret-key-here-change-this

# Database Configuration
DB_HOST=localhost
DB_NAME=username_export_platform
DB_USER=username_export_user
DB_PASS=your_database_password
DB_CHARSET=utf8mb4

# Company Information
COMPANY_NAME="Your Company Name"
COMPANY_EMAIL=info@yourdomain.com
COMPANY_PHONE="+1-555-123-4567"

# Email Configuration (SMTP)
MAIL_HOST=smtp.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=notifications@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=notifications@yourdomain.com
MAIL_FROM_NAME="Export Platform"

# Security Settings
SESSION_LIFETIME=3600
API_RATE_LIMIT=100
FORCE_HTTPS=true

# File Upload Settings
MAX_FILE_SIZE=10485760
UPLOAD_PATH=public/uploads

# Features
ENABLE_REAL_TIME_UPDATES=true
ENABLE_EMAIL_NOTIFICATIONS=true
ENABLE_FILE_UPLOADS=true
```

**🔒 Security Note**: Generate a unique APP_SECRET:

```bash
# Generate random secret (32 characters)
openssl rand -base64 32
```

---

## 🗄️ Step 5: Database Setup

### Method 1: Auto-Installation (Recommended)

```bash
# Make installer executable
chmod +x install.sh

# Run auto-installer
./install.sh
```

### Method 2: Manual Database Migration

```bash
# Run database migration
php scripts/migrate_db.php migrate
```

### Method 3: Web-based Migration

Navigate to: `https://yourdomain.com/scripts/migrate_db.php`

**Expected Output:**

```
✓ Connected to MySQL server
✓ Database created/selected
✓ Created table: shipments
✓ Created table: shipment_documents
✓ Created table: users
✓ Created table: sse_clients
✓ Created table: sse_updates
✓ Created table: audit_log
✓ Default admin user created (admin/admin123)
✓ Sample data inserted
```

---

## 🔐 Step 6: File Permissions

### Set Correct Permissions

```bash
# Using SSH/Terminal
chmod 755 public/
chmod 755 storage/
chmod 777 public/uploads/
chmod 777 storage/logs/
chmod 777 storage/cache/
chmod 644 .htaccess
chmod 600 .env

# Or using File Manager
# Right-click → Permissions
# Folders: 755, Upload folders: 777, .env: 600
```

### Create Required Directories

```bash
mkdir -p storage/logs
mkdir -p storage/backups
mkdir -p storage/cache
mkdir -p public/uploads/documents
mkdir -p public/uploads/temp
```

---

## ✅ Step 7: Verify Deployment

### Run Verification Script

```bash
# Command line verification
php verify_deployment.php

# Or via web browser
https://yourdomain.com/verify_deployment.php
```

**Expected Output:**

```
🔍 Post-Deployment Verification
==============================

PHP Version                    ✅ 8.3.x (✓ Compatible)
Extension: pdo                 ✅ Loaded
Extension: pdo_mysql           ✅ Loaded
Extension: json                ✅ Loaded
Extension: mbstring            ✅ Loaded
Extension: gd                  ✅ Loaded
Database Connection            ✅ Connected to export_platform
Database Tables                ✅ Tables exist
API: health                    ✅ File exists
SSE Endpoint                   ✅ File exists
Admin Panel                    ✅ File exists

📈 Summary: 10/10 tests passed
🎉 All tests passed! Your deployment is ready.
```

---

## 🧪 Step 8: Test Functionality

### 1. Admin Panel Access

- **URL**: `https://yourdomain.com/public/admin/`
- **Login**: `admin` / `admin123`
- **Test**: All navigation buttons work

### 2. API Endpoints

- **Health**: `https://yourdomain.com/api/health`
- **Stats**: `https://yourdomain.com/api/stats`
- **Shipments**: `https://yourdomain.com/api/shipments`

### 3. Real-time Updates

- **SSE**: `https://yourdomain.com/sse`
- **Test**: Connection shows in browser developer tools

### 4. File Upload

- **Test**: Upload documents in admin panel
- **Verify**: Files appear in `public/uploads/`

---

## 🔧 Step 9: Production Configuration

### Change Default Passwords

```bash
# Login to admin panel
# Go to Settings → Users
# Change admin password immediately
```

### Configure SSL/HTTPS

```bash
# Force HTTPS in .env
FORCE_HTTPS=true

# Verify .htaccess has HTTPS redirect
# (Already included in deployment package)
```

### Set Up Cron Jobs

Add these to your hosting control panel's cron jobs:

```bash
# Real-time cleanup (every 5 minutes)
*/5 * * * * /usr/bin/php /path/to/your/domain/scripts/cleanup_sse.php

# Daily backups (3 AM)
0 3 * * * /usr/bin/php /path/to/your/domain/scripts/backup.php

# Log rotation (weekly)
0 2 * * 0 /usr/bin/php /path/to/your/domain/scripts/rotate_logs.php
```

### Configure Email Notifications

Test email functionality:

```bash
# Send test email via admin panel
# Settings → Email → Send Test Email
```

---

## 🎯 Step 10: Go Live Checklist

### Security Checklist

- [ ] ✅ Default admin password changed
- [ ] ✅ APP_SECRET generated and set
- [ ] ✅ Database password is strong
- [ ] ✅ .env file permissions set to 600
- [ ] ✅ HTTPS/SSL enabled and forced
- [ ] ✅ File upload restrictions in place

### Functionality Checklist

- [ ] ✅ Admin panel loads and works
- [ ] ✅ API endpoints respond correctly
- [ ] ✅ Real-time updates working
- [ ] ✅ Database connection successful
- [ ] ✅ File uploads working
- [ ] ✅ Email notifications configured

### Performance Checklist

- [ ] ✅ OPcache enabled (check hosting settings)
- [ ] ✅ Gzip compression working
- [ ] ✅ Browser caching configured
- [ ] ✅ Log rotation set up

---

## 🚨 Troubleshooting

### Common Issues

#### 1. **500 Internal Server Error**

```bash
# Check error logs
tail -f storage/logs/error.log

# Common causes:
- Wrong file permissions
- Missing .htaccess
- PHP version too old
- Missing PHP extensions
```

#### 2. **Database Connection Failed**

```bash
# Verify credentials in .env
# Test connection:
mysql -h localhost -u username_export_user -p username_export_platform
```

#### 3. **Admin Panel Won't Load**

```bash
# Check if files exist:
ls public/admin/index.html
ls public/admin/assets/

# Verify .htaccess routing rules
```

#### 4. **Real-time Updates Not Working**

```bash
# Test SSE endpoint directly:
curl -H "Accept: text/event-stream" https://yourdomain.com/sse

# Check server supports SSE (most shared hosting does)
```

#### 5. **File Upload Errors**

```bash
# Check upload directory permissions:
ls -la public/uploads/

# Verify PHP upload settings:
php -i | grep upload
```

---

## 📞 Support & Maintenance

### Getting Help

- **Documentation**: Check README_hostinger.md
- **Logs**: Monitor `storage/logs/` for errors
- **Verification**: Re-run `verify_deployment.php` anytime

### Regular Maintenance

1. **Monitor logs** weekly
2. **Backup database** regularly
3. **Update passwords** monthly
4. **Check disk space** usage
5. **Review security** settings

### Updates

1. **Download** new deployment package
2. **Backup** current installation
3. **Upload** new files (preserve .env)
4. **Run** database migrations
5. **Verify** functionality

---

## 🎉 Deployment Complete!

**Your Export Platform is now live and ready for use!**

### Access Points:

- **Admin Panel**: `https://yourdomain.com/public/admin/`
- **API Base**: `https://yourdomain.com/api/`
- **Health Check**: `https://yourdomain.com/api/health`

### Next Steps:

1. 🔑 Change default admin password
2. 👥 Create additional user accounts
3. 📊 Start managing shipments
4. 📧 Configure email templates
5. 📈 Monitor analytics dashboard

**Welcome to your new Export Management Platform! 🚀**

---

_For additional support or custom configurations, refer to the included documentation or contact your system administrator._
