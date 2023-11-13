# CommonPHPCurd Package

This package provides common PHP functions for CRUD (Create, Read, Update, Delete) operations.

## Installation

Install the package using Composer:

```bash
composer require darwins/common-php-curd

cp .env.example .env

#Ensure that Composer's autoloader is included in your project:

require_once 'vendor/autoload.php';

## Usage

#Include Composer's autoloader
require_once 'vendor/autoload.php';

# Use classes from the package
use DarwinS\CommonPHPCurd\YourClassFromCommonFunctions;

#Your code here
$instance = new YourClassFromCommonFunctions();


