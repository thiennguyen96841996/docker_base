# Guide
|             | URL                                                        | Remarks    |
|-------------|------------------------------------------------------------|------------|
| Customer    | [https://customer.dev.glc](https://customer.dev.glc) |            |
| Client      | [https://client.dev.glc](https://client.dev.glc)     |            |
| Admin       | [https://admin.dev.glc](https://admin.dev.glc)       |            |
| mailcatcher | [http://localhost:1080](http://localhost:1080)             | 疑似メールボックス  |
| minio       | [http://localhost:9001](http://localhost:9001)             | S3互換のストレージ |

# Installation
## 事前準備
### 1. [Homebrew](https://brew.sh/)
Local環境で必要な作業やライブラリを管理するコマンドラインツール。
```shell
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```
### 2. [mkcert](https://github.com/FiloSottile/mkcert)
ローカルを認証局にしたSSL証明書を作成するコマンドラインツール。
```shell
brew install mkcert
mkcert -install
```
### 3. [minio-mc](https://github.com/minio/mc)
S3互換で動作するminioをコマンドから操作する為のコマンドラインツール。
```shell
brew install minio-mc
```
### 4. [Xdebug helper](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc)
xdebug用のChrome拡張機能で、モードによりxdebugの使用を切り替えられるGUIツール。
```
インストール後にオプションから IDE Key を設定する。
(Key: PHPSTORM)
```
### 5. [Docker for mac](https://docs.docker.com/desktop/mac/install/)
MacでDocker環境を構築・管理するGUIツール。  
(docker系のコマンドが合わせて導入できる為、GUIを使わなくても必要になる)
### 6. [PHPStorm](https://www.jetbrains.com/phpstorm/) (推奨)
これ1つでDocker、MySQL、xdebugなど必要な操作がすべてワンストップで出来る。  
(以下の設定手順ではPHPStormを前提としているので他のIDEを使う場合は自身の環境に合わせて確認を)

## 導入手順
### 1. Gitリポジトリのクローン
```shell
git clone https://github.com/ChinIndival/laravel_base
cd laravel_base
```
### 2. SSL証明書を作成
```shell
mkcert -cert-file docker/nginx/files/ssl/_wild.dev.glc.crt.pem \
       -key-file docker/nginx/files/ssl/_wild.dev.glc.key.pem \
       "*.dev.glc"
openssl dhparam 2048 -out docker/nginx/files/ssl/dhparam.pem
```
### 3. Docker用のenvファイルを作成
```shell
cp .env.docker .env
cp src/.env.customer.dev src/.env.customer
cp src/.env.client.dev src/.env.client
cp src/.env.master.dev src/.env.master
```
### 4. Docker環境を構築
```shell
# 起動後もDBに初期データが入るまで少し時間がかかる
docker-compose up --build -d
```
### 5. Docker経由でComposerからライブラリをインストール
```shell
# いずれかのコンテナにインストールすれば環境共通で使用される(共有される)
make composer-install
```
### 6. Laravelのアプリケーションキーを作成 (オプション)
```shell
docker-compose exec php-customer php artisan key:generate --ansi
docker-compose exec php-client php artisan key:generate --ansi
docker-compose exec php-admin php artisan key:generate --ansi
docker-compose exec php-api php artisan key:generate --ansi
```
### 7. hostsを設定
```shell
cat docker/hosts.txt | pbcopy
sudo vim /etc/hosts
```
### 8. minioのバケットを作成
```shell
# ID / PASSWORD は.env.dockerを参照
# Default: ID = minio / PASSWORD = minio_admin
mc alias set glc http://localhost:9000 minio minio_admin --api S3v4
mc mb glc/customer
mc mb glc/client
mc mb glc/admin
```
### 9. マイグレーションの実行
```shell
docker-compose exec php-customer php artisan migrate --database=mysql_migration
```
### 10. 初期データの登録
```shell
docker-compose exec php-customer php artisan db:seed --database=mysql_migration
```
### 11. IDEサポート用ファイルの作成
```shell
make helper-generate
```

# PHPStormの設定 (Appendix)
## Language Level / Interpreter
(Menu: PhpStorm -> Preferences -> PHP)

| 項目                 | 設定値                                         |
|--------------------|---------------------------------------------|
| PHP Language Level | 8.1                                         |
| CLI Interpreter    | docker-composeから作成<br>(PHPコンテナならどれを指定してもOK) |
| Path mappings      | docker-composeと一致していることを確認                  |

参考: [公式ヘルプページ](https://pleiades.io/help/phpstorm/configuring-remote-interpreters.html)

## Code Style
(Menu: PhpStorm -> Preferences -> Editor -> Inspections -> PHP -> Code Style)

| 項目                               | 設定値        |
|----------------------------------|------------|
| Full qualified name usage        | チェックを外す    |
| Unnecessary full qualified name  | チェックを外す    |

(Menu: PhpStorm -> Preferences -> Editor -> Inspections -> PHP -> Attributes)

| 項目                                     | 設定値        |
|----------------------------------------|------------|
| '#[ArrayShape]' attribute can be added | チェックを外す    |
| '#[Pure]' attribute can be added       | チェックを外す    |

※ Docコメントや配列定義などで命名空間まで記載すると出てくる警告を抑止

## MySQL
(Menu: View -> Tool Windows -> Databases -> New(+) -> Data Source -> Mysql)

| 項目             | 設定値                  |
|----------------|----------------------|
| Name           | 任意の名前                |
| Host           | localhost            |
| Port           | 3306                 |
| Authentication | User & Password      |
| User           | root                 |
| Password       | .env.dockerで指定しているもの |
| schemasタブ      | glc               |

(Menu: PhpStorm -> Preferences -> Language & Frameworks -> SQL Dialects)

| 項目                   | 設定値   |
|----------------------|-------|
| Global SQL Dialects  | MySQL |
| Project SQL Dialects | MySQL |

(Menu: PhpStorm -> Preferences -> Language & Frameworks -> SQL Resolution Scopes)

| 項目              | 設定値     |
|-----------------|---------|
| Project mapping | glc  |

## xdebug
(Menu: PhpStorm -> Preferences -> PHP -> Debug -> Xdebug)

| 項目         | 設定値  |
|------------|------|
| Debug port | 9003 |

(Menu: PhpStorm -> Preferences -> PHP -> Servers -> New(+))

| 項目                | 設定値                                                          |
|-------------------|--------------------------------------------------------------|
| Name              | customer.dev.glc<br>client.dev.glc<br>admin.dev.glc |
| Port              | 443                                                          |
| Debugger          | xdebug                                                       |
| Use path mappings | チェックを入れる                                                     |
| /src              | /usr/src/app                                                 |

※ 3サイト分作成する

(Menu: Run -> Edit Configurations -> New(+) -> PHP Remote Debug)

| 項目                      | 設定値                                                          |
|-------------------------|--------------------------------------------------------------|
| Name                    | customer.dev.glc<br>client.dev.glc<br>admin.dev.glc |
| Filter debug connection | チェックを入れる                                                     |
| Server                  | customer.dev.glc<br>client.dev.glc<br>admin.dev.glc |
| IDE Key                 | PHPSTORM                                                     |

※ 3サイト分作成する
