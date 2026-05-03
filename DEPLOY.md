# 🚀 SportingRank Deployment Guide

This guide will help you set up and deploy **SportingRank** from scratch, even if you have no prior experience with web development or servers.

---

## 📋 Prerequisites
- A **cPanel shared hosting account** (e.g., Namecheap, Bluehost, HostGator).
- A **Domain name** (e.g., `sportingrank.com`).

---

## 🛠️ Step 1: Create the Database
Since the website is dynamic, it needs a place to store rankings. We use **MySQL**, which is standard on cPanel.

1.  **Log in to your cPanel.**
2.  Find the **"Databases"** section and click on **"MySQL® Databases"**.
3.  **Create a New Database**:
    - Type a name like `sportingrank_db` and click **Create Database**.
    - *Note down the full name (usually starts with your username, e.g., `user_sportingrank_db`).*
4.  **Create a MySQL User**:
    - Scroll down to "MySQL Users".
    - Create a user (e.g., `sr_admin`) and a **strong password**.
    - *Note down the username and password.*
5.  **Add User to Database**:
    - Under "Add User To Database", select your user and your database.
    - Click **Add**.
    - On the next screen, check **"ALL PRIVILEGES"** and click **Make Changes**.

---

## 🗄️ Step 2: Import the Schema
Now we need to create the actual tables inside the database.

1.  Go back to the cPanel home and open **"phpMyAdmin"**.
2.  In the left sidebar, click on your new database name.
3.  Click the **"Import"** tab at the top.
4.  Click **Choose File** and select the file `install/install.sql` from the project folder on your computer.
5.  Scroll to the bottom and click **Go** (or **Import**).
6.  *Success! You should now see tables like `sports`, `teams`, etc., in the sidebar.*

---

## ⚙️ Step 3: Configure the Website
The website needs to know how to talk to your database.

1.  Open the project folder on your computer.
2.  Find and open the file named **`config.php`** in a text editor (like Notepad, TextEdit, or VS Code).
3.  Change the following lines with the info from Step 1:
    ```php
    define('DB_HOST', 'localhost'); // Leave as localhost
    define('DB_USER', 'your_cpanel_db_user');     // Change this
    define('DB_PASS', 'your_cpanel_db_password'); // Change this
    define('DB_NAME', 'your_cpanel_db_name');     // Change this
    define('SITE_URL', 'https://sportingrank.com'); // Your domain
    ```
4.  **Save the file.**

---

## 📤 Step 4: Upload the Files
Now, put your files on the server so the world can see them.

1.  In cPanel, open **"File Manager"**.
2.  Navigate to the **`public_html`** folder (this is the root of your website).
3.  Click **Upload** at the top.
4.  Upload **all files and folders** from the project folder.
    - *Important: `index.php` should be directly inside `public_html`, not in another subfolder.*
    - Folders to include: `admin/`, `assets/`, `includes/`, `install/`.
    - Files to include: `.htaccess`, `config.php`, `index.php`, `sport.php`, `README.md`.

---

## 🔐 Step 5: Secure the Admin Panel
The website comes with an admin panel at `yourdomain.com/admin`.

1.  The default login is:
    - **Username**: `admin`
    - **Password**: `Admin@1234`
2.  **Change this immediately!**
    - Go to the `admin_users` table in **phpMyAdmin**.
    - Edit the existing row.
    - For the `password_hash`, you need a **Bcrypt** hash. You can generate one using an online tool or the built-in "Manage Settings" page later.

---

## ✅ Step 6: Test Your Site
1.  Visit your domain (e.g., `https://sportingrank.com`).
2.  You should see the rankings and the "Sport Rank" header.
3.  Try searching for a team in the search bar.
4.  Try clicking the "Vote" button.
5.  Go to `/admin` and log in to manage your sports.

---

## ⚠️ Important Security Note
Once the site is live and working, **DELETE the `install/` folder** using cPanel File Manager to prevent anyone from re-running the setup.
