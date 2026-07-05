# Smart-Asset-Maintenance-and-Ticketing-System
A web-based Smart Asset, Maintenance &amp; Ticketing System for centralized asset management, maintenance tracking, analytics, and predictive maintenance.

# 🚀 Smart Asset Maintenance & Ticketing System

A centralized web-based Asset Management System that helps organizations efficiently manage assets, maintenance requests, technician assignments, and maintenance analytics. The system also incorporates a Machine Learning model to predict asset failure risk, enabling proactive maintenance planning.


## 📌 Features

- 🔐 User Authentication
- 🏢 Project & Asset Management
- 🎫 Maintenance Ticket Creation & Tracking
- 👨‍🔧 Technician Assignment
- 📊 Maintenance Cost & Downtime Analytics
- ⚠️ Asset Risk Prediction using Machine Learning
- 📈 Interactive Dashboard
- 🗂️ Centralized Asset Database


## 🛠️ Tech Stack

### Frontend
- HTML5
- CSS3
- JavaScript

### Backend
- PHP

### Database
- MySQL

### Machine Learning
- Python
- Scikit-learn
- Pandas
- NumPy



## 📂 Project Structure

```text
Smart-Asset-Maintenance-and-Ticketing-System/
│
├── api/                        # Backend API files
├── images/                     # Images and assets
│
├── index.html                  # Landing page
├── login.html                  # Login page
├── admin.html                  # Admin dashboard
├── pmo.html                    # PMO dashboard
├── technician.html             # Technician dashboard
├── risk_predictor.html         # Risk prediction interface
├── about.html                  # About page
├── demo.html                   # Demo page
│
├── config.php                  # Database configuration
├── testtickets.php             # Ticket management
│
├── predict_risk.py             # Machine Learning model
├── asset_maintenance_dataset.csv # Dataset used for training
│
├── asset_mang.sql              # MySQL database
├── style.css                   # Stylesheet
│
└── README.md
```


## 👥 User Roles

### 👑 Admin
- Manage projects
- Register assets
- Create maintenance tickets

### 📋 PMO
- Monitor maintenance activities
- Track ticket status
- View reports and dashboards
- Dispatch Tickets

### 👨‍🔧 Technician
- View assigned tickets
- Update maintenance status
- Record downtime and repair cost


## 🤖 Machine Learning Module

The system includes a predictive maintenance model that estimates the likelihood of asset failure based on historical maintenance data.

### Prediction Factors

- Asset Age
- Number of Previous Breakdowns
- Downtime Duration
- Maintenance Cost
- Risk Level

The model helps organizations schedule preventive maintenance before failures occur.


## 📊 Analytics

The dashboard provides insights such as:

- Total Assets
- Active Tickets
- Completed Maintenance
- Maintenance Cost
- Asset Downtime
- Risk Prediction Results


## 🗄️ Database

Database schema is provided in:

```
asset_mang.sql
```

Import this file into MySQL before running the application.

---

## ▶️ Running the Project

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/Smart-Asset-Maintenance-and-Ticketing-System.git
```

### 2. Set up the database

- Create a MySQL database.
- Import `asset_mang.sql`.

### 3. Configure the database

Update database credentials in:

```php
config.php
```

### 4. Start the PHP server

If using XAMPP/WAMP:

- Place the project inside the `htdocs` folder.
- Start Apache and MySQL.
- Open:

```
http://localhost/Smart-Asset-Maintenance-and-Ticketing-System/
```


## 🎯 Future Improvements

- Email notifications
- Real-time ticket updates
- QR Code based asset management
- Cloud deployment
- Role-based permissions
- Advanced predictive maintenance models
- Mobile application


## 👩‍💻 Authors

**Kalyani J**
**Pavithra Praveen**

Integrated MCA Students
Amrita Vishwa Vidyapeetham


## 📄 License

This project is developed for academic and learning purposes.
