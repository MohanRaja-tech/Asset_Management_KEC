# Lab Inventory Management System

A comprehensive web-based inventory management system for laboratory equipment and printers.

## 📁 Project Structure

```
asset_management/
├── index.php               # Main application (single-page app)
├── css/
│   └── style.css           # Styles
├── api/
│   ├── switches/           # Switches API endpoints
│   │   ├── fetch_switches.php
│   │   ├── insert_switch.php
│   │   ├── update_switch.php
│   │   └── delete_switch.php
│   ├── printers/           # Printers API endpoints
│   │   ├── fetch_printers.php
│   │   ├── insert_printer.php
│   │   ├── update_printer.php
│   │   └── delete_printer.php
│   └── system/             # Systems API endpoints
│       ├── fetch.php
│       ├── insert.php
│       ├── update.php
│       ├── delete.php
│       └── save.php
├── config/
│   └── database.php        # DB connection
├── database/
│   ├── migrations/         # DB migrations (versioned)
│   │   └── 20251005_fix_switches_table.php
│   └── create_printers_table.php
├── scripts/
│   └── maintenance/        # One-off maintenance utilities
│       ├── check_auto_increment.php
│       ├── fix_auto_increment.php
│       ├── manual_fix_auto_increment.php
│       ├── force_reset_auto_increment.php
│       └── auto_increment_manager.php
├── assets/
│   ├── images/
│   └── icons/
└── docs/
```

## 🚀 Features

### Dashboard
- **Overview Statistics**: Total systems, departments, value, recent additions
- **Visual Charts**: Department distribution and recent activity
- **Real-time Data**: Live updates from database

### System Inventory
- **Complete CRUD Operations**: Create, Read, Update, Delete system records
- **Advanced Search**: Search across all fields
- **Excel Export**: Download inventory reports
- **Inline Editing**: Edit records directly in the table
- **Responsive Design**: Mobile-friendly interface

### Printer Management
- **Printer-specific Fields**: Type, paper size, cartridge model, etc.
- **Department Management**: Assign printers to different departments
- **Cost Tracking**: Track printer costs and purchase information
- **Excel Export**: Generate printer reports

### Reports & Analytics
- **Department Distribution**: Visual charts showing system distribution
- **Cost Analysis**: Financial overview of inventory
- **Purchase Timeline**: Track acquisition patterns
- **Export Options**: PDF, CSV, and Excel reports

### Settings
- **Database Configuration**: Manage database settings
- **Department Management**: Add/remove departments
- **Appearance Settings**: Theme and language preferences
- **Security Settings**: Session timeout and 2FA options

## 🛠️ Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Database Setup

1. **Create Database**:
   ```sql
   CREATE DATABASE inventory_db;
   CREATE USER 'asset_user'@'localhost' IDENTIFIED BY 'StrongPass123!';
   GRANT ALL PRIVILEGES ON inventory_db.* TO 'asset_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

2. **Run Setup Scripts**:
   ```bash
   php database/create_printers_table.php
   php database/create_racks_table.php
   ```

3. **Configure Database**:
   Update `config/database.php` with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'inventory_db');
   define('DB_USER', 'asset_user');
   define('DB_PASS', 'StrongPass123!');
   ```

### Web Server Setup

1. **Apache**: Place files in web root directory
2. **Nginx**: Configure virtual host
3. **PHP Built-in Server** (Development):
   ```bash
   php -S localhost:8000
   ```

## 📊 Database Schema

### System Inventory Table (`lab_inventory`)
- `id` - Primary key
- `dept` - Department (CSE, ECE, IT, ME, CE, EEE)
- `lab_name` - Laboratory name
- `make_name` - Manufacturer
- `model_name` - Model number
- `serial_no` - Serial number
- `processor` - Processor type
- `generation` - Processor generation
- `ram_gb` - RAM in GB
- `primary_storage` - Primary storage
- `secondary_storage` - Secondary storage
- `operating_system` - OS installed
- `gpu_name` - Graphics card
- `monitor_type` - Monitor type
- `monitor_size` - Monitor size
- `monitor_serial` - Monitor serial
- `qty` - Quantity
- `cost` - Cost
- `reg_no` - Registration number
- `p_no` - Purchase number
- `dop` - Date of purchase
- `remarks` - Additional remarks

### Printer Inventory Table (`printers`)
- `id` - Primary key
- `dept` - Department
- `lab_name` - Laboratory name
- `make` - Manufacturer
- `model` - Model number
- `type` - Printer type (Laser, DMP, Inkjet, All in one, Xerox, Scanner)
- `paper_size` - Supported paper size
- `cartridge_model` - Cartridge model
- `total_printers` - Number of printers
- `cost` - Cost
- `reg_no` - Registration number
- `p_no` - Purchase number
- `dop` - Date of purchase
- `remarks` - Additional remarks
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Network Racks Table (`racks`)
Depending on when you created the table, the size field might exist as either the new canonical `rack_size` or an earlier legacy column named `size`.

- `id` - Primary key
- `dept` - Department
- `lab_name` - Laboratory / location
- `make` - Manufacturer (required)
- `rack_size` (or legacy `size`) - Physical rack size (e.g., 42U)
- `pdu` - Power Distribution Unit details
- `reg_no` - Register / asset register number
- `page_no` - Register page number
- `price` - Purchase price (DECIMAL)
- `dop` - Date of purchase (DATE)
- `supplier_name` - Supplier / vendor name
- `remarks` - Additional notes
- `created_at` - Creation timestamp

If you still have the legacy `size` column and want to standardize the schema, run:
```sql
ALTER TABLE racks CHANGE COLUMN size rack_size VARCHAR(50) NULL;
```

After standardizing you may optionally simplify backend code by removing alias logic (not required—current code auto-detects).

## 🔧 Configuration

### Environment Variables
Update `config/database.php` for your environment:
- Database host, name, username, password
- Application settings
- Debug mode (development vs production)

### Security
- Change default database credentials
- Enable HTTPS in production
- Set proper file permissions
- Regular security updates

## 📱 Responsive Design

The application is fully responsive and works on:
- **Desktop**: Full feature set with large tables
- **Tablet**: Optimized layout with touch-friendly controls
- **Mobile**: Collapsible navigation and mobile-optimized forms

## 🎨 Customization

### Themes
- Light theme (default)
- Dark theme
- Auto theme (system preference)

### Styling
- Modify `css/style.css` for custom styling
- CSS variables for easy color scheme changes
- Responsive breakpoints for different screen sizes

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Failed**:
   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database exists and user has permissions

2. **API Endpoints Not Working**:
   - Check file paths in `index.html`
   - Ensure PHP files are in correct directories
   - Check web server configuration

3. **Excel Export Not Working**:
   - Ensure XLSX library is loaded
   - Check browser console for JavaScript errors
   - Verify data is being fetched correctly

4. **Unknown column 'dept' in 'field list' (racks)**:
   - Your `racks` table predates new columns.
   - Run the migration script:
     ```bash
     php database/migrations/20251005_add_columns_to_racks.php
     ```
   - Refresh the page after running.

5. **Column 'make' cannot be null (racks)**:
   - The API enforces `dept` and `make` as required.
   - Provide values or update UI input; backend will reject empty `make`.

6. **Field 'size' doesn't have a default value**:
   - Legacy schema uses `size` but UI/API send `rack_size`.
   - Preferred fix (standardize column name):
     ```sql
     ALTER TABLE racks CHANGE COLUMN size rack_size VARCHAR(50) NULL;
     ```
   - Temporary workaround: Leave as-is; backend auto-maps `rack_size` → `size`.

7. **Schema mismatch / missing multiple rack columns**:
   - Confirm database in `config/database.php` is correct.
   - Run both scripts:
     ```bash
     php database/create_racks_table.php
     php database/migrations/20251005_add_columns_to_racks.php
     ```
   - Check permissions for the DB user.

### Debug Mode
Enable debug mode in `config/database.php`:
```php
define('DEBUG_MODE', true);
```

## 📈 Performance

### Optimization Tips
- Use database indexes on frequently queried columns
- Implement pagination for large datasets
- Cache frequently accessed data
- Optimize images and assets
- Use CDN for external libraries

## 🔄 Updates & Maintenance

### Regular Tasks
- Backup database regularly
- Update dependencies
- Monitor error logs
- Clean up old data
- Security updates

### Version Control
- Use Git for version control
- Tag releases
- Document changes
- Test before deployment

## 📞 Support

For issues and questions:
1. Check this documentation
2. Review error logs
3. Test with sample data
4. Check browser console for errors

## 📄 License

This project is for educational and internal use. Please ensure compliance with your organization's policies.

---

**Version**: 1.0.0  
**Last Updated**: 2025-10-05  
**Author**: Lab Inventory Management Team
