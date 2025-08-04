# Mini-4 Blog/CMS System

A simple PHP-based blog and content management system built with MVC architecture.

## Features

- **User Management**: Registration, login, and user roles (admin/user)
- **Blog Posts**: Create, edit, delete, and view blog posts
- **Categories**: Organize posts by categories
- **Comments**: Comment system for blog posts
- **Admin Panel**: Full admin interface for content management
- **Responsive Design**: Modern and clean UI

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd Mini-4
   ```

2. **Set up the database**
   - Create a MySQL database named `blog`
   - Import the database schema:
   ```bash
   mysql -u root -p blog < database.sql
   ```

3. **Configure database connection**
   - Edit `config/database.php` with your database credentials:
   ```php
   return [
       'host' => 'localhost',
       'database' => 'blog',
       'username' => 'your_username',
       'password' => 'your_password',
       'charset' => 'utf8mb4',
       'options' => [
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           PDO::ATTR_EMULATE_PREPARES => false,
           PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
       ]
   ];
   ```

4. **Set up web server**
   - Point your web server's document root to the `public/` directory
   - For Apache, create a `.htaccess` file in the `public/` directory:
   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php [QSA,L]
   ```

5. **Access the application**
   - Frontend: `http://localhost/Mini-4/public/`
   - Admin panel: `http://localhost/Mini-4/public/admin`

## Project Structure

```
Mini-4/
├── config/
│   └── database.php          # Database configuration
├── controllers/
│   ├── admin/               # Admin controllers
│   └── client/              # Client controllers
├── core/
│   ├── Controller.php       # Base controller
│   ├── Database.php         # Database connection
│   ├── Model.php           # Base model
│   └── Router.php          # URL routing
├── models/
│   ├── Category.php
│   ├── Comment.php
│   ├── Post.php
│   └── User.php
├── public/
│   ├── css/
│   ├── js/
│   └── index.php           # Entry point
├── views/
│   ├── admin/              # Admin views
│   └── client/             # Client views
└── database.sql            # Database schema
```

## Usage

### For Users
- Register an account
- Browse blog posts
- Leave comments on posts
- View user profiles

### For Administrators
- Access admin panel at `/admin`
- Manage posts, categories, comments, and users
- Create and edit content
- Moderate comments

## Development

This project uses a simple MVC architecture:
- **Models**: Handle data and business logic
- **Views**: Display data to users
- **Controllers**: Handle user requests and coordinate between models and views

## License

This project is open source and available under the MIT License.

## Support

For issues and questions, please create an issue in the project repository. 