<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_statuses')->delete();
        DB::table('statuses')->delete();

        $phasePending = 1;
        $phaseOngoing = 1;

        $status = array(

            array(
                'uuid'          =>  Str::uuid('uuid'),
                'user_id'       =>  1,
                'name'          =>  'Pending',
                'ranking'       =>  1,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),
                'user_id'       =>  1,
                'name'          =>  'Ongoing',
                'ranking'       =>  2,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),
                'user_id'       =>  1,
                'name'          =>  'Cancelled',
                'ranking'       =>  3,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),
                'user_id'       =>  1,
                'name'          =>  'Completed',
                'ranking'       =>  4,
            ),

        );

        $subStatuses = array(
            array(
                'user_id'       =>  1,
                'uuid'          =>  '8e4521a1-3329-4a76-b2fd-a674683002e3',
                'status_id'     =>  1,
                'name'          =>  'Pending',
                'phase'         =>  $phasePending++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '3f8d1494-a53b-4671-8447-10d3ca92b270',
                'status_id'     =>  1,
                'name'          =>  'FixMaster AI assigned a CSE',
                'phase'         =>  $phasePending++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '15f402e8-cb1c-48aa-ac0b-727a24d14c3d',
                'status_id'     =>  1,
                'name'          =>  'FixMaster AI assigned a Franchise as fallback',
                'phase'         =>  $phasePending++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '8ed4b1b6-b83c-4073-bb80-b10810566ad9',
                'status_id'     =>  1,
                'name'          =>  'FixMaster Admin assigned a CSE',
                'phase'         =>  $phasePending++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'dd415ab5-437a-46d5-93b1-84fbd4d67edf',
                'status_id'     =>  1,
                'name'          =>  'Fanchisee assigned a CSE',
                'phase'         =>  $phasePending++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '7337bdd3-2ed9-4a2b-a5bb-b526d86f039b',
                'status_id'     =>  2,
                'name'          =>  'FixMaster Admin assigned a Technician',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '87197a34-61a2-4858-bece-f1e3f0f985c5',
                'status_id'     =>  2,
                'name'          =>  'FixMaster Admin assigned a Quality Assurance',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'cee7aa41-2818-497b-98e2-b850a100741a',
                'status_id'     =>  2,
                'name'          =>  'CSE accepted the job',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            [
                'user_id'       =>  1,
                'uuid'          =>  'ab43a32e-709e-4bf9-bba2-78828d2cfda9',
                'status_id'     =>  2,
                'name'          =>  'CSE added comment',
                'phase'         => $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ],
            [
                'user_id'       =>  1,
                'uuid'          =>  '22821883-fc00-4366-9c29-c7360b7c2efc',
                'status_id'     =>  2,
                'name'          =>  'Scheduled diagnosis date for Client',
                'phase'         => $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ],
            array(
                'user_id'       =>  1,
                'uuid'          =>  'd258667a-1953-4c66-b746-d0c40de7189d',
                'status_id'     =>  2,
                'name'          =>  'Re-Categorize the Service request',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'e59c3305-45ce-4d8e-b5ab-a5f4e9d40aca',
                'status_id'     =>  2,
                'name'          =>  'CSE assigned a Quality Assurance',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),

            array(
                'user_id'       =>  1,
                'uuid'          =>  '1faffcc3-7404-4fad-87a7-97161d3b8546',
                'status_id'     =>  2,
                'name'          =>  'Assigned a Technician',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'eb51cdd5-3c3a-48c9-b011-cc3fd2bc3e25',
                'status_id'     =>  2,
                'name'          =>  'En-route to Client\'s address',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '4909568f-389c-42de-9d13-91453c495813',
                'status_id'     =>  2,
                'name'          =>  'Arrived at Client\'s address',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'e52afda2-8605-4ec9-9682-c11008a434d1',
                'status_id'     =>  2,
                'name'          =>  'Work in progress',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'c6a7481a-182b-410b-adae-0451f3da260b',
                'status_id'     =>  2,
                'name'          =>  'Job completed for the day and it\'s to continue on a scheduled date',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '0b8b6887-7cff-4eca-9cb1-5a5db693332d',
                'status_id'     =>  2,
                'name'          =>  'Job is fully completed',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'b8abbe05-209f-4eeb-8cdb-cef0a354f160',
                'status_id'     =>  2,
                'name'          =>  'Perfoming diagnosis',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'f95c31c6-6667-4a64-bee3-8aa4b5b943d3',
                'status_id'     =>  2,
                'name'          =>  'Completed diagnosis',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '17e3ce54-2089-4ff7-a2c1-7fea407df479',
                'status_id'     =>  2,
                'name'          =>  'Client accepted Diagnosis Invoice',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'c0cce9c8-1fce-47c4-9529-204f403cdb1f',
                'status_id'     =>  2,
                'name'          =>  'Client declined Diagnosis Invoice',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '2c818bc3-3f19-4574-99e7-e4f0db0bca2d',
                'status_id'     =>  2,
                'name'          =>  'Issued Final Invoice to Client',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'b82ea1c6-fc12-46ec-8138-a3ed7626e0a4',
                'status_id'     =>  2,
                'name'          =>  'Client accepted Final Invoice',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '8936191d-03ad-4bfa-9c71-e412ee984497',
                'status_id'     =>  2,
                'name'          =>  'Client declined Final Invoice',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'c615f5ce-fe3b-43f7-9125-d6568eddf1c5',
                'status_id'     =>  2,
                'name'          =>  'A supplier sent an invoice',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '124d3a2d-6efc-4279-a156-438080c33374',
                'status_id'     =>  2,
                'name'          =>  'FixMaster Admin accepted a Supplier\'s invoice',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'e393aff9-016f-48f1-a6bc-44d5e133c290',
                'status_id'     =>  2,
                'name'          =>  'Supplier attached RFQ dispatch code',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            [
                'user_id'       =>  1,
                'uuid'          =>  '73c2b038-4127-4085-a407-f75152a02315',
                'status_id'     =>  2,
                'name'          =>  'CSE accepted RFQ delivered by supplier',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ],
            [
                'user_id'       =>  1,
                'uuid'          =>  '1d3baa2b-25ec-4790-937e-90cc6a625178',
                'status_id'     =>  2,
                'name'          =>  'CSE declined RFQ delivered by supplier',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ],
            array(
                'user_id'       =>  1,
                'uuid'          =>  'b5f67788-4e15-48b8-a97f-6781e8175332',
                'status_id'     =>  2,
                'name'          =>  'Client accepted RFQ delivered by supplier',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'ad5b2b91-db86-4dcb-9ba5-a4e89b6238d5',
                'status_id'     =>  2,
                'name'          =>  'Client declined RFQ delivered by supplier',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '2df4da1e-6c07-402c-a316-0378d37e50a1',
                'status_id'     =>  2,
                'name'          =>  'Issued a new RFQ',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '1abe702c-e6b1-422f-9145-810394f92e1d',
                'status_id'     =>  2,
                'name'          =>  'Issued a new Tool Request',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '70583091-9f95-4f3a-9d57-655e55d471e8',
                'status_id'     =>  2,
                'name'          =>  'Awaiting Supplier\'s feedback on RFQ intiated as part of Final Invoice issued',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'ef8c69e8-5634-4bd0-a7e6-b73a89ae034f',
                'status_id'     =>  2,
                'name'          =>  'Supplier Dispatch: Pending',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'ee55201e-75a3-461a-b174-3a0537ee8e0c',
                'status_id'     =>  2,
                'name'          =>  'Supplier Dispatch: Materials are being Processed',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '6e266cf8-7eeb-49be-86ad-375c7c7416fa',
                'status_id'     =>  2,
                'name'          =>  'Supplier Dispatch: Materials are In-transit',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '3ec28d52-2bd3-446a-985c-3bf622f9f445',
                'status_id'     =>  2,
                'name'          =>  'Supplier Dispatch: Materials have been Delivered',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'bd2ab8b8-9f0b-4b8e-afa9-130c837ecbd1',
                'status_id'     =>  2,
                'name'          =>  'CSE aknowledged Supplier\'s dispatch delivery',
                'phase'         =>  $phaseOngoing++,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),

            array(
                'user_id'       =>  1,
                'uuid'          =>  '06dda2af-3831-41af-854d-595e4f6f6b77',
                'status_id'     =>  3,
                'name'          =>  'Client cancelled job request',
                'phase'         =>  1,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '8aebf411-23ba-4ad0-8890-0918ac239376',
                'status_id'     =>  3,
                'name'          =>  'Admin cancelled job request',
                'phase'         =>  2,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'fca5a961-39d4-42e5-be9d-20e4b579d4b1',
                'status_id'     =>  4,
                'name'          =>  'Client marked job as completed',
                'phase'         =>  1,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'ce316687-62d8-45a9-a1b9-f75da104fc18',
                'status_id'     =>  4,
                'name'          =>  'Admin marked job as completed',
                'phase'         =>  2,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),

        );

        DB::table('statuses')->insert($status);
        DB::table('sub_statuses')->insert($subStatuses);
    }
}
