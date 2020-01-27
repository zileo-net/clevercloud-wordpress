# Deploy WordPress on CleverCloud, the immutable way

[Bedrock](https://roots.io/bedrock/) ([GitHub Project](https://github.com/roots/bedrock)) is a modern WordPress stack that allows to maintain your installation clean from any code change during runtime. [CleverCloud](https://www.clever-cloud.com/) is a rock solid IT automation platform. Now you can take advantages of both to have your [WordPress](https://wordpress.org) installed on it. While you can follow basic steps to install BedRock yourself on CleverCloud, here is a nice shortcut that you can just fork and deploy.

## Requirements

None. Except a CleverCloud account ;-)

## Initial deployment

It will assume your GitHub account is linked to your CleverCloud account. If not, you'll just have to do the same steps but cloning and pushing the project yourself to CleverCloud.

1. Fork this magnificent repository
1. Log in to your CleverCloud console
1. Create a new application, by selecting this project fork, and obviously as a *PHP* one
1. Add one *MySQL database* add-on
1. On next page, edit the environment variables in expert mode and paste one env salts generated [here](https://cdn.roots.io/salts.html). Don't forget to save the changes.
1. Add 3 more variables : `WP_ENV` with value `production` ; `WP_HOME` with value `https://your-domain.tld` ; `WP_SITEURL` with value `https://your-domain.tld/wp`
1. While your app start, create a *Cellar S3 storage* add-on, and link it to your application
1. On the add-on configuration page, create one bucket
1. Go back in your application configuration and add the environment variable `CELLAR_ADDON_BUCKET` with the name of your bucket
1. Apply changes by restarting your application
1. Don't forget to set up your domain name as configured for `WP_HOME` (or one `*.cleverapps.io` for testing purpose)
1. You'll then have access to the installation page of WordPress
1. After installed, go to your plugins home page and active `S3 Uploads`

**Important note :** At this time, your WordPress installation is not capable of sending any emails. Follow  [CleverCloud's documentation](https://www.clever-cloud.com/doc/php/php-apps/#sending-emails) to configure your SMTP server, of activate and configure the `Mailgun` plugin installed by default.

## Installing themes and plugins

Your WordPress installation is now fully managed by _composer_ and [WordPress Packagist](https://wpackagist.org). So to install themes or plugins, you'll have to add them to the `composer.json` file, and commit. The dependencies will be fetched by _composer_ during CleverCloud rebuild of your project.

**Important note :** Pay attention to how you define your [dependencies with composer](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies), being strict, or having them automatically update if needed when it rebuilds. The stricter way would even be to locally `composer update` your project and commit your own `composer.lock` file.

## Keeping WP updated

As for themes and plugins, keeping WordPress updated must be done by the dependencies way. That means you'll have to change the WordPress version in your `composer.json` file and commit. Once restarted, if you are connected as administrator, a page will propose you to do the database update, if any.

## Differences with Bedrock

For those who want or need to go deeper regarding Bedrock, here are the small differences between this fork (based on version __1.12.8__) and a standard Bedrock install.
- You don't need any `.env` file for your environment variables, it can be useful if you want to run your WordPress locally
- `config/application.php` has been modified to directly use MySQL and Cellar environment variables shared by CleverCloud
- Plugin `humanmade/s3-uploads` added by default to use S3 storage for media files
- `web/app/mu-plugins/s3-uploads-filter.php` have been added to use a Cellar endpoint in place of an AWS one
- `.htaccess` have been included by default

Enjoy !
