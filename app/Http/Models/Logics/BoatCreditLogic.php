<?php
namespace App\Http\Models\Logics;

 
use App\Http\Traits\LogicDbTrait;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BoatCreditLogic
{
    use LogicDbTrait;
   
   

    /**
     * Get pending/completed status
     * @return \Illuminate\Support\Collection
     */
    public function getAllCredits($filterData)
    {
         
        $query = DB::table('boat_user_credits')->distinct()-> groupby('credit_id') ;
        $from_date = $filterData['from_date'];
        $to_date = $filterData['to_date'];
        if(!empty($from_date) && !empty($to_date)){
            $query->whereBetween('add_date', [date('Y-m-d', strtotime($from_date)),date('Y-m-d', strtotime($to_date))]);

        }
        $result = $query->where('user_id', Auth::id())->orderBy('cid', 'asc')->paginate(10) ;
        
        
        return $result;
    }

     
}
