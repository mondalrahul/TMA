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

class FaqController extends Controller
{

  public function faq()
  {
    $data = DB::table('tma_faq')->get();
    return view('others/faq', ['faqs' => $data]);
  }
}

?>