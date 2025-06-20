# 🚀 Indian Import/Export Trading Platform - Hostinger Deployment Guide

This guide will help you deploy the Indian Import/Export Trading Platform directly from GitHub to Hostinger hosting.

## 📋 Prerequisites

1. **Hostinger Account** with shared hosting plan
2. **GitHub Repository** with this codebase
3. **MySQL Database** created in Hostinger cPanel
4. **Domain/Subdomain** pointed to your hosting

## 🔧 Method 1: Automatic GitHub Deployment

### Step 1: Setup GitHub Repository

1. Fork or clone this repository
2. Go to repository **Settings** → **Secrets and variables** → **Actions**
3. Add the following secrets:
   ```
   HOSTINGER_FTP_SERVER: your-domain.com
   HOSTINGER_FTP_USERNAME: your-ftp-username
   HOSTINGER_FTP_PASSWORD: your-ftp-password
   ```

### Step 2: Configure Database

1. Login to **Hostinger cPanel**
2. Go to **MySQL Databases**
3. Create a new database (e.g., `your_username_tradedb`)
4. Create a database user and assign to the database
5. Note down: `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`

### Step 3: Deploy

1. Push code to `main` branch
2. GitHub Actions will automatically deploy
3. Files will be uploaded to your Hostinger hosting

### Step 4: Configure Environment

1. Access your hosting File Manager
2. Edit `public_html/.env` file with your database details:
   ```env
   DB_HOST=localhost
   DB_NAME=your_username_tradedb
   DB_USER=your_db_user
   DB_PASS=your_db_password
   ```

### Step 5: Run Database Migration

Visit: `https://yourdomain.com/scripts/migrate_db.php`

## 🔧 Method 2: Manual Deployment

### Step 1: Download & Prepare

```bash
git clone https://github.com/yourusername/indian-trade-platform.git
cd indian-trade-platform
php scripts/deploy_hostinger.php
```

### Step 2: Upload Files

1. Zip the `public_html` folder contents
2. Upload via **Hostinger File Manager** or FTP
3. Extract to your domain's public_html directory

### Step 3: Configure & Initialize

1. Edit `.env` file with your database credentials
2. Visit `/scripts/migrate_db.php` to setup database
3. Access your platform at `/public/admin/`

## 📁 File Structure After Deployment

```
public_html/
├── app/                    # PHP backend
│   ├── Core/              # Core classes
│   ├── config/            # Configuration
│   └── public_api.php     # API endpoints
├── public/                # Frontend assets
│   ├── admin/             # Admin interface
│   └── sse.php           # Real-time updates
├── scripts/               # Deployment scripts
├── uploads/               # File uploads
├── .env                   # Environment config
├── .htaccess             # Apache configuration
└── index.php             # Entry point
```

## 🔐 Security Configuration

The deployment automatically configures:

- ✅ **Security headers** (XSS, CSRF protection)
- ✅ **File upload restrictions**
- ✅ **Directory access protection**
- ✅ **Environment file protection**
- ✅ **SSL/HTTPS enforcement**

## 🗄️ Database Setup

After deployment, the platform will create these tables:

- `shipments` - Import/Export/Trading shipments
- `customers` - Customer management
- `leads` - CRM leads tracking
- `tasks` - Workflow management
- `users` - User authentication
- `system_settings` - Platform configuration

## 👤 Default Login

After database migration:

- **URL**: `https://yourdomain.com/public/admin/`
- **Username**: `admin`
- **Password**: `admin123`

**🚨 Important**: Change default password immediately after first login!

## 🌐 URL Structure

- **Admin Panel**: `/public/admin/`
- **API Endpoints**: `/api/[endpoint]`
- **Real-time Updates**: `/sse`
- **File Uploads**: `/uploads/`

## 📊 Features Included

✅ **Import Management** - Track incoming shipments
✅ **Export Management** - Manage outgoing shipments  
✅ **Trading Operations** - Handle trading transactions
✅ **CRM System** - Lead and customer management
✅ **Workflow Management** - Task tracking
✅ **Document Management** - File uploads and storage
✅ **Real-time Updates** - Live shipment tracking
✅ **Multi-language** - English and Hindi support
✅ **Analytics Dashboard** - Business insights
✅ **Compliance Tracking** - Regulatory requirements

## 🛠️ Customization

### Company Branding

Edit `/public/admin/index.html`:

```html
<title>Your Company Name - Trade Platform</title>
```

### API Configuration

Edit `app/config/Environment.php` for custom settings.

### Styling

Modify `/public/admin/assets/style.css` for custom themes.

## 🔧 Troubleshooting

### Database Connection Issues

1. Verify database credentials in `.env`
2. Check if database user has proper permissions
3. Ensure database exists and is accessible

### File Permission Errors

```bash
chmod 755 uploads/
chmod 755 uploads/documents/
chmod 600 .env
```

### API Not Working

1. Check `.htaccess` file is uploaded
2. Verify mod_rewrite is enabled
3. Check API endpoints: `/api/health`

### Performance Optimization

1. Enable **OPcache** in cPanel
2. Use **Cloudflare** for CDN
3. Enable **Gzip compression**

## 📞 Support

For deployment issues:

1. Check Hostinger knowledge base
2. Verify all files uploaded correctly
3. Test database connection
4. Review error logs in cPanel

## 🚀 Going Live Checklist

- [ ] Database created and configured
- [ ] Environment variables updated
- [ ] Database migration completed
- [ ] Default password changed
- [ ] SSL certificate installed
- [ ] Domain DNS configured
- [ ] File permissions set correctly
- [ ] Platform tested and accessible

---

**🎉 Your Indian Import/Export Trading Platform is now live on Hostinger!**

Access your platform at: `https://yourdomain.com/public/admin/`
