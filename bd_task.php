<?php
$host = 'localhost';
$port = '5432';
$dbname = 'store_bd';
$user = 'postgres';
$password = '1365244';

$connection_str = "host=$host port=$port dbname=$dbname user=$user password=$password";
$connection = pg_connect($connection_str);
if (!$connection) {
    die("Ошибка подключения к базе данных: " . pg_last_error());
}
echo "Подключение успешно установлено \n";

///создание таблицы
$query = " CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) UNIQUE NOT NULL,
    price DECIMAL(6, 2) NOT NULL,
    quantity INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
$result = pg_query($connection, $query);
if(!$result){
        echo "Ошибка создания таблицы" . pg_last_error();;
    } else {
        echo "Таблица успешно создана \n";
    }
///1 product
$name1 = "product1"; $price1 = 35.15; $quantity1 = 8;
$ctrlv = "INSERT INTO products (name, price, quantity) VALUES ($1, $2, $3) 
ON CONFLICT (name) DO UPDATE SET price = EXCLUDED.price, quantity = EXCLUDED.quantity";;
$params = [$name1, $price1, $quantity1];
$result = pg_query_params($connection, $ctrlv, $params);
///2 product
$name2 = "product2"; $price2 = 1235.2; $quantity2 = 13;
$ctrlv = "INSERT INTO products (name, price, quantity) VALUES ($1, $2, $3) 
ON CONFLICT (name) DO UPDATE SET price = EXCLUDED.price, quantity = EXCLUDED.quantity";;
$params = [$name2, $price2, $quantity2];
$result = pg_query_params($connection, $ctrlv, $params);
///3 product
$name3 = "product3"; $price3 = 12.58; $quantity3 = 63;
$ctrlv = "INSERT INTO products (name, price, quantity) VALUES ($1, $2, $3) 
ON CONFLICT (name) DO UPDATE SET price = EXCLUDED.price, quantity = EXCLUDED.quantity";;
$params = [$name3, $price3, $quantity3];
$result = pg_query_params($connection, $ctrlv, $params);
///4 product
$name4 = "product4"; $price4 = 653.18; $quantity4 = 27;
$ctrlv = "INSERT INTO products (name, price, quantity) VALUES ($1, $2, $3) 
ON CONFLICT (name) DO UPDATE SET price = EXCLUDED.price, quantity = EXCLUDED.quantity";;
$params = [$name4, $price4, $quantity4];
$result = pg_query_params($connection, $ctrlv, $params);
///5 product
$name5 = "product5"; $price5 = 777.38; $quantity5 = 9;
$ctrlv = "INSERT INTO products (name, price, quantity) VALUES ($1, $2, $3) 
ON CONFLICT (name) DO UPDATE SET price = EXCLUDED.price, quantity = EXCLUDED.quantity";;
$params = [$name5, $price5, $quantity5];
$result = pg_query_params($connection, $ctrlv, $params);
///отображение товаров
$products = "SELECT * FROM products ORDER BY id";
$result = pg_query($connection, $products);
if(!$result){
    die("Ошибка выполнения запроса");
}
while($row = pg_fetch_assoc($result)){
    echo "id: " . $row['id'] . "\n";
    echo "name: " . $row['name'] . "\n";
    echo "price: " . $row['price'] . "\n";
    echo "quantity: " . $row['quantity'] . "\n";
    echo "created_at: " . $row['created_at'] . "\n";
    echo "\n";
}
pg_free_result($result);
///поиск по названию
$search = $name4;
$stmt = "SELECT * FROM products WHERE name = $1";
$result = pg_query_params($connection, $stmt, [$search]);
if(!$result){
    die("Ошибка выполнения запроса");
}
echo "Результтат поиска";
while($row = pg_fetch_assoc($result)){
    echo "id: " . $row['id'] . "\n";
    echo "name: " . $row['name'] . "\n";
    echo "price: " . $row['price'] . "\n";
    echo "quantity: " . $row['quantity'] . "\n";
    echo "created_at: " . $row['created_at'] . "\n";
    echo "\n";
}
pg_free_result($result);
pg_close($connection);
?>