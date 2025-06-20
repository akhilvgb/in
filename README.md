# 🇮🇳 Indian Import/Export Trading Platform

A comprehensive web-based platform for managing import, export, and trading operations with real-time tracking, CRM, and workflow management.

![Platform](https://img.shields.io/badge/Platform-Web-blue)
![PHP](https://img.shields.io/badge/PHP-8.1+-green)
![Database](https://img.shields.io/badge/Database-MySQL-orange)
![License](https://img.shields.io/badge/License-MIT-yellow)
![Deployment](https://img.shields.io/badge/Deployment-Hostinger-purple)

## 🌟 Features

### 📦 **Shipment Management**

- **Import Tracking** - Monitor incoming shipments from global suppliers
- **Export Management** - Handle outbound shipments to international markets
- **Trading Operations** - Manage inter-trading transactions
- **Domestic Shipping** - Local distribution and logistics

### 👥 **CRM System**

- **Lead Management** - Track potential customers and opportunities
- **Customer Database** - Comprehensive customer profiles with GST/IEC
- **Follow-up Automation** - Automated reminders and task scheduling
- **Conversion Tracking** - Monitor lead-to-customer conversion rates

### 📋 **Workflow Management**

- **Task Assignment** - Delegate tasks to team members
- **Compliance Tracking** - Monitor regulatory requirements
- **Document Management** - Centralized document storage
- **Progress Monitoring** - Real-time project status updates

### 📊 **Analytics & Reporting**

- **Trade Analytics** - Import/Export performance metrics
- **Revenue Tracking** - Monthly and yearly revenue reports
- **Market Insights** - Trading volume and destination analysis
- **Performance Dashboards** - Real-time business intelligence

### 🔒 **Security & Compliance**

- **Role-based Access** - Admin, Manager, Operator, Viewer roles
- **Audit Logging** - Complete activity tracking
- **Data Protection** - Secure file uploads and storage
- **Compliance Monitoring** - Regulatory requirement tracking

### 🌐 **Multi-language Support**

- **English** - Primary interface language
- **Hindi** - Native language support
- **Extensible** - Easy addition of more languages

## 🚀 Quick Deploy to Hostinger

### Option 1: One-Click GitHub Deployment

1. **Fork this repository**
2. **Connect to Hostinger**:
   - Go to Hostinger hPanel
   - Connect your GitHub repository
   - Enable auto-deployment
3. **Configure Database**:
   - Create MySQL database in cPanel
   - Update `.env` with database credentials
4. **Initialize**:
   - Visit `/scripts/migrate_db.php`
   - Access platform at `/public/admin/`

### Option 2: Manual Upload

1. **Download**:

   ```bash
   git clone https://github.com/yourusername/indian-trade-platform.git
   cd indian-trade-platform
   php scripts/deploy_hostinger.php
   ```

2. **Upload**:

   - Zip `public_html` folder
   - Upload via Hostinger File Manager
   - Extract to your domain directory

3. **Setup**:
   - Configure database in `.env`
   - Run migration script
   - Access your platform

📖 **[Complete Deployment Guide](HOSTINGER_DEPLOYMENT.md)**

## 💻 System Requirements

- **PHP**: 8.1 or higher
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Extensions**: PDO, JSON, mbstring, GD, Zip, cURL
- **Storage**: 500MB minimum
- **SSL**: Recommended for production

## 🏗️ Architecture

```
├── app/                    # Backend PHP Application
│   ├── Core/              # Core business logic
│   │   ├── Shipment.php   # Shipment management
│   │   ├── Database.php   # Database operations
│   │   └── User.php       # User management
│   ├── config/            # Configuration files
│   └── public_api.php     # REST API endpoints
├── public/                # Frontend Assets
│   ├── admin/             # Admin dashboard
│   │   ├── index.html     # Main interface
│   │   └── assets/        # CSS, JS, images
│   └── sse.php           # Real-time updates
├── scripts/               # Deployment & maintenance
└── uploads/               # Document storage
```

## 🔧 Configuration

### Environment Variables (.env)

```env
# Database
DB_HOST=localhost
DB_NAME=your_database
DB_USER=your_user
DB_PASS=your_password

# Application
APP_ENV=production
COMPANY_NAME=Your Company Name
COMPANY_EMAIL=info@yourcompany.com

# Features
ENABLE_IMPORT=true
ENABLE_EXPORT=true
ENABLE_TRADING=true
```

### Default Login

- **URL**: `https://yourdomain.com/public/admin/`
- **Username**: `admin`
- **Password**: `admin123`

⚠️ **Change default password immediately after first login**

## 📱 Screenshots

### Dashboard

![Dashboard](https://via.placeholder.com/800x400?text=Indian+Trade+Platform+Dashboard)

### Shipment Management

![Shipments](https://via.placeholder.com/800x400?text=Shipment+Tracking+Interface)

### CRM System

![CRM](https://via.placeholder.com/800x400?text=Customer+Relationship+Management)

## 🛣️ Roadmap

- [ ] **Mobile App** - React Native mobile application
- [ ] **API Integration** - Third-party logistics APIs
- [ ] **Blockchain** - Supply chain transparency
- [ ] **AI Analytics** - Predictive trade insights
- [ ] **Multi-currency** - Extended currency support
- [ ] **Advanced Reports** - Custom report builder

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📞 Support

- **Documentation**: [Wiki](https://github.com/yourusername/indian-trade-platform/wiki)
- **Issues**: [GitHub Issues](https://github.com/yourusername/indian-trade-platform/issues)
- **Discussions**: [GitHub Discussions](https://github.com/yourusername/indian-trade-platform/discussions)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🏆 Acknowledgments

- Built for the Indian import/export business community
- Optimized for shared hosting environments
- Designed with security and scalability in mind
- Supports growing businesses from startup to enterprise

---

**⭐ Star this repository if it helps your business!**

**🚀 Deploy now and streamline your import/export operations!**
