# Meezan Bank ATM Backend - PHP Tutorial

This project demonstrates the backend (PHP) part of the ATM analogy, where PHP acts as the "Bank Manager" controlling the "Vault" (database).

## Files
- `atm_backend.php`: The main PHP script that handles authentication and transactions.
- `atm_frontend.html`: A simple HTML frontend simulating the ATM interface.
- `README.md`: This file.

## Setup
1. Install PHP on your Windows system.
   - Download from https://windows.php.net/download/
   - Choose the latest non-thread safe (NTS) version for your architecture (x64).
   - Extract to a folder, e.g., `C:\php`
   - Add `C:\php` to your PATH environment variable.

2. Verify installation: Open command prompt and run `php --version`

## Running the Project
1. Start the backend server: `php -S localhost:8000 atm_backend.php`
2. Open `atm_frontend.html` in your browser (double-click or open with browser).
3. Use the form to test transactions.

## Testing Accounts
- Account: 1234 (PIN: 5678)  Initial Balance: 10000

- Account: 5678 (PIN: 1234) Initial Balance: 5000


## Analogy Reminder
- **Frontend (ATM machine)**: `atm_frontend.html` - The plastic shell, user interface, sends requests to backend.
- **Backend (Bank Manager & Vault)**: `atm_backend.php` - Handles logic, database, security - runs on server, hidden from user.