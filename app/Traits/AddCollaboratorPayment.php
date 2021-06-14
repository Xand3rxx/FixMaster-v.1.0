<?php


namespace App\Traits;


use App\Models\CollaboratorsPayment;

trait AddCollaboratorPayment
{
    public static function addCollaboratorPayment($service_request_id=null, $user_id=null, $service_type=null, $flat_rate=null, $actual_labour_cost=null, $actual_material_cost=null, $amount_to_be_paid=null, $amount_after_retention=null, $retention_fee=null, $labour_markup_cost = null,$material_markup_cost = null,$royalty_fee = null, $logistics_cost=null, $tax_fee=null)
    {
        return self::createCollaboratorPayment($service_request_id, $user_id, $service_type, $flat_rate, $actual_labour_cost, $actual_material_cost, $amount_to_be_paid, $amount_after_retention, $retention_fee, $labour_markup_cost, $material_markup_cost, $royalty_fee, $logistics_cost, $tax_fee);
    }

    protected static function createCollaboratorPayment($service_request_id, $user_id, $service_type, $flat_rate, $actual_labour_cost, $actual_material_cost, $amount_to_be_paid, $amount_after_retention, $retention_fee, $labour_markup_cost, $material_markup_cost, $royalty_fee, $logistics_cost, $tax_fee)
    {
        return CollaboratorsPayment::create([
           'service_request_id' => $service_request_id,
           'user_id' => $user_id,
           'service_type' => $service_type,
           'flat_rate' => $flat_rate,
           'actual_labour_cost' => $actual_labour_cost,
           'actual_material_cost' => $actual_material_cost,
           'amount_to_be_paid' => $amount_to_be_paid,
           'amount_after_retention' => $amount_after_retention,
           'retention_fee' => $retention_fee,
           'labour_markup_cost' => $labour_markup_cost,
           'material_markup_cost' => $material_markup_cost,
           'royalty_fee' => $royalty_fee,
           'logistics_cost' => $logistics_cost,
           'tax_fee' => $tax_fee
        ]);
    }
}
