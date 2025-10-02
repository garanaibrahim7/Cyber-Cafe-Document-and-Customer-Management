# php-project


# Cyber Cafe Management System

A comprehensive web application for managing cyber cafe operations, customer records, document handling, and automated file sharing with built-in expiration.
(ya i'm lazy that's why i've generated this with the help of AI)
## 🌟 Features

### 📊 Customer & Document Management
- **Customer Registration**: Add new customers with complete details
- **Work Receipt Generation**: Automatically print receipts for customer services
- **Database Storage**: Secure storage of all customer records and transactions
- **Excel Reporting**: Export daily reports and customer data to Excel format
- **Service Management**: Track and manage current services and ongoing work

### 📁 File Sharing System
- **Secure File Uploads**: Customers can upload and share files securely
- **Automatic Cleanup**: Files are automatically deleted after 7 days from the server
- **Temporary Storage**: Ideal for temporary document sharing and printing services

### 📈 Reporting & Analytics
- **Daily Work Reports**: Comprehensive overview of daily activities
- **Revenue Tracking**: Monitor daily earnings and service trends
- **Service Analytics**: Track popular services and peak hours (not implemented, but can be Possible)

## 🛠️ Technology Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Reporting**: Excel export functionality (using phpspreadsheet library)
- **File Management**: Secure file upload and storage system

## 📋 Prerequisites

- Web Server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL Database
- Browser with JavaScript enabled

## 🚀 Installation

1. **Clone or Download the Project**
   ```bash
   git clone [https://github.com/garanaibrahim7/Cyber-Cafe-Document-and-Customer-Management]
   ```

2. **Database Setup**
   - Create a MySQL database
   - Import the provided SQL schema file from '/Database File/db.sql
   - Update database credentials in `config.php`

3. **Server Configuration**
   - Place folder in your web server directory (e.g., `htdocs` or `www`)
   - Ensure proper file permissions for uploads directory
   - Configure PHP settings for file uploads if needed

4. **Access the Application**
   - Open your browser and navigate to the project directory
   - The application should be ready to use

## 📖 Usage

### Managing Customers
1. Navigate to the Customer Management section
2. Add new customers with their details
3. Generate work receipts for services rendered
4. View and edit existing customer records

### File Sharing
1. Upload files through the file sharing interface
2. Share the generated link with customers
3. Files will be automatically deleted after 7 days
4. Monitor file usage and storage

### Reports & Analytics
1. Access daily reports from the dashboard
2. Generate Excel reports for record keeping
3. Analyze service trends and customer patterns
4. Track revenue and popular services

## 🔧 Configuration

### File Upload Settings
- Maximum file size: Configurable in PHP settings
- Allowed file types: Customizable in the application
- Storage directory: `uploads/` (automatically managed)

### Database Configuration
Update `config/database.php` with your database credentials:
```php
$host = 'localhost';
$dbname = 'DatabaseName';
$username = 'your_username';
$password = 'your_password';
```


## ⚙️ Automated Features

### File Cleanup
- Automatic deletion of files older than 7 days
- Scheduled cleanup runs daily
- No manual intervention required

### Report Generation
- Daily automatic report compilation
- Excel export functionality
- Historical data tracking

## 🔒 Security Features

- Secure file upload validation
- SQL injection prevention
- XSS protection
- Session management
- File access controls

## 📊 Reports Generated

1. **Daily Work Report**
   - Services provided
   - Customer count
   - Revenue summary
   - Peak hours analysis

2. **Customer Reports**
   - New customer registrations
   - Returning customer statistics
   - Service preferences

3. **Financial Reports**
   - Daily earnings
   - Service-wise revenue
   - Payment methods summary

## 🆘 Support

For technical support or issues:
1. Check the error logs in the `logs/` directory
2. Verify database connection settings
3. Ensure file permissions are correctly set
4. Check PHP error reporting for debugging

## 📄 License

This project is developed for local cyber cafe management and is intended for educational and small business use.

## 🔄 Version History

- **v1.0** (Current)
  - Initial release with core features
  - Customer management
  - File sharing with auto-cleanup
  - Basic reporting system

---

**Note**: This system is designed specifically for cyber cafe operations and includes features tailored for document management, customer service tracking, and temporary file sharing needs.
