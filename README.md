#testWare

Current version: 1.0

## Content
<p>testWare enables you manage the testing and maintanace of your location and equipment.</p>

## Installation

### Step 1: Clone repository
```bash
git clone https://testware.hub.bitpack.io/testware.git
```
### Step 2: setup database
testWare requires a MariaDB database enviorment. After installing, you should create a database and super-user and add the data into the .env file
```
DB_CONNECTION=mysql
DB_HOST= [IP-adress-of-your-databse-server]
DB_PORT=3306
DB_DATABASE=[laravel]
DB_USERNAME=[root]
DB_PASSWORD=[passworrd]
```

Then run the migration of the database. 
```bash
php artisan migrate
```

If you want to use our sample data you can add a `--seed` flag.

### Step 3: setup e-mail connection (optional)
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
**Note:**
If you do not want to use the e-mail features change the key `MAIL_MAILER=smtp` to `MAIL_MAILER=log` and leave the other keys blank.

***


## Contribute
Feel free to add issues on the repository. Pull request are welcomed ;)

## Support
For support please issue an e-mail to [testware@bitpack.io](testware@bitpack.io)

## License
testWare is open-sourced software licensed under the [GLP license](https://opensource.org/licenses/gpl-license).
