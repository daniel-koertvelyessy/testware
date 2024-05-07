# testWare

## Content
testWare enables you to manage the testing and maintenance of your location and equipment.

Current version: `1.81.3`

- [Install testWare instance](#install-testware-instance)
- [testWare commands](#testware-commands)


1. [Install testWare instance](#install-testware-instance)
2. [Run the web-installer](#run-the-web-installer)


## Install testWare instance

There are mainly two ways to install your instance of testWare:
- [LAPP / LAMP stack](#lapplamp-stack)
- [Docker](#docker)

### LAPP/LAMP stack
Make sure your server meets following requirements:
- Linux based system (Ubuntu or Debian)
- Apache server (or nginx reverse proxy)
- php min. version 8.2
- SQL database system such as PostgreSQL or MariaDB / mySQL
- Composer installed
- npm installed

#### Step 1: Clone repository

```bash
git clone https://github.com/daniel-koertvelyessy/testware.git
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

**Note:** If you would rather not use the e-mail features, change the key `MAIL_MAILER=smtp` to `MAIL_MAILER=log` and leave the other keys blank.


## Run testWare artisan installer
Within your project folder run the testWare installer [command](#testware-commands).

```php
php artisan testware:install
```

## Docker
Make sure you have docker and docker-compose installed on your host system. All docker based instances have PostreSQL as database service installed.


### docker-compose.yml
Your example for a `docker-compose.yml` file with an external env files:
```
version: "3.1"  #  3.1 is the minimum version

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
    image: postgres:14
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

If this is the first time you run the command, docker-compose will download the necessary docker images and initiate the environment. Depending on your internet connection, this may take a minute or two.
> if you want to see the log output of the docker-compse steps just leave out the `-d` option which stands for `detachted`.

Suppose the service name of the testWare application is `app` you can initiate the internal installation [command](#testware-commands) with:

```bash
docker-compose exec app php artisan testware:install
```

The `testware:install` command will guide you through the setup of the database and first user / employee.

## Run the web-installer
After completing the installation of your testWare instance, you can run the web-based installer at `domain.tld/installer`

The web-installer initiates your company, location, users, and employees. This step is optional as you can achieve these steps within the backend of testWare.

## Start working with testWare
You may start to build your environment with locations and equipment. See [firstSteps.md](firstSteps.md) for help and guidance.

## testWare commands
As soon your instance of testWare is up and running, you have the possibility to run Laravel related commands in the console. Usually, you do not need to worry about this as we got all covered. However, there are some specific commands for your testWare instance available. These commands follow the syntax `php artisan command:task {value} [options]`. Please note that using docker or other containerization deamon you need to prefix the syntax with the respective commands, e.g., for docker-compose the syntax would be `docker-compose exec app php artisan command:task {value} [options]` (provided the service name for testWare in the docker-compose.yml is set to `app`. See the respective [section](#docker-composeyml) for details).

In the following sections the header is the `command:task` command with respective explanations.

---

### testware:install
`required value : `

`options : `

`example : testware:install'`


This command lets you fill the database with initial values.

> W A R N I N G
>
> Use this command only on a fresh system as it will overwrite existing data.
>
> If you have an existing testWare application running please consider to make a backup of your database first.

> Hint: Values surrounded with [] are default ones. You can simply press *enter* to use them.

After issuing a warning in the console you will have to confirm to start the process.

```text
Type [yes] to proceed or [no] to exit without changes. (yes/no) [no]:
``` 

Once confirmed, the process starts, and you can decide to seed the database with default data or leave it empty.

```text
Fill database with default entries [yes] or leave it empty [no] ? (yes/no) [yes]:
``` 

The default data contains:

- user roles (note that this feature is visible but not activated, yet)
- list of EU countries
- 3 Address types (Base, accounting address, delivery address)
- 8 Control time intervals (Year, month, day etc.)
- 3 building types (Office, workshop, storage)
- 4 room types (Office, Assembly, storage room, material storage)
- 2 product states (available, locked)
- 1 product category (none)
- 4 equipment states (available, damaged, repair, locked)
- 3 compartment types (shelf compartment, drawer, storage location)
- 6 document types (manual, function report, test report, drawing, regulation, requirement)

In the next section, you will be able to make a SysAdmin user. You will need this user to login and continue with the installation process on the web browser.
```text
Create new user with SysAdmin privileges? (yes/no) [yes]:
``` 

Set the e-mail address of the user.
```text
E-Mail (used for login):
``` 

The process will ask you to confirm the provided address. This is to prevent a type error which would cause frustration upon first login attempts.
```text
Confirm given e-mail address : my.name@domain.tld (yes/no) [no]:
``` 

Then proceed to add the display name. This will be shown in the upper-right corner of the menubar. Therefore, be mindful of too long names ;)
```text
Username (will be displayed in app):
``` 

Provide the full name of the user
```text
Name:
``` 

Set your language for the testWare menu
```text
 Language [de]:
```

Provide a password. It needs to have a minimum of 8 characters.
```text
 Password (min. 8 charakters):
```

Confirm the password.
```text
Confirm password:
```


The SysAdmin user will be created with the provided credentials. If the SysAdmin user is an employee as well, you can use the already provided Data to create a new employee.
```text
Is this user going to be an employee as well? (yes/no) [no]:
```

An employee dataset requires as a minimum the name. The installer will try to guess the name and set it as default. E.g., if you provided Foo Bar as a name, the default value will be set to Bar.
```text
 Name [Bar]:
```

You may want to fill out the optional data for the employee. You can skip this step and fill out the remaining data in the testWare frontend later.
```text
Is this user going to be an employee as well? (yes/no) [no]:
```

If you choose to the employee data you will be prompted for the following fields.
```text
Surename [default]: 
Birthday (YYYY-MM-DD) : 
Employee ID : 
Employed on (YYYY-MM-DD) : 
Phone-# : 
Mobile-# : 
E-Mail [default value the e-mail already provided] : 
```
The [default] values for *Surename* and *E-Mail* will be taken from the SysAdmin user account credentials.

> Note that these are all optinal fields, you can leave them empty if they do not apply.

After completion, the installer will generate a random key for encryption of the user sessions and a key to cypher external links used in the equipment QR-codes, called *hskey*. You do not need to do anything here.
```text
Generate new encryption keys ...
```
You will find the keys in your `.env` file at the entries `APP_KEY` and `APP_HSKEY`

This is the last step. You can use the system from this point on. If you want to have a guide to create your company and location, you will find a form at `https://domain.tld/installer`
```text
Please use the newly created user to login at https://domain.tld/installer to set your company, location and complete the setup process.
```

---

### testware:hskey
`required value : `

`options : `

`example : testware:hskey`

This command will generate a new value for the hskey which is used as a salt in the generation of a link in the equipment QR-Code.

>
> W A R N I N G
>
> If you have already used the command `testware:install` an entry for the key exists.
> Changing this key will make all printed QR-Codes invalid. Any old link will be denied from the testWare instance.
>

---

### testware:resetuserpw
`required value : {user}`

`options : `

`example : testware:resetuserpw 'user.email.address@domain.tld'`

It might happen, that a password is forgotten / lost to the user. By design, testWare has the *password forgotten* feature deactivated since it requires a smtp server to send out e-mails with a token etc. If you want to activate the process you may want to get in touch with us or view the Laravel documentation for further steps.

The command requires the e-mail address of a registered user to work. The command will terminate with a respective error output if the user could not be found.

Once the user is found, you will be prompted to provide the new password. **Note that your keyboard input is not visible!**

After confirmation with the same password, the selected user will be able to log in with the provided password. All running sessions of the user will be terminated and data might be lost if not saved.

---

### testware:promotesysadmin
`required value : {user}`

`options : `

`example : testware:promotesysadmin 'user.email.address@domain.tld'`

`SysAdmin` is a super-user role which has total control over the testWare application. Usually, such user is set during the installation process. However, a SysAdmin can promote / demote of this user-role. testWare has a built-in feature to prevent a SysAdmin from demotion is no other SysAdmin is found.

If for any reason, there is no user with the SysAdmin role left, you cannot promote on through the web-frontend. To achieve this the command `testware:promotesysadmin` has been implemented as a fallback option.

---

### testware:demotesysadmin
`required value : {user}`

`options : `

`example : testware:demotesysadmin 'user.email.address@domain.tld'`

Similar to promotion, you can also remove the SysAdmin status of a given user.


---

## TO-DO

- [ ] add user management for roles and abilities

- [ ] complete localization

## Contribute

You are welcome to add issues to the repository. Pull request are welcomed 😄

## Support

For support, please issue an e-mail to [testware@bitpack.io](mailto:testware@bitpack.io)

## License

testWare is open-sourced software licensed under the [GLP license](https://opensource.org/licenses/gpl-license).
