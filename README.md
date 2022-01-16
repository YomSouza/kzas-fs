## Test Full Stack Developer

#### Demo

https://kzas-fs.herokuapp.com/

Login
```
email cto@email.com
password: password
```

## Getting Started

### 1 - Clone
```
git clone https://github.com/YomSouza/kzas-fs.git kzas-fs
```

```
cd kzas-fs
```

### 2 - Install dependencies
```
composer install
```

```
npm install
```

### 3 - Generate application key
```
php artisan key:generate
```

### 4 - Create your DB and set config in the .env
Config example:
```
DB_CONNECTION=pgsql
DB_URL=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5 - Run the migrations and seed
```
php artisan migrate --seed
```

### 6 - Run application
```
php artisan serve
```

```
npm run hot
```

## Technologies

- **[Laravel](https://laravel.com/)**
- **[Vue](https://vuejs.org/)**
- **[Inertia](https://inertiajs.com/)**
