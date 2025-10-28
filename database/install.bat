@echo off
echo ========================================
echo ForumHub Pro - Database Setup Script
echo ========================================
echo.

echo This script will set up the ForumHub database.
echo Make sure MySQL is running in XAMPP!
echo.
pause

echo.
echo Connecting to MySQL...
cd C:\xampp\mysql\bin

echo Creating database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS forumhub_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo Importing schema...
mysql -u root forumhub_mvc < "%~dp0forumhub_mvc.sql"

echo Importing sample data...
mysql -u root forumhub_mvc < "%~dp0sample_data.sql"

echo.
echo ========================================
echo Database setup complete!
echo ========================================
echo.
echo Demo Accounts:
echo - Admin: admin@forumhub.com / password
echo - Moderator: mod@forumhub.com / password
echo - User: user@forumhub.com / password
echo.
echo Access ForumHub at:
echo http://localhost/ForumHub/public
echo.
pause
