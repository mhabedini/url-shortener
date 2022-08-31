# Filimo shortener link creator

## Requirements
- **PHP** > 8.1
- **Composer** > 2

## Installation and Use
1. copy env file and add database information to .env file 
```
cp .env.example .env
```
2. Install composer
```bash
composer i
```

3. Run a php server
```
php -S localhost:8000
```

4. Run database migrations
```
vendor/bin/phinx migrate
```

