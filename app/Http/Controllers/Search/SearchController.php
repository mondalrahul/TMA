<?php

namespace App\Http\Controllers\Search;

use App\Boat;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\HomeController;
use App\Http\Helpers\ConvertCurrency;
use App\Http\Models\Logics;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    const LIMIT_PER_PAGE = 12;
    const BOAT_TYPE_SEARCH = [
        1 => 'Monohull',
        2 => 'Catamaran',
        3 => 'Super Yachts'
    ];
    const PRIORITY_SEARCH = [
        'ASC' => 'Ascending',
        'DESC' => 'Descending'
    ];
    const ITEM_DISPLAY_SEARCH = [
        '12' => 12,
        '15' => 15,
        '18' => 18,
        '21' => 21
    ];
    const PAYPAL_FEE = '3';

    const PATTERN_DATE_PICKED = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';

    const SEA_SPORTS = [
        'book_thrill' => 750,
        'book_chill' => 700,
        'book_fun' => 1200,
        'book_jetsurf' => 950,
        'book_jetski' => 450
    ];

    /**
     * Search for trident fleet
     *
     * @author vduong daiduongptit090@gmail.com
     */
    public function search($boatType, Request $request)
    {
        $dataSearch = $request->all();
        if (empty($boatType)) {
            return redirect()->route('home');
        }
        // Check boat type
        $boatCatTmaList = DB::table('boat_tbl_category_tma')->get();
        $boatCatTmaList = collect($boatCatTmaList)->toArray();
        $boatTypeId = null;
        foreach ($boatCatTmaList as $item) {
            $item = collect($item)->toArray();
            if ($boatType == $item['category_name']) {
                $boatTypeId = $item['category_id'];
                break;
            }
        }

        if (empty($boatTypeId)) {
            $boatTypeId = $boatCatTmaList[0]['categoryId'];
        }
        // Create logic
        $boatLogic = new Boat();

        // info search
        $limit = (isset($dataSearch['item_display_search']) && array_key_exists($dataSearch['item_display_search'], self::ITEM_DISPLAY_SEARCH)) ? $dataSearch['item_display_search'] : self::LIMIT_PER_PAGE;
        $country = (isset($dataSearch['country_search']) && in_array($dataSearch['country_search'], HomeController::COUNTRY_SEARCH)) ? $dataSearch['country_search'] : '';
        $priceOrder = (isset($dataSearch['price_search']) && array_key_exists($dataSearch['price_search'], HomeController::PRICE_SEARCH)) ? $dataSearch['price_search'] : 'asc';

        // Search base on country
        if (!empty($country)) {
            $country_qr = " AND bo.country = '" . $country . "'";
        } else {
            $country_qr = " ";
        }

        if ($priceOrder === "nasc") {
            $order_by = " ORDER BY bo.boat_type_tma ASC";
        } else {
            if ($priceOrder === 'asc') {
                $order_by = " ORDER BY btp.boatPrice ASC";
            } else {
                $order_by = " ORDER BY btp.boatPrice DESC";
            }
        }

        $query = DB::select("SELECT bo.*, btp.currency, btp.boatPrice, boat_tbl_category_tma.category_name
        FROM boat_tbl_boat bo LEFT JOIN (SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price, 0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW() GROUP BY btp.boat_id, btp.currency) AS btp ON btp.boatId = bo.boat_id INNER JOIN boat_tbl_category_tma ON boat_tbl_category_tma.category_id = bo.boat_type_tma WHERE bo.boat_type_tma = " . $boatTypeId . " AND bo.status = 'y'" . $country_qr . $order_by);

        $boats = json_decode(json_encode($query), true);

        usort($boats, function ($a, $b) {
            if ($a['boat_id'] == 625) return -1;
            if ($b['boat_id'] == 625) return 1;

            if ($a['boat_id'] == 633) return -1;
            if ($b['boat_id'] == 633) return 1;

            if ($a['boat_id'] == 673) return -1;
            if ($b['boat_id'] == 673) return 1;

            // Keep other items as they are
            return 0;
        });

        // dd($boats);

        if ($country) {
            // Get marinas country, when country not empty
            $marinasIds = DB::table('boat_marinas')
                ->select('marinas_id')
                ->where('country', '=', $country)
                ->get();

            $marinasIds = json_decode(json_encode($marinasIds), true);

            foreach ($marinasIds as $key => $item) {
                $marinasIds[$key] = $marinasIds[$key]['marinas_id'];
            }

            // Get all boat base on marinas ids
            // $boatBaseOnMarinasList = $boatLogic->getAllBoatTypeSameMarinas($boatTypeId, $marinasIds, $priceOrder);
            if ($priceOrder === 'asc') {
                $order = " ORDER BY btp.boatPrice ASC";
            } else {
                $order = " ORDER BY btp.boatPrice DESC";
            }
            $boatBaseOnMarinasList = DB::select("SELECT bo.*, btp.currency, btp.boatPrice, boat_tbl_category_tma.category_name FROM boat_tbl_boat bo LEFT JOIN (SELECT btp.boat_id AS boatId, btp.currency AS currency, MIN(NULLIF(btp.price, 0)) AS boatPrice FROM boat_time_price btp INNER JOIN boat_tbl_boat bo ON btp.boat_id = bo.boat_id AND btp.date_for >= NOW() GROUP BY btp.boat_id, btp.currency) AS btp ON btp.boatId = bo.boat_id INNER JOIN boat_tbl_category_tma ON boat_tbl_category_tma.category_id = bo.boat_type_tma
            WHERE bo.boat_type_tma = " . $boatTypeId . " AND bo.marina IN (" . trim(json_encode($marinasIds), "[]") . ") AND bo.status = 'y'" . $order);
            $boatBaseOnMarinasList = json_decode(json_encode($boatBaseOnMarinasList), true);
            // dd($boatBaseOnMarinasList);

            if (!empty($boatBaseOnMarinasList)) {
                $boatsFilter = [];
                $boatMarinasFilter = [];
                foreach ($boats as $item) {
                    $boatsFilter[$item['boat_id']] = $item;
                }
                foreach ($boatBaseOnMarinasList as $item) {
                    $boatMarinasFilter[$item['boat_id']] = $item;
                    $boatMarinasFilter[$item['boat_id']]['country'] = $country;
                }

                $boats = $boatsFilter + $boatMarinasFilter;
                if ($priceOrder === 'asc') {
                    // dd($boats);
                    usort($boats, [$this, 'sortBoatPriceAsc']);
                } else {
                    usort($boats, [$this, 'sortBoatPriceDesc']);
                }
            }
        }


        // sort get boat singapore first when get all
        if ($country === '') {
            $boats = $this->sortBoatSingaporeFirst($boats, $priceOrder);
        }

        // check boats is empty
        if (count($boats) === 0) {
            $data = [
                'country_search' => [
                    'select' => $country,
                    'list' => HomeController::COUNTRY_SEARCH
                ],
                'price_search' => [
                    'select' => $priceOrder,
                    'list' => HomeController::PRICE_SEARCH
                ],
                'item_display_search' => [
                    'select' => (string) $limit,
                    'list' => self::ITEM_DISPLAY_SEARCH
                ],
                'dataDisplay' => ''
            ];
            return view('search.tridentfleet', ['data' => ['no_result' => true, 'input_search' => $data, 'boat_type' => $boatType]]);
        }
        $pathPagination = '/trident-fleet/' . $boatType . '/';
        if (isset($dataSearch['country_search'])) {
            $pathPagination = '/trident-fleet/' . $boatType . '?country_search=' . $country . '&price_search=' . $priceOrder . '&item_display_search=' . $limit;
        }
        $dataPerPage = $this->paginate($boats, $limit)->setPath($pathPagination);

        $sgdRatePath = config_path('SGDRates.json');
        $convertCurrency = new ConvertCurrency($sgdRatePath);
        $dataTemp = [];
        $dataFilter = [];

        // Get currency unit
        $currencyUnit = '';
        // $countryLogic = new Logics\BoatCountryLogic();
        // $boatMarinasLogic = new Logics\BoatMarinasLogic();
        if ($country) {
            // Get currency unit
            $countryDetail = $this->getDetailCountry($country);
            // $countryDetail = DB::table('boat_country')->where('name', $country)->get()->toArray();
            // $countryDetail = json_decode(json_encode($countryDetail), true);
            $currencyUnit = $this->getCurrencyUnit($countryDetail[0]['uc']);
        }

        // dd($dataPerPage);

        foreach ($dataPerPage as $key => $item) {
            $dataFilter[$key] = $item;
            // dd($item);
            $item['currency'] = 0;
            // Get currency unit
            if (!$item['currency']) {
                if (!$country) {
                    if ($item['country']) {
                        $countryDetail = $this->getDetailCountry($item['country']);
                    } else {
                        $countryName = $this->getMarinasCountry($item['marina']);
                        $countryDetail = $this->getDetailCountry($countryName);
                    }
                    // empty get by marina
                    if (empty($countryDetail)) {
                        $countryName = $this->getMarinasCountry($item['marina']);
                        $countryDetail = $this->getDetailCountry($countryName);
                    }
                    // still empty set default
                    if (empty($countryDetail)) {
                        $dataFilter[$key]['currency'] = 'SGD';
                    } else {
                        $dataFilter[$key]['currency'] = $this->getCurrencyUnit($countryDetail[0]['uc']);
                    }
                } else {
                    $dataFilter[$key]['currency'] = $currencyUnit;
                }
            }
            // $dataFilter[$key]['MarinaName'] = $boatMarinasLogic->getMarinasNameByID($item['marina'])->marinas_name;
            $dataFilter[$key]['MarinaName'] = $this->getMarinasNameByID($item['marina'])->marinas_name;
            $boatLogic = new Boat();
            $facilities = $boatLogic->facilities($item['boat_id']);
            $dataFilter[$key]['facilities'] = $facilities;

            $item['boatPrice'] = null;
            if (!array_key_exists($item['boat_id'], $dataTemp)) {
                // check price valid
                if (!$item['boatPrice']) {
                    $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => 0];
                    continue;
                }
                // check type currency
                if ($dataFilter[$key]['currency'] == 'SGD') {
                    // $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => $item['boatPrice']];

                    /* -------------------- Above section remove 01.04.2022--- for price mismatch -----*/
                    continue;
                }
                // convert to sgd
                $covertedCurrency = ($convertCurrency->convertToSGD($item['boatPrice'], $item['currency'])) ? $convertCurrency->convertToSGD($item['boatPrice'], $item['currency']) : 0;
                $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => $covertedCurrency];
            } else {
                // converted currency smaller
                $covertedCurrency = $convertCurrency->convertToSGD($item['boatPrice'], $item['currency']);
                if ($covertedCurrency < $dataTemp[$item['boat_id']]['price']) {
                    unset($dataFilter[$dataTemp[$item['boat_id']]['key']]);
                    $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => $covertedCurrency];
                } else {
                    unset($dataFilter[$key]);
                }
            }
        }

        //  echo '<pre>'.print_r( count($dataFilter )  , true).'</pre>';
        $data = [
            'country_search' => [
                'select' => $country,
                'list' => HomeController::COUNTRY_SEARCH
            ],
            'price_search' => [
                'select' => $priceOrder,
                'list' => HomeController::PRICE_SEARCH
            ],
            'item_display_search' => [
                'select' => (string) $limit,
                'list' => self::ITEM_DISPLAY_SEARCH
            ],
            'dataPerPage' => $dataPerPage,
            'dataDisplay' => $dataFilter,
            'boat_type' => $boatType
        ];

        // $data = json_decode(json_encode($data), true);
        // dd($data);
        return view('search.tridentfleet', ['data' => $data]);
    }

    /**
     * Search for home page
     *
     * @author vduong daiduongptit090@gmail.com
     */
    public function searchProductHome(Request $request)
    {
        // dd($request->all());
        $dataSearchList = $request->all();
        // Create logic
        $boatLogic = new Boat();

        $dataSearch = [
            'people_number' => (isset($dataSearchList['people_number'])) ? $dataSearchList['people_number'] : null,
            'occasion' => (isset($dataSearchList['occasion'])) ? $dataSearchList['occasion'] : null,
            'boat_type' => (isset($dataSearchList['boat_type'])) ? $dataSearchList['boat_type'] : null,
            'country' => (isset($dataSearchList['country'])) ? $dataSearchList['country'] : '',
            'price' => (isset($dataSearchList['price'])) ? $dataSearchList['price'] : 'asc',
            'item_display_search' => (isset($dataSearchList['item_display_search']) && array_key_exists($dataSearchList['item_display_search'], self::ITEM_DISPLAY_SEARCH)) ? $dataSearchList['item_display_search'] : self::LIMIT_PER_PAGE
        ];

        // info search
        $limit = $dataSearch['item_display_search'];
        $noOfPeopleSearch = (array_key_exists($dataSearch['people_number'], HomeController::NUMBER_USER_SEARCH)) ? $dataSearch['people_number'] : 'Show All';
        $occasionSearch = (array_key_exists($dataSearch['occasion'], HomeController::OCCASION_SEARCH)) ? $dataSearch['occasion'] : 'Show All';
        $boatTypeSearch = (array_key_exists($dataSearch['boat_type'], HomeController::BOAT_TYPE_SEARCH)) ? $dataSearch['boat_type'] : 'Show All';
        $countrySearch = (in_array($dataSearch['country'], HomeController::COUNTRY_SEARCH)) ? $dataSearch['country'] : '';
        $priceSearch = (array_key_exists($dataSearch['price'], HomeController::PRICE_SEARCH)) ? $dataSearch['price'] : 'asc';

        // Check boat type
        $boatCatTmaLogic = new Logics\BoatCategoryTmaLogic();
        $boatCatTmaList = $boatCatTmaLogic->getAllBoatCategoryTma();
        $boatTypeId = null;
        foreach ($boatCatTmaList as $item) {
            if ($boatTypeSearch == $item['categoryName']) {
                $boatTypeId = $item['categoryId'];
                break;
            }
        }

        // Case empty all, search all by status yes
        if (empty(array_filter($dataSearchList))) {
            //$boats = $boatLogic->getAllBoatsByStatus('y');
            $boats = $boatLogic->getAllBoatsByConditions(null, null, null, $countrySearch, 'asc');
            // dd($boats);

            // Get marinas country, when country not empty
            $marinasLogic = new Logics\BoatMarinasLogic();
            $marinasIds = $marinasLogic->getMarinasIds('Singapore');
            foreach ($marinasIds as $key => $item) {
                $marinasIds[$key] = $marinasIds[$key]['marinasId'];
            }

            // Get all boat base on marinas ids
            $boatBaseOnMarinasList = $boatLogic->getAllBoatHomeSameMarinas(null, null, null, $marinasIds, 'asc');
        } else {
            // Validate
            $validator = Validator::make($dataSearch, [
                'people_number' => 'nullable|numeric',
                'occasion' => 'nullable|string',
                'boat_type' => 'nullable|string',
                'country' => 'nullable|string',
                'price' => 'nullable|string'
            ]);
            if ($validator->fails()) {
                return redirect()->route('home');
            }
            $boats = $boatLogic->getAllBoatsByConditions($dataSearch['people_number'], $dataSearch['occasion'], $boatTypeId, $countrySearch, $dataSearch['price']);

            // Step 2
            // Get marinas country, when country not empty
            $marinasLogic = new Logics\BoatMarinasLogic();
            $marinasIds = $marinasLogic->getMarinasIds($countrySearch);
            foreach ($marinasIds as $key => $item) {
                $marinasIds[$key] = $marinasIds[$key]['marinasId'];
            }

            // Get all boat base on marinas ids
            $boatBaseOnMarinasList = $boatLogic->getAllBoatHomeSameMarinas($dataSearch['people_number'], $dataSearch['occasion'], $boatTypeId, $marinasIds, $priceSearch);
        }



        if (!empty($boatBaseOnMarinasList)) {
            $boatsFilter = [];
            $boatMarinasFilter = [];
            foreach ($boats as $item) {
                $boatsFilter[$item['boat_id']] = $item;
            }
            foreach ($boatBaseOnMarinasList as $item) {
                $boatMarinasFilter[$item['boat_id']] = $item;
            }

            $boats = $boatsFilter + $boatMarinasFilter;
            if ($priceSearch === 'asc') {
                usort($boats, [$this, 'sortBoatPriceAsc']);
            } else {
                usort($boats, [$this, 'sortBoatPriceDesc']);
            }
        }
        //echo '<pre>'.print_r(  $boatsFilter    , true).'</pre>';
        if (count($boats) === 0) {
            $data = [
                'no_of_people_search' => [
                    'select' => $noOfPeopleSearch,
                    'list' => HomeController::NUMBER_USER_SEARCH
                ],
                'occasion_search' => [
                    'select' => $occasionSearch,
                    'list' => HomeController::OCCASION_SEARCH
                ],
                'boat_type_search' => [
                    'select' => $boatTypeSearch,
                    'list' => HomeController::BOAT_TYPE_SEARCH
                ],
                'country_search' => [
                    'select' => $countrySearch,
                    'list' => HomeController::COUNTRY_SEARCH
                ],
                'price_search' => [
                    'select' => $priceSearch,
                    'list' => HomeController::PRICE_SEARCH
                ],
                'item_display_search' => [
                    'select' => (string) $limit,
                    'list' => self::ITEM_DISPLAY_SEARCH
                ]
            ];

            return view('search.tridenthome', ['data' => ['no_result' => true, 'input_search' => $data]]);
        }

        $pathPagination = '/search/boat?people_number=' . $dataSearch['people_number'] . '&occasion=' . $dataSearch['occasion'] . '&boat_type=' . $dataSearch['boat_type'] . '&country=' . $dataSearch['country'] . '&price=' . $dataSearch['price'] . '&item_display_search=' . $limit;

        usort($boats, function ($a, $b) {
            if ($a['boat_id'] == 625) return -1;
            if ($b['boat_id'] == 625) return 1;

            if ($a['boat_id'] == 633) return -1;
            if ($b['boat_id'] == 633) return 1;

            if ($a['boat_id'] == 673) return -1;
            if ($b['boat_id'] == 673) return 1;

            // Keep other items as they are
            return 0;
        });

        // dd($boats);
        $dataPerPage = $this->paginate($boats, $limit)->setPath($pathPagination);

        // dd($dataPerPage);

        $sgdRatePath = config_path('SGDRates.json');
        $convertCurrency = new ConvertCurrency($sgdRatePath);
        $dataTemp = [];
        $dataFilter = [];

        // Get currency unit
        $countryLogic = new Logics\BoatCountryLogic();
        $boatMarinasLogic = new Logics\BoatMarinasLogic();



        foreach ($dataPerPage as $key => $item) {
            $dataFilter[$key] = $item;
            // Get currency unit

            if (!$item['currency']) {
                if ($item['country']) {
                    $countryDetail = $countryLogic->getDetailCountry($item['country']);
                } else {
                    $countryName = $boatMarinasLogic->getMarinasCountry($item['marina']);
                    $countryDetail = $countryLogic->getDetailCountry($countryName);
                }
                if (empty($countryDetail)) {
                    $countryName = $boatMarinasLogic->getMarinasCountry($item['marina']);
                    $countryDetail = $countryLogic->getDetailCountry($countryName);
                }
                // still empty set default
                if (empty($countryDetail)) {
                    $dataFilter[$key]['currency'] = 'SGD';
                } else {
                    $dataFilter[$key]['currency'] = $this->getCurrencyUnit($countryDetail[0]['uc']);
                }
            }
            $dataFilter[$key]['MarinaName'] = $boatMarinasLogic->getMarinasNameByID($item['marina'])->marinas_name;


            $facilities = $boatLogic->facilities($item['boat_id']);
            $dataFilter[$key]['facilities'] = $facilities;

            if (!array_key_exists($item['boat_id'], $dataTemp)) {
                // check price valid
                if (!$item['boatPrice']) {
                    $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => 0];
                    continue;
                }

                // check type currency
                if ($item['currency'] == 'SGD') {
                    $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => $item['boatPrice']];
                    continue;
                }
                // convert to sgd
                $covertedCurrency = ($convertCurrency->convertToSGD($item['boatPrice'], $item['currency'])) ? $convertCurrency->convertToSGD($item['boatPrice'], $item['currency']) : 0;
                $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => $covertedCurrency];
            } else {
                // converted currency smaller
                $covertedCurrency = $convertCurrency->convertToSGD($item['boatPrice'], $item['currency']);
                if ($covertedCurrency < $dataTemp[$item['boat_id']]['price']) {
                    unset($dataFilter[$dataTemp[$item['boat_id']]['key']]);
                    $dataTemp[$item['boat_id']] = ['key' => $key, 'price' => $covertedCurrency];
                } else {
                    unset($dataFilter[$key]);
                }
            }
        }

        // dd($dataFilter);

        $data = [
            'no_of_people_search' => [
                'select' => $noOfPeopleSearch,
                'list' => HomeController::NUMBER_USER_SEARCH
            ],
            'occasion_search' => [
                'select' => $occasionSearch,
                'list' => HomeController::OCCASION_SEARCH
            ],
            'boat_type_search' => [
                'select' => $boatTypeSearch,
                'list' => HomeController::BOAT_TYPE_SEARCH
            ],
            'country_search' => [
                'select' => $countrySearch,
                'list' => HomeController::COUNTRY_SEARCH
            ],
            'price_search' => [
                'select' => $priceSearch,
                'list' => HomeController::PRICE_SEARCH
            ],
            'item_display_search' => [
                'select' => (string) $limit,
                'list' => self::ITEM_DISPLAY_SEARCH
            ],
            'dataPerPage' => $dataPerPage,
            'dataDisplay' => $dataFilter
        ];

        return view('search.tridenthome', ['data' => $data]);
    }

    /**
     * Get boat detail base on id
     *
     * @param int $boatId
     * @param Request $request
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function boatDetail_OLD_FUNCTION($boatId, Request $request)
    {
        // validate
        $invoice = '';
        if ($request->input('invoice') != "") {
            $invoice = $request->input('invoice');
        } else {
            if (Auth::check()) {
                $boatCharterLogic = new Logics\BoatCharterLogic();
                $ifinvoice = $boatCharterLogic->getCharterBookedByUser(Auth::id(), $boatId);
                if ($ifinvoice > 0)
                    $invoice = $ifinvoice;
            }
        }

        $validator = Validator::make(['boat_id' => $boatId], [
            'boat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->route('home');
        }
        // Create logic
        $boatLogic = new Boat();
        $boatSeaSportsLogic = new Logics\BoatSeaSportsLogic();

        // get current boat detail
        $boatDetail = $boatLogic->getBoatDetail($boatId);

        $boatSeaSportsList = $boatSeaSportsLogic->getSeaSportsList($boatId);

        $boatCommentLogic = new Logics\BoatCommentLogic();

        $comments = $boatCommentLogic->getCommentOnBoat($boatId);
        $myComments = null;
        if (!empty($comments)) {
            if (Auth::check()) {
                $myComments = $comments->where('comment_from', Auth::id());
            }
        }


        if (empty($boatDetail)) {
            return redirect()->route('home');
        }

        // get boat category
        if (!empty($boatDetail[0]['boat_type_tma'])) {
            $boatCatTmaLogic = new Logics\BoatCategoryTmaLogic();
            $boatCatTmaList = $boatCatTmaLogic->getBoatCategoryTma($boatDetail[0]['boat_type_tma']);
            // get before and after
            $boatIdBefore = $boatLogic->getBoatIdBeforeTma($boatId, $boatDetail[0]['boat_type_tma']);
            $boatIdAfter = $boatLogic->getBoatIdAfterTma($boatId, $boatDetail[0]['boat_type_tma']);
        } else {
            $boatCatTmaLogic = new Logics\BoatCategoryTmaLogic();
            $boatCatTmaList = $boatCatTmaLogic->getBoatCategoryNormal($boatDetail[0]['boat_type']);
            // get before and after
            $boatIdBefore = $boatLogic->getBoatIdBefore($boatId, $boatDetail[0]['boat_type']);
            $boatIdAfter = $boatLogic->getBoatIdAfter($boatId, $boatDetail[0]['boat_type']);
        }
        $boatDetail[0]['categoryName'] = $boatCatTmaList[0]['categoryName'];
        // get lowest price
        $sgdRatePath = config_path('SGDRates.json');
        $convertCurrency = new ConvertCurrency($sgdRatePath);
        $listCurrencyVal = [];
        $listCurrencyUnit = [];
        $countryLogic = new Logics\BoatCountryLogic();
        foreach ($boatDetail as $key => $item) {
            // Get currency unit
            if (!$item['currency']) {
                if ($item['country']) {
                    $countryDetail = $countryLogic->getDetailCountry($item['country']);
                } else {
                    $countryDetail = $countryLogic->getDetailCountry($item['marinas_country']);
                }
                if (empty($countryDetail)) {
                    $countryDetail = $countryLogic->getDetailCountry($item['marinas_country']);
                }
                // still empty set default
                if (empty($countryDetail)) {
                    $item['currency'] = 'SGD';
                } else {
                    $item['currency'] = $this->getCurrencyUnit($countryDetail[0]['uc']);
                }
            }

            $boatDetail[$key]['length'] = $this->convertLengthBoat($item['length']);

            if (!$item['boatPrice']) {
                $listCurrencyVal[$key] = 0;
                $listCurrencyUnit[$key] = $item['currency'];
                break;
            }

            if ($item['currency'] === 'SGD') {
                $listCurrencyVal[$key] = $item['boatPrice'];
                $listCurrencyUnit[$key] = $item['currency'];
                continue;
            }
            // convert

            $listCurrencyUnit[$key] = $item['currency'];
            // Changes on 01.08.2022 //
            //  $listCurrencyVal[$key] = ($convertCurrency->convertToSGD($item['boatPrice'], $item['currency'])) ? $convertCurrency->convertToSGD($item['boatPrice'], $item['currency']) : 0;

            $listCurrencyVal[$key] = ($item['boatPrice']) ? $item['boatPrice'] : 0;
        }
        // then assign to first item
        $boatDetail[0]['boatPrice'] = min($listCurrencyVal);
        $boatDetail[0]['currency'] = $listCurrencyUnit[array_search($boatDetail[0]['boatPrice'], $listCurrencyVal)];

        // Get user extend self_drive
        $userSelfDrive = 0;
        if (Auth::check()) {
            $user = Auth::user();
            $boatUserLogic = new Logics\BoatUserLogic();
            $userExtend = $boatUserLogic->getUserExtend($user->user_id);
            $userSelfDrive = (!empty($userExtend)) ? $userExtend[0]['self_drive'] : 0;
        }

        if ($boatDetail[0]['self_drive'] < 1) {
            $assignSkipper = true;
        } else {
            $assignSkipper = ($boatDetail[0]['self_drive'] > $userSelfDrive) ? true : false;
        }

        $data = [
            'curBoatDetail' => $boatDetail[0],
            'beforeBoatId' => (empty($boatIdBefore)) ? '' : $boatIdBefore,
            'afterBoatId' => (empty($boatIdAfter)) ? '' : $boatIdAfter,
            'paypalFee' => self::PAYPAL_FEE,
            'seaSportsFee' => $boatSeaSportsList,
            'assignSkipper' => $assignSkipper,
            'comments' => (!empty($comments)) ? $comments : null,
            'avgRating' => (!empty($comments)) ? $comments->avg('rate') : null,
            'invoice' => $invoice,
            'alreadyComment' => (!empty($myComments) && count($myComments) > 0) ? true : false,
        ];

        return view('product.product', ['data' => $data]);
    }


    /**
     * Get boat detail base on id
     *
     * @param int $boatId
     * @param Request $request
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function boatDetail($boatId, Request $request)
    {
        // validate
        $invoice = '';
        if ($request->input('invoice') != "") {
            $invoice = $request->input('invoice');
        } else {
            if (Auth::check()) {
                // $boatCharterLogic = new Logics\BoatCharterLogic();
                // $ifinvoice = $boatCharterLogic->getCharterBookedByUser(Auth::id(), $boatId);
                $sql = DB::table('boat_charter_book')->where([['user_id', Auth::id()], ['boat_id', $boatId]])->orderBy('book_id', 'desc')->first();
                // dd($sql);
                if (!empty($sql)) {
                    $invoice = $sql->book_id;
                } else {
                    $invoice = '';
                }
            }
        }


        // $validator = Validator::make(['boat_id' => $boatId], [
        //     'boat_id' => 'required|numeric|exists:boat_tbl_boat,boat_id'
        // ]); 

        $validator = Validator::make(['boat_id' => $boatId], [
            'boat_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->route('home');
        }

        $boatExist = DB::table('boat_tbl_boat')->where('boat_id', $boatId)->first();
        if ($boatExist === null) {
            return redirect()->route('home');
        }
        // Create logic
        $boatLogic = new Boat();
        $boatSeaSportsLogic = new Logics\BoatSeaSportsLogic();

        // get current boat detail
        $boatDetail = $boatLogic->getBoatDetail($boatId);
        $boatSeaSportsList = $boatSeaSportsLogic->getSeaSportsList($boatId);

        //dd($boatLogic);
        if(empty($boatDetail)){
            abort(404);
        }

        $book_type = $boatDetail[0]->book_type;
        $show_credit = $boatDetail[0]->credit_available;

        $boatCommentLogic = new Logics\BoatCommentLogic();

        $comments = $boatCommentLogic->getCommentOnBoat($boatId);
        $myComments = null;
        if (!empty($comments)) {
            if (Auth::check()) {
                $myComments = $comments->where('comment_from', Auth::id());
            }
        }


        if (empty($boatDetail)) {
            return redirect()->route('home');
        }

        // get boat category
        if (!empty($boatDetail[0]->boat_type_tma)) {
            $boatCatTmaLogic = new Logics\BoatCategoryTmaLogic();
            $boatCatTmaList = $boatCatTmaLogic->getBoatCategoryTma($boatDetail[0]->boat_type_tma);
            // get before and after
            $boatIdBefore = $boatLogic->getBoatIdBeforeTma($boatId, $boatDetail[0]->boat_type_tma);
            $boatIdAfter = $boatLogic->getBoatIdAfterTma($boatId, $boatDetail[0]->boat_type_tma);
        } else {
            $boatCatTmaLogic = new Logics\BoatCategoryTmaLogic();
            $boatCatTmaList = $boatCatTmaLogic->getBoatCategoryNormal($boatDetail[0]->boat_type);
            // get before and after
            $boatIdBefore = $boatLogic->getBoatIdBefore($boatId, $boatDetail[0]->boat_type);
            $boatIdAfter = $boatLogic->getBoatIdAfter($boatId, $boatDetail[0]->boat_type);
        }
        // dd($boatDetail);
        $boatDetail[0]->categoryName = $boatCatTmaList[0]['categoryName'];
        // get lowest price
        $sgdRatePath = config_path('SGDRates.json');
        $convertCurrency = new ConvertCurrency($sgdRatePath);
        $listCurrencyVal = [];
        $listCurrencyUnit = [];
        $countryLogic = new Logics\BoatCountryLogic();
        foreach ($boatDetail as $key => $item) {
            // Get currency unit
            // var_dump($item->currency);
            if (!$item->currency) {
                if ($item->country) {
                    $countryDetail = $countryLogic->getDetailCountry($item->country);
                } else {
                    $countryDetail = $countryLogic->getDetailCountry($item['marinas_country']);
                }
                if (empty($countryDetail)) {
                    $countryDetail = $countryLogic->getDetailCountry($item['marinas_country']);
                }
                // still empty set default
                if (empty($countryDetail)) {
                    $item->currency = 'SGD';
                } else {
                    $item->currency = $this->getCurrencyUnit($countryDetail[0]['uc']);
                }
            }

            $boatDetail[$key]->length = $this->convertLengthBoat($item->length);

            if (!$item->boatPrice) {
                $listCurrencyVal[$key] = 0;
                $listCurrencyUnit[$key] = $item->currency;
                break;
            }

            if ($item->currency === 'SGD') {
                $listCurrencyVal[$key] = $item->boatPrice;
                $listCurrencyUnit[$key] = $item->currency;
                continue;
            }
            // convert

            $listCurrencyUnit[$key] = $item->currency;
            // Changes on 01.08.2022 //
            //  $listCurrencyVal[$key] = ($convertCurrency->convertToSGD($item['boatPrice'], $item['currency'])) ? $convertCurrency->convertToSGD($item['boatPrice'], $item['currency']) : 0;

            $listCurrencyVal[$key] = ($item->boatPrice) ? $item->boatPrice : 0;
        }
        // then assign to first item
        $boatDetail[0]->boatPrice = min($listCurrencyVal);
        $boatDetail[0]->currency = $listCurrencyUnit[array_search($boatDetail[0]->boatPrice, $listCurrencyVal)];

        // Get user extend self_drive
        $userSelfDrive = 0;
        if (Auth::check()) {
            $user = Auth::user();
            // $boatUserLogic = new Logics\BoatUserLogic();
            // $userExtend = $boatUserLogic->getUserExtend($user->user_id);
            $userExtend = DB::table('boat_user_extend')->where('user_id', $user->user_id)->orderBy('last_update')->first();
            $userExtend = json_decode(json_encode($userExtend), true);
            $userSelfDrive = (!empty($userExtend)) ? $userExtend['self_drive'] : 0;
        }

        if ($boatDetail[0]->self_drive < 1) {
            $assignSkipper = true;
        } else {
            $assignSkipper = ($boatDetail[0]->self_drive > $userSelfDrive) ? true : false;
        }

        $myCredits = DB::table('boat_user_credits')->distinct()->groupby('credit_id')->where('user_id', Auth::id())->where('expiry_date', '>=', date('Y-m-d'))->orderBy('cid', 'asc')->get();
        $ifmember = DB::table('boat_membership')
            ->join('boat_user_membership', 'boat_membership.membership_id', '=', 'boat_user_membership.membership_id')
            ->where('boat_user_membership.user_id', Auth::id())->where('boat_user_membership.expiry', '>=', date('y-m-d'))
            ->whereRaw('FIND_IN_SET("' . $boatId . '", boat_membership.boat_id  )')->get();
        $ifmember = (!empty($ifmember)) ? $ifmember : null;
        $boat_ids = !empty($ifmember) && isset($ifmember[0]) ? explode(',', $ifmember[0]->boat_id) : [];
        $show_member = !empty($ifmember) && in_array($boatId, $boat_ids) ? true : false;



        DB::table('boat_user_credits')->distinct()->groupby('credit_id')->where('user_id', Auth::id())->where('expiry_date', '>=', date('Y-m-d'))->orderBy('cid', 'asc')->get();


        // if ($myCredits[0] && $myCredits[0]->credit_id) {
        //     $res = DB::table('boat_credit_boat_id')->where('credit_id', $myCredits[0]->credit_id)->first(['boat_id']);
        //     $assignedBoat = explode(',', $res->boat_id);
        //     $show_credit = in_array($boatId, $assignedBoat) ? true : false;
        // }
        $data = [
            'curBoatDetail' => $boatDetail[0],
            'beforeBoatId' => (empty($boatIdBefore)) ? '' : $boatIdBefore,
            'afterBoatId' => (empty($boatIdAfter)) ? '' : $boatIdAfter,
            'paypalFee' => self::PAYPAL_FEE,
            'seaSportsFee' => $boatSeaSportsList,
            'assignSkipper' => $assignSkipper,
            'comments' => (!empty($comments)) ? $comments : null,
            'avgRating' => (!empty($comments)) ? $comments->avg('rate') : null,
            'invoice' => $invoice,
            'alreadyComment' => (!empty($myComments) && count($myComments) > 0) ? true : false,
            'myCredits' => (!empty($myCredits)) ? $myCredits : null,
            'ifmember' => $ifmember,
            'book_type' => $book_type,
            'show_credit' => $show_credit,
            'show_member' => $show_member
        ];

        return view('product.product', ['data' => $data]);
    }

    /**
     * Calculate boat price when book
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function calBoatPrice(Request $request)
    {
        // get params
        $params = $request->all();
        // validate
        $validator = Validator::make($params, [
            'timeIdList' => 'required',
            'datePicked' => 'required',
            'boatId' => 'required'
        ]);
        if ($validator->fails()) {
            return json_encode(['result' => false]);
        }
        if (!preg_match(self::PATTERN_DATE_PICKED, $params['datePicked'])) {
            return json_encode(['result' => false]);
        }
        $rangeTimeList = explode(',', $params['timeIdList']);
        // calculate
        $totalPrice = null;
        $boatLogic = new Logics\BoatTimePriceLogic();
        foreach ($rangeTimeList as $item) {
            $dataBoatTimePrice = $boatLogic->getSingleDataBoatTimePrice(intval($item), $params['datePicked'], intval($params['boatId']));
            if ($params['isSkipper'] === 'true') {
                $totalPrice += $dataBoatTimePrice['price'] + $dataBoatTimePrice['skipperPrice'];
            } else {
                $totalPrice += $dataBoatTimePrice['price'];
            }
        }
        return json_encode(['result' => true, 'data' => $totalPrice]);
    }


    /**
     * Validate date for boat detail
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function validDateBoatDetail(Request $request)
    {
        $params = $request->all();
        if (empty($params['datePicked']) || empty($params['boatId'])) {
            return json_encode(['result' => false]);
        }

        // Generate currency unit
        /*$currencyUnit = 'N/A';
        if (!empty($params['currency'])) {
            $countryLogic = new Logics\BoatCountryLogic();
            $countryDetail = $countryLogic->getDetailCountry($params['currency']);

            $currencyUnit = $this->getCurrencyUnit($countryDetail[0]['uc']);
        }*/

        // get data from database
        $boatTimePriceLogic = new Logics\BoatTimePriceLogic();
        $data = $boatTimePriceLogic->getDataBaseOnDateAndBoat($params['datePicked'], $params['boatId']);
        if (empty(array_filter($data))) {
            // check has early date >= current date
            $maxDate = $boatTimePriceLogic->getMaxDate($params['boatId']);
            // not available time for this product
            if (!$maxDate || date('Y-m-d') > $maxDate) {
                return json_encode(['result' => false]);
            }
            // return max date to choose
            return json_encode(['result' => false, 'max_date' => $maxDate]);
        }
        foreach ($data as $key => $item) {
            $data[$key]['is_booked'] = false;
            $data[$key]['sea_sports_list'] = self::SEA_SPORTS;
        }

        // For user logging check time slot already buy ?
        $charterBookedData = [];
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->user_id;
            $isCancel = 0;
            $boatCharterLogic = new Logics\BoatCharterLogic();
            $datePicked = new \DateTime($params['datePicked']);
            /*  $charterBookedData = $boatCharterLogic->getCharterBookedForUser($userId, $params['boatId'], $datePicked->format('Y-m-d'));*/
            /* added on 19.07.2020 */
            $charterBookedData = $boatCharterLogic->getCharterBookedForBoat($params['boatId'], $datePicked->format('Y-m-d'), $isCancel);
        }
        // echo '<pre>'.print_r( $charterBookedData, true).'</pre>';
        if (!empty($charterBookedData)) {
            foreach ($data as $key => $item) {
                if (array_key_exists($item['id'], $charterBookedData)) {
                    if ($charterBookedData[$item['id']]['isCancel'] == 0) {
                        $data[$key]['is_booked'] = true;
                    } else {
                        $data[$key]['is_booked'] = false;
                    }
                }
            }
        }

        return json_encode(['result' => true, 'data' => $data]);
    }

    /**
     * Description
     *
     * @param Request $request
     * @return json
     * @author vduong daiduongptit090@gmail.com
     */
    public function getValidRangeDate(Request $request)
    {
        $params = $request->all();
        if (empty($params['dateStart']) || empty($params['dateEnd']) || empty($params['boatId']) || ($params['dateStart'] > $params['dateEnd'])) {
            return json_encode(['result' => false]);
        }

        $boatTimePriceLogic = new Logics\BoatTimePriceLogic();
        $validDateList = $boatTimePriceLogic->getValidDateList($params['boatId'], $params['dateStart'], $params['dateEnd']);

        if (empty($validDateList)) {
            return json_encode(['result' => false, 'message' => 'No valid date to get.']);
        }
        $dateList = [];
        foreach ($validDateList as $key => $item) {
            $dateList[] = $item['dateFor']->format('Y-m-d');
        }
        return json_encode(['result' => true, 'validDateList' => $dateList]);
    }

    /**
     * Create a length aware custom paginator instance.
     *
     * @param  Collection  $items
     * @param  int  $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate($items, $limit)
    {
        $items = json_decode(json_encode($items), true);
        //Get current page form url e.g. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        do {
            $currentPageItems = array_slice($items, ($currentPage - 1) * $limit, $limit);
            //$currentPageItems = $items->slice(($currentPage - 1) * $limit, $limit);
            LengthAwarePaginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
            $currentPage--;
        } while (count($currentPageItems) === 0);
        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $limit);
    }

    private function getCurrencyUnit($countryUc)
    {
        $pathCurrency = config_path('currency.json');
        $currencyJson = file_get_contents($pathCurrency);
        $jsonIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(json_decode($currencyJson, TRUE)),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($jsonIterator as $key => $item) {
            if ($key == $countryUc) {
                return $item;
            }
        }
    }

    private function checkValidCurrencyUnit($currencyUnit)
    {
        $pathCurrency = config_path('currency.json');
        $currencyJson = file_get_contents($pathCurrency);
        $jsonIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(json_decode($currencyJson, TRUE)),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($jsonIterator as $key => $item) {
            if ($item == $currencyUnit) {
                return $key;
            }
        }
        return false;
    }

    private function convertLengthBoat($lengthBoatDetail)
    {
        if (strpos($lengthBoatDetail, ' ')) {
            $lengthBoat = explode(" ", $lengthBoatDetail);
            return $lengthBoat[0];
        }
        if (strpos($lengthBoatDetail, 'f')) {
            return substr($lengthBoatDetail, 0, strpos($lengthBoatDetail, 'f'));
        }
        return $lengthBoatDetail;
    }

    private function sortBoatPriceAsc($boatItem1, $boatItem2)
    {
        return $boatItem1['boatPrice'] > $boatItem2['boatPrice'];
    }

    private function sortBoatPriceDesc($boatItem1, $boatItem2)
    {
        return $boatItem1['boatPrice'] < $boatItem2['boatPrice'];
    }

    private function sortBoatSingaporeFirst($boatList)
    {
        $dataTemp = [];
        foreach ($boatList as $key => $item) {
            if ($item['country'] === 'Singapore') {
                $dataTemp[$key] = $item;
                unset($boatList[$key]);
            }
        }
        return array_merge($dataTemp, $boatList);
        // dd($boatList);
    }

    public function getDetailCountry($country)
    {
        $countryDetail = DB::table('boat_country')->where('name', $country)->get()->toArray();
        $countryDetail = json_decode(json_encode($countryDetail), true);
        return $countryDetail;
    }

    public function getMarinasCountry($countryId)
    {
        $countryDetail = DB::table('boat_marinas')->where('marinas_id', $countryId)->get()->toArray();
        $countryDetail = json_decode(json_encode($countryDetail), true);
        return $countryDetail;
    }

    public function getMarinasNameByID($id)
    {
        return DB::table('boat_marinas')
            ->select('marinas_name')
            ->where('marinas_id', '=', $id)
            ->orderBy('marinas_name', 'asc')
            ->first();
    }
}
