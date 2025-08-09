# 📅 Client Agenda

A simple web application for managing clients and appointments using jQuery, PHP and MySQL.

## 🚀 Features

- **Client Management**: Save client data (name, surname, phone, email, etc.)
- **Appointment Calendar**: Display and manage appointments with FullCalendar
- **Claims Management**: Register and track insurance claims
- **File Upload**: Upload documents for each client
- **Secure Login**: User authentication system

## 🛠️ Technologies

- **Frontend**: jQuery Mobile, FullCalendar.js
- **Backend**: PHP
- **Database**: MySQL
- **UI**: jQuery Mobile responsive

## 📋 Installation

1. **Database**: Import the `agenda.sql` file into your MySQL database
2. **Configuration**: Edit `php/connection.php` with your database credentials
3. **Server**: Upload files to a web server with PHP support
4. **Access**: Go to `login.html` to access the application

## 📁 Structure

```
agenda/
├── index.html           # Main page
├── login.html          # Login page
├── agenda.sql          # Database schema
├── php/                # PHP backend scripts
├── style/              # CSS and icons
├── script/             # Custom JavaScript
├── fullcalendar/       # Calendar library
└── jquery-mobile/      # Mobile framework
```

## 🎯 Main Features

- **Interactive calendar** to view all appointments
- **Modal popups** to add/edit clients and appointments
- **Client search** by name or other parameters
- **Group management** to organize clients
- **Responsive interface** optimized for mobile

## 🔧 Database Configuration

The database includes the following tables:
- `login` - User credentials
- `gruppo` - Client groups
- `utente` - Client data
- `appuntamento` - Appointments
- `sinistro` - Claims management
- `file` - Uploaded files
