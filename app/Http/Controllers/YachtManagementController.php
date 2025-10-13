<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\HomeController;
use App\Http\Helpers\ConvertCurrency;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class YachtManagementController extends Controller
{

  public function trident_experience()
  {
    $data = DB::table('tma_yacht_management')->first();
    return view('others/yachtmanagement', ['yachtmanagement' => $data]);
  }
}

?>