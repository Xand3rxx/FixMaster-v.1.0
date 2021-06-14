<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;
use App\Models\ClientDiscount;
use App\Models\ServiceDiscount;
use Carbon\Carbon;

class DiscountUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all discount duration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today =Carbon::today()->addDays(1);
        $discounts = Discount::select('uuid', 'entity')->where('status', 'activate')->whereDate('duration_end', '=', $today )->get();
     
        foreach ($discounts  as $discount) {
       Discount::where(['uuid'=>$discount->uuid])->update([
        'status' => 'deactivate',
       
         ]); 
       ClientDiscount::where([ 'discount_id'=>$discount->uuid])->delete();
   
       
        }
        $this->info('Discount Update has been send successfully');
    }
}
