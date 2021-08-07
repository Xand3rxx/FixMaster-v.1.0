<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Super Admin';
        $manager->slug = 'super-admin';
        $manager->url = 'admin';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Administrator';
        $developer->slug = 'admin-user';
        $developer->url = 'admin';
        $developer->save();

        $developer = new Role();
        $developer->name = 'Franchisee(CSE Coordinator)';
        $developer->slug = 'franchisee-user';
        $developer->url = 'franchisee';
        $developer->save();

        $developer = new Role();
        $developer->name = 'Customer Service Executive';
        $developer->slug = 'cse-user';
        $developer->url = 'cse';
        $developer->save();

        $manager = new Role();
        $manager->name = 'Technicians & Artisans';
        $manager->slug = 'technician-artisans';
        $manager->url = 'technician';
        $manager->save();

        $manager = new Role();
        $manager->name = 'Suppliers';
        $manager->slug = 'supplier-user';
        $manager->url = 'supplier';
        $manager->save();

        $manager = new Role();
        $manager->name = 'Ordinary Clients';
        $manager->slug = 'client-user';
        $manager->url = 'client';
        $manager->save();

        $manager = new Role();
        $manager->name = 'Quality Assurance Manager';
        $manager->slug = 'quality-assurance-user';
        $manager->url = 'quality-assurance';
        $manager->save();
    }
}
