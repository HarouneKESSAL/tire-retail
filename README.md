# E-commerce Platform

This is an e-commerce platform built with Laravel 10, designed to support a range of products with features such as category filtering, product details, search, wishlist, and cart functionalities. This guide will walk you through setting up the project locally.

---

## Requirements

- PHP >= 8.1
- Composer
- MySQL (or any compatible database)

---

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/your-repository.git
   cd your-repository
2. **Install dependencies**:
    - Install PHP dependencies:
      ```bash
      composer install
      ```

3. **Environment Configuration**:
    - Copy the example environment file and set up environment variables:
      ```bash
      cp .env.example .env
      ```
    - Update the following entries in `.env`:
        - **Database settings**:
          ```env
          DB_CONNECTION=mysql
          DB_HOST=127.0.0.1
          DB_PORT=3306
          DB_DATABASE=your_database
          DB_USERNAME=your_username
          DB_PASSWORD=your_password
          ```
        - **Mail settings** (for password reset and notifications):
          ```env
          MAIL_MAILER=smtp
          MAIL_HOST=smtp.mailtrap.io
          MAIL_PORT=2525
          MAIL_USERNAME=your_mailtrap_username
          MAIL_PASSWORD=your_mailtrap_password
          MAIL_ENCRYPTION=null
          ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
    ```
5. **Run Migrations and Seed the Database**:
   This command will set up the database tables and populate sample data.
   ```bash
   php artisan migrate --seed
    ```
