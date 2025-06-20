# Export Platform - Hostinger Deployment Guide

## 🚀 Quick Deployment for Hostinger Shared Hosting

This comprehensive export business management platform is specifically optimized for Hostinger shared hosting environments. Follow this guide for a smooth deployment.

## 📋 Prerequisites

### Hostinger Requirements

- **Hosting Plan**: Premium or Business plan (required for subdomains and advanced features)
- **PHP Version**: 8.3 or higher
- **MySQL**: 8.0 or higher
- **Storage**: At least 2GB available space
- **Domain**: Access to subdomain creation (workspace.calicutspicetraders.in)

### Technical Requirements

- SSH access (Business plan) or File Manager access
- MySQL database creation permissions
- Cron job configuration access

## 🔧 Installation Process

### Step 1: Domain & Subdomain Setup

1. **Login to Hostinger hPanel**
2. **Create Subdomain**:
   ```
   Subdomain: workspace
   Domain: calicutspicetraders.in
   Document Root: /domains/workspace.calicutspicetraders.in/public_html
   ```
3. **Configure DNS** (if using external domain):
   - Add A record: `workspace.calicutspicetraders.in` → Your server IP

### Step 2: Database Configuration

1. **Create MySQL Database**:

   ```
   Database Name: username_export_platform
   Username: username_export_user
   Password: [Generate strong password]
   ```

2. **Note Database Details**:
   ```
   Host: localhost
   Port: 3306
   Charset: utf8mb4
   ```

### Step 3: File Upload & Extraction

#### Option A: Using Hostinger File Manager

1. Upload `export-platform.zip` to `/domains/workspace.calicutspicetraders.in/`
2. Extract the ZIP file
3. Move contents to `public_html` directory

#### Option B: Using SSH (Business plan)

```bash
# Connect via SSH
ssh username@your-server-ip

# Navigate to domain directory
cd /domains/workspace.calicutspicetraders.in/

# Upload and extract
wget https://your-deployment-url/export-platform.zip
unzip export-platform.zip
mv export-platform/* public_html/
```

### Step 4: Environment Configuration

1. **Copy Environment Template**:

   ```bash
   cp .env.example .env
   ```

2. **Edit `.env` File** with your Hostinger details:

   ```env
   # Database Configuration
   DB_HOST=localhost
   DB_NAME=username_export_platform
   DB_USER=username_export_user
   DB_PASS=your_database_password

   # Application URL
   APP_URL=https://workspace.calicutspicetraders.in

   # Company Information
   COMPANY_NAME="Calicut Spice Traders"
   COMPANY_EMAIL=info@calicutspicetraders.in

   # File Upload Path
   UPLOAD_PATH=public/uploads

   # Email Configuration (Hostinger SMTP)
   MAIL_HOST=smtp.hostinger.com
   MAIL_PORT=587
   MAIL_USERNAME=notifications@calicutspicetraders.in
   MAIL_PASSWORD=your_email_password
   ```

### Step 5: Dependency Installation

#### Using Hostinger's Composer (Recommended)

1. Access **PHP Management** in hPanel
2. Enable **Composer** for your domain
3. Run installation:
   ```bash
   cd public_html
   composer install --no-dev --optimize-autoloader
   ```

#### Manual Installation (if Composer unavailable)

1. Download pre-built vendor dependencies
2. Upload `vendor.zip` to your domain
3. Extract in the root directory

### Step 6: Database Migration

#### Option A: Web-based Migration

1. Navigate to: `https://workspace.calicutspicetraders.in/scripts/migrate_db.php`
2. Check output for successful migration

#### Option B: Command Line Migration

```bash
cd public_html
php scripts/migrate_db.php migrate
```

### Step 7: File Permissions

Set correct permissions for security and functionality:

```bash
# Using SSH
chmod 755 public_html/
chmod 755 public_html/public/
chmod 777 public_html/public/uploads/
chmod 644 public_html/.htaccess
chmod 600 public_html/.env

# Using File Manager
# Right-click → Permissions
# Folders: 755, Files: 644, Uploads: 777, .env: 600
```

### Step 8: PHP Configuration

1. **Access PHP Management** in hPanel
2. **Update PHP Settings**:

   ```ini
   memory_limit = 256M
   max_execution_time = 120
   upload_max_filesize = 10M
   post_max_size = 12M
   opcache.enable = 1
   opcache.jit_buffer_size = 100M
   ```

3. **Enable Required Extensions**:
   - ✅ PDO MySQL
   - ✅ JSON
   - ✅ mbstring
   - ✅ GD
   - ✅ ZIP
   - ✅ cURL
   - ✅ OpenSSL

### Step 9: Cron Jobs Setup

Configure automated tasks in **Cron Jobs** section:

```bash
# Real-time updates cleanup (every 5 minutes)
*/5 * * * * /usr/bin/php /domains/workspace.calicutspicetraders.in/public_html/scripts/cleanup_sse.php

# Daily backups (3 AM)
0 3 * * * /usr/bin/php /domains/workspace.calicutspicetraders.in/public_html/scripts/backup.php

# Email notifications (every 15 minutes)
*/15 * * * * /usr/bin/php /domains/workspace.calicutspicetraders.in/public_html/scripts/send_notifications.php

# Log rotation (weekly)
0 2 * * 0 /usr/bin/php /domains/workspace.calicutspicetraders.in/public_html/scripts/rotate_logs.php
```

## 🔒 Security Configuration

### SSL Certificate Setup

1. **Enable SSL** in hPanel
2. **Force HTTPS** redirects
3. **Update .htaccess** for security headers

### IP Whitelisting (Optional)

Edit `.htaccess` to restrict admin access:

```apache
<Location "/admin">
    Require ip 192.168.1.100
    Require ip 203.0.113.0/24
</Location>
```

### File Upload Security

Ensure upload restrictions are properly configured:

```apache
<Directory "public/uploads">
    <Files "*.php">
        Require all denied
    </Files>
</Directory>
```

## 🧪 Testing Your Installation

### 1. Basic Functionality Test

- ✅ Navigate to: `https://workspace.calicutspicetraders.in`
- ✅ Admin panel: `https://workspace.calicutspicetraders.in/admin`
- ✅ API health: `https://workspace.calicutspicetraders.in/api/health`

### 2. Real-time Updates Test

- ✅ SSE endpoint: `https://workspace.calicutspicetraders.in/sse`
- ✅ WebSocket fallback working
- ✅ Dashboard live updates

### 3. File Upload Test

- ✅ Document upload functionality
- ✅ File type restrictions
- ✅ Size limit enforcement

### 4. Database Connection Test

- ✅ Login with default admin (admin/admin123)
- ✅ Create test shipment
- ✅ View analytics dashboard

## 🎯 Performance Optimization

### OPcache Configuration

Add to your PHP configuration:

```ini
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=256M
opcache.jit_buffer_size=100M
opcache.max_accelerated_files=20000
opcache.preload=/domains/workspace.calicutspicetraders.in/public_html/scripts/opcache_preload.php
```

### Gzip Compression

Enabled automatically via `.htaccess` for:

- ✅ CSS files
- ✅ JavaScript files
- ✅ JSON responses
- ✅ HTML content

### Browser Caching

Configured for optimal performance:

- ✅ Static assets: 1 month
- ✅ Images: 1 month
- ✅ API responses: No cache

## 📊 Monitoring & Maintenance

### Health Checks

Monitor your installation:

```bash
# System health
curl https://workspace.calicutspicetraders.in/api/health

# Database connection
mysql -h localhost -u username_export_user -p username_export_platform

# Disk usage
du -sh /domains/workspace.calicutspicetraders.in/
```

### Log Monitoring

Check application logs:

```bash
# Error logs
tail -f public_html/storage/logs/error.log

# Access logs
tail -f public_html/storage/logs/access.log

# Application logs
tail -f public_html/storage/logs/app.log
```

### Backup Verification

Ensure backups are working:

```bash
# Check backup files
ls -la public_html/storage/backups/

# Test database backup
mysqldump -h localhost -u username_export_user -p username_export_platform > test_backup.sql
```

## 🚨 Troubleshooting

### Common Issues

#### 1. Database Connection Failed

```bash
# Check database credentials
mysql -h localhost -u username_export_user -p

# Verify .env configuration
grep DB_ .env
```

#### 2. File Upload Errors

```bash
# Check upload directory permissions
ls -la public/uploads/

# Verify PHP upload settings
php -i | grep upload
```

#### 3. Real-time Updates Not Working

```bash
# Test SSE endpoint
curl -H "Accept: text/event-stream" https://workspace.calicutspicetraders.in/sse

# Check PHP processes
ps aux | grep php
```

#### 4. Performance Issues

```bash
# Check OPcache status
php -i | grep opcache

# Monitor memory usage
free -m

# Check slow queries
mysql -e "SHOW PROCESSLIST;"
```

### Error Codes & Solutions

| Error Code | Issue        | Solution                                    |
| ---------- | ------------ | ------------------------------------------- |
| 500        | Server Error | Check error logs, verify .env configuration |
| 403        | Forbidden    | Check file permissions, verify .htaccess    |
| 404        | Not Found    | Verify URL rewriting, check .htaccess rules |
| 502        | Bad Gateway  | Check PHP-FPM status, restart if needed     |

## 📞 Support & Updates

### Getting Help

- 📧 Technical Support: tech@calicutspicetraders.in
- 📖 Documentation: [Platform Wiki]
- 🐛 Bug Reports: Create detailed issue reports

### Update Process

1. **Backup Current Installation**
2. **Download Latest Release**
3. **Extract and Replace Files**
4. **Run Database Migrations**
5. **Clear OPcache**
6. **Test Functionality**

### Version Information

- **Current Version**: 1.0.0
- **PHP Compatibility**: 8.3+
- **MySQL Compatibility**: 8.0+
- **Last Updated**: January 2024

## 🔐 Default Credentials

**⚠️ IMPORTANT: Change these immediately after installation!**

### Admin Access

- **URL**: `https://workspace.calicutspicetraders.in/admin`
- **Username**: `admin`
- **Password**: `admin123`

### Database Access

- **Host**: localhost
- **Database**: username_export_platform
- **Username**: username_export_user
- **Password**: [As configured in .env]

## 📈 Production Checklist

Before going live, ensure:

- [ ] ✅ SSL certificate installed and working
- [ ] ✅ Database backups configured and tested
- [ ] ✅ Admin password changed from default
- [ ] ✅ Email notifications working
- [ ] ✅ File upload restrictions in place
- [ ] ✅ Cron jobs configured and running
- [ ] ✅ Error monitoring enabled
- [ ] ✅ Performance optimization applied
- [ ] ✅ Security headers configured
- [ ] ✅ IP whitelisting (if required)
- [ ] ✅ Real-time updates tested
- [ ] ✅ Mobile responsiveness verified

---

**🎉 Congratulations!** Your Export Platform is now successfully deployed on Hostinger shared hosting. The system is optimized for performance, security, and reliability within Hostinger's constraints.

For technical support or questions about this deployment, contact our technical team at tech@calicutspicetraders.in.
