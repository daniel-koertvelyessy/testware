# testWare

Current version: 1.41

## Content
testWare enables you manage the testing and maintanace of your location and equipment. To get started you need two steps:

1. [Install testWare instance](#install-testware-instance)
2. [Run the web-installer](#run-the-web-installer)


## Install testWare instance

There are mainly two ways to install your instance of testWare:
- [LAPP /LAMP stack](#lapplamp-stack-lappstack)
- [Docker](#docker-docker) 

### LAPP/LAMP stack
Make sure your server meets following requirements:
- Linux based system (Ubuntu or Debian)
- Apache server (or nginx reverse proxy)
- php min. version 7.3
- SQL database system such as PostgreSQL or MariaDB / mySQL
- Composer installed
- npm installed

#### Step 1: Clone repository

```bash
git clone https://testware.hub.bitpack.io/testware.git
```

#### Step 2: setup database

After installing your desired system, you should create a database and super-user and add the data into the .env file

```
DB_CONNECTION=pgsql
DB_HOST= [IP-adress-of-your-databse-server]
DB_PORT=5432
DB_DATABASE=[laravel]
DB_USERNAME=[root]
DB_PASSWORD=[passworrd]
```

#### Optional step 3: setup e-mail connection (optional)

```
MAIL_MAILER=smtp
MAIL_HOST=[smpt.provider-address.com]
MAIL_PORT=[587]
MAIL_USERNAME=[username]
MAIL_PASSWORD=[password]
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=[yourmail@address.com]
MAIL_FROM_NAME="${APP_NAME}"
```

**Note:** If you do not want to use the e-mail features change the key `MAIL_MAILER=smtp` to `MAIL_MAILER=log` and leave the other keys blank.


## Run testware artisan installer
Within your project folder run the testWare installer command.

```php
php artisan testware:install
```

## Docker
Make sure you have docker and docker-compose installed on your host system. All docker based instances have PostreSQL as database service installed.
Using docker requires to 

### docker-compose.yml
Your example for a `docker-compose.yml` file with an external env files:
```
version: "3.1"

services:
  app:
    image: bitpackio/testware
    restart: always
    container_name: testware-app
    env_file:
      - app.env
    ports:
      - 80:80
      - 443:443
    volumes:
      - testware-files:/var/www/html/storage/app
    depends_on:
      - db

  db:
    image: postgres:11
    restart: always
    env_file:
      - db.env
    ports:
      - 5432:5432
    container_name: testware-db
    working_dir: /data/pgsql
    volumes:
      - testware-db-data:/var/lib/postgresql/data

volumes:
  testware-files:
  testware-db-data:
```

Example for the `app.env` file
```
# Set testware enviorment
APP_URL="http://domain.tld"
APP_PORT=80
APP_DEBUG=false

# setup mail server
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=mailtrapUseName
MAIL_PASSWORD=mailtrapPassWOrd
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your.email@domain.tld"
MAIL_FROM_NAME="NAME"

#Connect Database
DB_HOST=db
DB_PORT=5432
DB_DATABASE=testware
DB_USERNAME=testWareDbUser
DB_PASSWORD=yourMostSecurePasswordYouCanThinkOf

# # # # # # # # # # # # # # # # # # # # # # # 
#   IMPORTANT                               #
#   Make sure that the DB credentials are   #
#   the same as specified in the db.env     #
# # # # # # # # # # # # # # # # # # # # # # # 
```

Example for the `db.env` file
```
#Connect Database
POSTGRES_DB=testware
POSTGRES_USER=testWareDbUser
POSTGRES_PASSWORD=yourMostSecurePasswordYouCanThinkOf

# # # # # # # # # # # # # # # # # # # # # # # 
#   IMPORTANT                               #
#   Make sure that the DB credentials are   #
#   the same as specified in the app.env    #
# # # # # # # # # # # # # # # # # # # # # # # 
```

Start the docker containers use the following command `docker-compose up -d`

If this is the first time you run the command, docker-compose will download the necessary docker images and initiate the enviorment. Depending on your internet connection this may take a minute or two. 
> if you want to see the log output of the docker-compse steps just leave out the `-d` option which stands for `detachted`.
 
Suppose the container name of the app is `testware-app` you can initiate the internal installation command with:

```bash
docker-compose exec testware-app php artisan testware:install
```

The `testware:install` command will guide you through the setup of the database and first user / employee. 

## Run the web-installer
After completing the installation of your testWare instance you can run the web based installer at `domain.tld/installer`  

The web-installer initiates your company, location, users and employees. This step is optional as you can achieve these steps within the backend of testWare.

## Start working with testWare
You may start to build your enviorment with locations and equipment. See [firstSteps.md](firstSteps.md) for help and guidances.

---

## TO-DO

- [ ] add user management for roles and abilities

- [ ] complete localization

## Contribute

Feel free to add issues on the repository. Pull request are welcomed 😄

## Support

For support please issue an e-mail to [testware@bitpack.io](mailto:testware@bitpack.io)

## License

testWare is open-sourced software licensed under the [GLP license](https://opensource.org/licenses/gpl-license).
