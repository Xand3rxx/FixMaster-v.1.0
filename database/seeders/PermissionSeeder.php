<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::truncate();
        $manageUser = new Permission();
        $manageUser->name = 'Create New Administrator';
        $manageUser->slug = 'create-admin';
        $manageUser->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Administrator';
        $createTasks->slug = 'view-administrators';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New Franchisee ';
        $createTasks->slug = 'create-franchisee';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Franchisee';
        $createTasks->slug = 'view-franchisee';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New CSE';
        $createTasks->slug = 'create-cse';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View CSE';
        $createTasks->slug = 'view-cse';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New Quality Assurance';
        $createTasks->slug = 'create-qa';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Quality Assurance';
        $createTasks->slug = 'view-qa';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New Technician';
        $createTasks->slug = 'create-technician';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Technicians';
        $createTasks->slug = 'view-technicians';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create New Supplier';
        $createTasks->slug = 'create-supplier';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Suppliers';
        $createTasks->slug = 'view-suppliers';
        $createTasks->save();

        $createTasks = new Permission();
        $createTasks->name = 'View Clients';
        $createTasks->slug = 'view-clients';
        $createTasks->save();
    }
}
