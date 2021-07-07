# FixMaster-v.1.0

<img alt="FixMaster Logo" src="https://fixmaster.com.ng/wp-content/uploads/2020/11/fix-master-logo-straight.png">

## About FixMaster

FixMaster is your best trusted one-call solution for a wide range of home maintenance, servicing and repair needs. Our well-trained & certified uniformed technicians are fully insured professionals with robust experience to provide home services to fully meet your needs with singular objective to make you totally relax while your repair requests are professionally handled.


## Fix Master Application Development Procedures

1. CD into the application root directory
2. Run un cp .env.example .env
3. Inside .env file, setup database configurations
4. Run composer install
5. Run php artisan key:generate command
6. Run php artisan migrate:fresh --seed command
7. Run php artisan serve command
8. Define your routes based on the User Role in web.php
9. To run a single migration php artisan migrate --path=/database/migrations/my_migration.php
10. To run single seeder php artisan db:seed --class=ServiceRequestSettingsSeeder

## Fix Master Permission Procedures
Step-by-step instruction on how to create permissions for various actions in a feature will appear here. Thanks.

## Route Procedures
For the purpose of this app going international in a long run, FixMaster has decided to add languages option in this Phase One.

1. Creating your sidebar routes alwasys add app()->getLocale() e.g <a href="{{ route('admin.index', app()->getLocale()) }}" <span>Home</span></a> else the application will throw an error.
2. All users routes should be defined in web.php under the respective User Role prefix.
