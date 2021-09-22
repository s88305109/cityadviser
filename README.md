## 伺服器需求
Laravel 8.58.0 框架有一些系統上的需求。需要確保你的伺服器符合下列要求：

PHP >= 7.3
BCMath PHP Extension
Ctype PHP Extension
Fileinfo PHP Extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension


## 資料庫
Laravel 使得在各種資料庫後端系統進行連接與執行查詢變得非常簡單，無論是使用原始的 SQL、流暢的查詢產生器，或是目前的 Eloquent ORM。目前，Laravel 支援以下四種資料庫系統：

MySQL 5.7+ 
PostgreSQL 9.6+ 
SQLite 3.8.8+
SQL Server 2017+ 


## 設定

應用程式的根目錄下會包含 <b>.env.example</b> 檔案。手動複製並更名為 <b>.env</b> 。

在 <b>.env</b> 中進行資料庫相關設定：<b>DB_HOST、DB_PORT、DB_DATABASE、DB_USERNAME、DB_PASSWORD</b>。

產生APP_KEY，於命令提示字元中，移動到檔案根目錄下執行：
<code>php artisan key:generate</code>

下載必要的相依性元件與模組：
<code>composer install</code>
<code>npm install</code>
<code>npm run dev</code>

執行資料庫Migrate，Laravel將自動建立已定義的資料表：
<code>php artisan migrate</code>

執行資料填充，Laravel將自動插入已定義的資料：
<code>php artisan db:seed</code>


## 附錄

清空Migrate建立的資料表，重新建立結構並執行資料填充Seeder（<strong>※資料庫內容將會清空恢復為預設值</strong>）：
<code>php artisan migrate:fresh --seed</code>
