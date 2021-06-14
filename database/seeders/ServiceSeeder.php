<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\SubService;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ELECTRONICS CATEGORY
        $service2 = new Service();
        $service2->user_id = '1';
        $service2->category_id = '3';
        $service2->name = 'Computer & Laptops';
        $service2->service_charge = 1000;
        $service2->diagnosis_subsequent_hour_charge = 2000;
        $service2->description = 'With FixMaster you don\'t have to run to the repair shop every time your PC ends up with a fault, we have a host of tech support we provide. Maybe you need to upgrade your operating system, or install new software, protect against viruses. We do all that!';
        $service2->image = '19321f87-183c-4d74-8f7d-bdf5355307d3.jpg';
        $service2->save();

        $service2 = new Service();
        $service2->user_id = '1';
        $service2->category_id = '3';
        $service2->name = 'Sound Systems';
        $service2->service_charge = 1000;
        $service2->diagnosis_subsequent_hour_charge = 2000;
        $service2->description = 'With FixMaster you don\'t have to run to the repair shop every time your Sound System ends up with a fault, we have a host of tech support we provide.';
        $service2->image = 'c65c3039-9bff-4d6e-acb0-63b74eaeb899.jpg';
        $service2->save();

        $service2 = new Service();
        $service2->user_id = '1';
        $service2->category_id = '3';
        $service2->name = 'Television';
        $service2->service_charge = 1000;
        $service2->diagnosis_subsequent_hour_charge = 2000;
        $service2->description = 'With FixMaster you don\'t have to run to the repair shop every time your Television ends up with a fault, we have a host of tech support we provide.';
        $service2->image = 'bd5dd85c-0d5c-4563-8e4d-246af964888d.jpg';
        $service2->save();
        

        //ELECTRONICS CATEGORY
        $service5 = new Service();
        $service5->user_id = '1';
        $service5->category_id = '2';
        $service5->name = 'Change-Over Units';
        $service5->service_charge = 1000;
        $service5->diagnosis_subsequent_hour_charge = 2000;
        $service5->description = 'We cover all manner of electrical faults, including electric socket problems, flickering lighting, wiring faults and issues with fuse boxes and consumer units.';
        $service5->image = '55535739-cea5-4e00-8f27-a3aa412b85f0.jpg';
        $service5->save();

        $service5 = new Service();
        $service5->user_id = '1';
        $service5->category_id = '2';
        $service5->name = 'Fuse Boxes';
        $service5->service_charge = 1000;
        $service5->diagnosis_subsequent_hour_charge = 2000;
        $service5->description = 'We cover all manner of electrical faults, including electric socket problems, flickering lighting, wiring faults and issues with fuse boxes and consumer units.';
        $service5->image = '6e1c2d3e-fa1e-4359-bbd3-33e178a2bee1.jpg';
        $service5->save();

        $service5 = new Service();
        $service5->user_id = '1';
        $service5->category_id = '2';
        $service5->name = 'Inverter';
        $service5->service_charge = 1000;
        $service5->diagnosis_subsequent_hour_charge = 2000;
        $service5->description = 'We cover all manner of electrical faults, including electric socket problems, flickering lighting, wiring faults and issues with fuse boxes and consumer units.';
        $service5->image = 'ef232dc9-62e5-4047-ae68-272039a42165.jpg';
        $service5->save();

        $service5 = new Service();
        $service5->user_id = '1';
        $service5->category_id = '2';
        $service5->name = 'Light Fittings';
        $service5->service_charge = 1000;
        $service5->diagnosis_subsequent_hour_charge = 2000;
        $service5->description = 'We cover all manner of electrical faults, including electric socket problems, flickering lighting, wiring faults and issues with fuse boxes and consumer units.';
        $service5->image = '4530c404-1ee7-4f68-8f29-6996ae2ea658.jpg';
        $service5->save();

        $service5 = new Service();
        $service5->user_id = '1';
        $service5->category_id = '2';
        $service5->name = 'Sockets';
        $service5->service_charge = 1000;
        $service5->diagnosis_subsequent_hour_charge = 2000;
        $service5->description = 'We cover all manner of electrical faults, including electric socket problems, flickering lighting, wiring faults and issues with fuse boxes and consumer units.';
        $service5->image = 'd0b3d372-789c-45e6-8c75-69190d7adb8e.jpg';
        $service5->save();

        $service5 = new Service();
        $service5->user_id = '1';
        $service5->category_id = '2';
        $service5->name = 'Wiring Repair';
        $service5->service_charge = 1000;
        $service5->diagnosis_subsequent_hour_charge = 2000;
        $service5->description = 'We cover all manner of electrical faults, including electric socket problems, flickering lighting, wiring faults and issues with fuse boxes and consumer units.';
        $service5->image = 'fd7a398a-4d73-4c80-a9be-6d4d84f6543d.jpg';
        $service5->save();

        
        //REFRIGERATION CATEGORY
        $service6 = new Service();
        $service6->user_id = '1';
        $service6->category_id = '8';
        $service6->name = 'Air Conditioner';
        $service6->service_charge = 1000;
        $service6->diagnosis_subsequent_hour_charge = 2000;
        $service6->description = 'Like any electronic or mechanical device, your fridge will also have problems from time to time. Most of these will have easy fixes, and will be covered under manufacturer or extended warranty.';
        $service6->image = '921e267f-a639-444e-b139-0797dc81075e.jpg';
        $service6->save();

        $service6 = new Service();
        $service6->user_id = '1';
        $service6->category_id = '8';
        $service6->name = 'Freezers';
        $service6->service_charge = 1000;
        $service6->diagnosis_subsequent_hour_charge = 2000;
        $service6->description = 'Like any electronic or mechanical device, your fridge will also have problems from time to time. Most of these will have easy fixes, and will be covered under manufacturer or extended warranty.';
        $service6->image = '7cd4ae44-0175-4b49-942e-02c20d41291d.jpg';
        $service6->save();

        $service6 = new Service();
        $service6->user_id = '1';
        $service6->category_id = '8';
        $service6->name = 'Fridge';
        $service6->service_charge = 1000;
        $service6->diagnosis_subsequent_hour_charge = 2000;
        $service6->description = 'Like any electronic or mechanical device, your fridge will also have problems from time to time. Most of these will have easy fixes, and will be covered under manufacturer or extended warranty.';
        $service6->image = '5ef861b4-4733-4305-bdf1-c8cf6d378f23.jpg';
        $service6->save();


        //HOUSEHOLD APPLIANCES 
        $service3 = new Service();
        $service3->user_id = '1';
        $service3->category_id = '5';
        $service3->name = 'Dish & Washing Machine';
        $service3->service_charge = 1000;
        $service3->diagnosis_subsequent_hour_charge = 2000;
        $service3->description = 'If you\'ve got a leaky fridge, a rattling dryer, a barely cooling HVAC, a stove that no longer sizzles or a clogged dishwasher, we\'ve got you covered.';
        $service3->image = '47e66f4b-e329-40ff-a6ae-7e5b5683dab1.jpg';
        $service3->save();

        $service3 = new Service();
        $service3->user_id = '1';
        $service3->category_id = '5';
        $service3->name = 'Kitchen Blender';
        $service3->service_charge = 1000;
        $service3->diagnosis_subsequent_hour_charge = 2000;
        $service3->description = 'If you\'ve got a leaky fridge, a rattling dryer, a barely cooling HVAC, a stove that no longer sizzles or a clogged dishwasher, we\'ve got you covered.';
        $service3->image = '9770cb74-6f74-4cd7-b37a-b8fc2a23571f.jpg';
        $service3->save();

        $service3 = new Service();
        $service3->user_id = '1';
        $service3->category_id = '5';
        $service3->name = 'Microwave';
        $service3->service_charge = 1000;
        $service3->diagnosis_subsequent_hour_charge = 2000;
        $service3->description = 'If you\'ve got a leaky fridge, a rattling dryer, a barely cooling HVAC, a stove that no longer sizzles or a clogged dishwasher, we\'ve got you covered.';
        $service3->image = '53169517-20d4-42a2-ac43-8b6c42c0580e.jpg';
        $service3->save();

        //LOCKS & SECURITY CATEGORY
        $service7 = new Service();
        $service7->user_id = '1';
        $service7->category_id = '6';
        $service7->name = 'Doors';
        $service7->service_charge = 1000;
        $service7->diagnosis_subsequent_hour_charge = 2000;
        $service7->description = 'Most break-ins start at the front door, they can be easy to kick down and enter through as opposed to a window. FixMaster specialize in installing and repairing different home security products to help prevent your home from becoming a target.';
        $service7->image = 'c94fb945-c54d-42ff-a5da-4d769cbc7e5b.jpg';
        $service7->save();

        $service7 = new Service();
        $service7->user_id = '1';
        $service7->category_id = '6';
        $service7->name = 'Security Equipment';
        $service7->service_charge = 1000;
        $service7->diagnosis_subsequent_hour_charge = 2000;
        $service7->description = 'Most break-ins start at the front door, they can be easy to kick down and enter through as opposed to a window. FixMaster specialize in installing and repairing different home security products to help prevent your home from becoming a target.';
        $service7->image = '1fc759f3-da46-4f06-be2c-040750506c6a.jpg';
        $service7->save();

        $service7 = new Service();
        $service7->user_id = '1';
        $service7->category_id = '6';
        $service7->name = 'Windows';
        $service7->service_charge = 1000;
        $service7->diagnosis_subsequent_hour_charge = 2000;
        $service7->description = 'Most break-ins start at the front door, they can be easy to kick down and enter through as opposed to a window. FixMaster specialize in installing and repairing different home security products to help prevent your home from becoming a target.';
        $service7->image = '417ded2d-4ca0-436b-8adc-e4326e9b703e.jpg';
        $service7->save();


        //INTERIOR DECORATION CATEGORY
        $service8 = new Service();
        $service8->user_id = '1';
        $service8->category_id = '11';
        $service8->name = 'Furniture & Painting';
        $service8->service_charge = 1000;
        $service8->diagnosis_subsequent_hour_charge = 2000;
        $service8->description = 'Be rest assured your interior painting and design project will be done right the first time by our experienced Technicians & Artisans.';
        $service8->image = '2093b73a-ce2a-4648-b500-1378d152efa9.jpg';
        $service8->save();

        $service8 = new Service();
        $service8->user_id = '1';
        $service8->category_id = '11';
        $service8->name = 'Picture & Framing';
        $service8->service_charge = 1000;
        $service8->diagnosis_subsequent_hour_charge = 2000;
        $service8->description = 'Be rest assured your interior painting and design project will be done right the first time by our experienced Technicians & Artisans.';
        $service8->image = '43264dd1-f7ea-4f30-8497-9722559dd2b0.jpg';
        $service8->save();

        $service8 = new Service();
        $service8->user_id = '1';
        $service8->category_id = '11';
        $service8->name = 'Tiling';
        $service8->service_charge = 1000;
        $service8->diagnosis_subsequent_hour_charge = 2000;
        $service8->description = 'Be rest assured your interior painting and design project will be done right the first time by our experienced Technicians & Artisans.';
        $service8->image = 'cd152b83-0aaf-4038-be49-bc602bfdbe73.jpg';
        $service8->save();
        

        //MECHANICAL CATEGORY
        $service9 = new Service();
        $service9->user_id = '1';
        $service9->category_id = '10';
        $service9->name = 'Generator';
        $service9->service_charge = 1000;
        $service9->diagnosis_subsequent_hour_charge = 2000;
        $service9->description = 'Our Technicians can help identify your issues and repair them as needed.';
        $service9->image = 'dd8a9ad9-dc12-411d-b148-ab33ff1f5127.jpg';
        $service9->save();
        
        $service9 = new Service();
        $service9->user_id = '1';
        $service9->category_id = '10';
        $service9->name = 'Pumps';
        $service9->service_charge = 1000;
        $service9->diagnosis_subsequent_hour_charge = 2000;
        $service9->description = 'Our Technicians can help identify your issues and repair them as needed.';
        $service9->image = '986e8901-c224-4ddf-96ef-6eb5870b3f95.jpg';
        $service9->save();


        //COMMUNICATION CATEGORY
        $service10 = new Service();
        $service10->user_id = '1';
        $service10->category_id = '9';
        $service10->name = 'Mobile Phones';
        $service10->service_charge = 1000;
        $service10->diagnosis_subsequent_hour_charge = 2000;
        $service10->description = 'Our Professionals can help you fix broken screens and other outside parts, troubleshooting, software issues etc.';
        $service10->image = 'dbd5ebd9-f33d-424d-96f1-b6b2521c445b.jpg';
        $service10->save();


        //PLUMBING CATEGORY
        $service1 = new Service();
        $service1->user_id = '1';
        $service1->category_id = '7';
        $service1->name = 'Bath-Tubs, Pipes, Kitchen Sink';
        $service1->service_charge = 1000;
        $service1->diagnosis_subsequent_hour_charge = 2000;
        $service1->description = 'We can fix all plumbing job types. Fix it right with an expert plumber. You Can Count On! All works are carried out promptly.';
        $service1->image = 'a99928b3-a89a-4596-9f09-92f03c410de2.jpg';
        $service1->save();

        $service4 = new Service();
        $service4->user_id = '1';
        $service4->category_id = '7';
        $service4->name = 'Drainage, Shower, Soak-Away';
        $service4->service_charge = 1000;
        $service4->diagnosis_subsequent_hour_charge = 2000;
        $service4->description = 'We can fix all plumbing job types. Fix it right with an expert plumber. You Can Count On! All works are carried out promptly.';
        $service4->image = '7cf740ad-902e-463d-9d9f-5fe3a73f5ae5.jpg';
        $service4->save();

        $service4 = new Service();
        $service4->user_id = '1';
        $service4->category_id = '7';
        $service4->name = 'Taps, Toilets, WashHand Basins';
        $service4->service_charge = 1000;
        $service4->diagnosis_subsequent_hour_charge = 2000;
        $service4->description = 'We can fix all plumbing job types. Fix it right with an expert plumber. You Can Count On! All works are carried out promptly.';
        $service4->image = '75874a9b-6003-4108-b7f7-9acd07589421.jpg';
        $service4->save();


        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '1';
        $subService->name = 'Monitor & Screens';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '1';
        $subService->name = 'Motherboard';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '1';
        $subService->name = 'Keyboard & Other Peripherals';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '2';
        $subService->name = 'Speaker';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '2';
        $subService->name = 'Disk Changer';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '2';
        $subService->name = 'Input/Ouput Connector';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '3';
        $subService->name = 'LED Tube';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '10';
        $subService->name = 'Gas Change';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '10';
        $subService->name = 'General Maintenance';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '25';
        $subService->name = 'Heating Element';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '25';
        $subService->name = 'Door Latch';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '25';
        $subService->name = 'Third-Level Rack';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

        $subService = new SubService();
        $subService->user_id = '1';
        $subService->service_id = '25';
        $subService->name = 'Tap';
        $subService->labour_cost = 500;
        $subService->cost_type = 'Fixed';
        $subService->save();

    }
}
