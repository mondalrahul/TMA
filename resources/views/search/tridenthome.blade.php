@extends('index')
@section('content')
    <div class="trident-fleet-wrapper">
        <div class="trident-fleet-header">
            <div class="background" style="display: none;"><img src="{{ asset('/images/trident-fleet/monohull.png') }}"></div>
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Trident Fleet</li>
                        </ol>
                    </div>
                    <div class="fleet-type">
                        <div class="title">TRIDENT&nbsp;<strong>Fleet</strong></div>
                        <div class="description">
                            <p><strong>Luxury – Sporty – Simplified</strong></p>
                            <p>We have a yacht for <strong>all occasions</strong>!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($data['no_result']))
            <div class="trident-fleet-nav top" style="margin-top: 175px;">
                <div class="container">
                    <div class="wrapper">
                        <form id="form-search-trident-home" name="form-search-trident-home" method="get"
                            action="/search/boat">
                            <div class="trident-fleet-filters">
                                <div class="trident-fleet-no-of-people">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">No. Of People</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="people_number" data-width="100%"
                                                id="h_people_number_search">
                                                @foreach ($data['input_search']['no_of_people_search']['list'] as $key => $item)
                                                    <option
                                                        value="@if ($key != '0') {{ $key }} @endif"
                                                        @if ($data['input_search']['no_of_people_search']['select'] == $key) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-occassion">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Occassion</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="occasion" data-width="100%"
                                                id="h_occasion_search">
                                                @foreach ($data['input_search']['occasion_search']['list'] as $key => $item)
                                                    <option
                                                        value="@if ($key != '0') {{ $key }} @endif"
                                                        @if ($data['input_search']['occasion_search']['select'] == $key) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-boat-type">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Boat Type</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="boat_type" data-width="100%"
                                                id="h_boat_type_search">
                                                @foreach ($data['input_search']['boat_type_search']['list'] as $key => $item)
                                                    <option
                                                        value="@if ($key != '0') {{ $key }} @endif"
                                                        @if ($data['input_search']['boat_type_search']['select'] == $key) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-country">
                                    <div class="filter-wrapper">
                                        <label
                                            class="font-size-08-rem">Country{{ $data['input_search']['country_search']['select'] }}</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="country" data-width="100%"
                                                id="h_country_search">
                                                <option value="" @if ($data['input_search']['country_search']['select'] == '') selected @endif>
                                                    Show All</option>
                                                @foreach ($data['input_search']['country_search']['list'] as $item)
                                                    <option value="{{ $item }}"
                                                        @if ($data['input_search']['country_search']['select'] == $item) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-price">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Price</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="price" data-width="100%"
                                                id="h_price_search">
                                                @foreach ($data['input_search']['price_search']['list'] as $key => $item)
                                                    <option value="{{ $key }}"
                                                        @if ($data['input_search']['price_search']['select'] == $key) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-show">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Show</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="item_display_search" data-width="100%"
                                                id="h_item_display_search">
                                                @foreach ($data['input_search']['item_display_search']['list'] as $key => $item)
                                                    <option value="{{ $key }}"
                                                        @if ($data['input_search']['item_display_search']['select'] == $key) selected @endif>
                                                        {{ $item }} per page</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="1" />
                        </form>
                    </div>
                    No value found;
                </div>
            </div>
        @else
            <div class="trident-fleet-nav top" style="margin-top: 175px;">
                <div class="container">
                    <div class="wrapper">
                        <div class="trident-fleet-pagination">
                            {{ $data['dataPerPage']->links('vendor.pagination.boatpagination', ['data' => $data['dataPerPage']]) }}
                        </div>
                        <form id="form-search-trident-home" name="form-search-trident-home" method="get"
                            action="/search/boat">
                            <div class="trident-fleet-filters">
                                <div class="trident-fleet-no-of-people">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">No. Of People</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="people_number" data-width="100%"
                                                id="h_people_number_search">
                                                @foreach ($data['no_of_people_search']['list'] as $key => $item)
                                                    <option
                                                        value="@if ($key != '0') {{ $key }} @endif"
                                                        @if ($data['no_of_people_search']['select'] == $key) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-occassion">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Occassion</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="occasion" data-width="100%"
                                                id="h_occasion_search">
                                                @foreach ($data['occasion_search']['list'] as $key => $item)
                                                    <option
                                                        value="@if ($key != '0') {{ $key }} @endif"
                                                        @if ($data['occasion_search']['select'] == $item) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-boat-type">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Boat Type</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="boat_type" data-width="100%"
                                                id="h_boat_type_search">
                                                @foreach ($data['boat_type_search']['list'] as $key => $item)
                                                    <option
                                                        value="@if ($key != '0') {{ $key }} @endif"
                                                        data-subtext="- @if ($key != '0') {{ $key }}@else Show All @endif"
                                                        @if ($data['boat_type_search']['select'] == $item) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-country">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Country</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="country" data-width="100%"
                                                id="h_country_search">
                                                <option value="" @if ($data['country_search']['select'] == '') selected @endif>
                                                    Show All</option>
                                                @foreach ($data['country_search']['list'] as $item)
                                                    <option value="{{ $item }}"
                                                        @if ($data['country_search']['select'] == $item) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-price">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Price</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="price" data-width="100%"
                                                id="h_price_search">
                                                @foreach ($data['price_search']['list'] as $key => $item)
                                                    <option value="{{ $key }}"
                                                        @if ($data['price_search']['select'] == $key) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="trident-fleet-show">
                                    <div class="filter-wrapper">
                                        <label class="font-size-08-rem">Show</label>
                                        <div class="select-wrapper">
                                            <select class="selectpicker" name="item_display_search" data-width="100%"
                                                id="h_item_display_search">
                                                @foreach ($data['item_display_search']['list'] as $key => $item)
                                                    <option value="{{ $key }}"
                                                        @if ($data['item_display_search']['select'] == $key) selected @endif>
                                                        {{ $item }} per page</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="{{ $data['dataPerPage']->currentPage() }}" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="trident-fleet-list">
                <div class="wrapper">
                    <div class="container">
                        <div class="row">
                            @foreach ($data['dataDisplay'] as $item)
                                <div class="col-lg-4 col-md-6 col-sm-12" id="item-{{ $item['boat_id'] }}">
                                    <div class="trident-fleet-item">
                                        @if ($item['is_promoted'] == '1')
                                            <div class="promoted"><img
                                                    src="{{ asset('images/product-list/promoted.png') }}" alt="">
                                            </div>
                                        @endif
                                        <div class="wrapper">
                                            @php
                                                //$image = public_path('images/product/' . $item['main_photo']);
                                                //if (file_exists($image)) {
                                                //  $imagePath = asset('images/product/' . $item['main_photo']);
                                                //} else {
                                                //  $imagePath = asset('/assets/img/boat-thumb.png');
                                                //}

                                                if ($item['main_photo'] != null) {
                                                    $imagePath =
                                                        'https://staging.theboatshopasia.com/product/' .
                                                        $item['main_photo'];
                                                } else {
                                                    $imagePath = asset('/assets/img/boat-thumb.png');
                                                }

                                            @endphp


                                            <div class="image" style="background-image: url('{{ $imagePath }}')">
                                            </div>
                                        </div>
                                        <div class="boat-detail">
                                            <div class="boat-title-wrapper">
                                                <div class="boat-title">{{ strtoupper($item['boat_name']) }}</div>
                                                <div class="boat-price">
                                                    <div class="from">From</div>
                                                    <div class="price">
                                                        <?php if ($item['boatPrice']): ?>
                                                        {{ $item['currency'] }}
                                                        {{ \App\Http\Utils\StringDatabase::executeNiceNumber($item['boatPrice']) }}
                                                        <?php else: ?>
                                                        {{ $item['currency'] }} 0
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $fullDetail = strip_tags(\App\Http\Utils\StringDatabase::executeStringToHtml($item['boat_details']));
                                            ?>
                                            <div class="boat-description">
                                                @if (strlen($fullDetail) > 88)
                                                    <?php
                                                    $detail = substr($fullDetail, 0, 88);
                                                    ?>
                                                    {{ $detail }}...
                                                @else
                                                    {{ $fullDetail }}
                                                @endif
                                            </div>
                                            <div class="feature" style="margin : 0 0  0.5rem  0.5rem "><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i> Country:</span><span>
                                                    @if ($item['country'])
                                                        {{ $item['country'] }}
                                                    @else
                                                        NA
                                                    @endif
                                                </span></div>

                                            <h6 style="margin-bottom: 1.2rem;"><img
                                                    src="../images/product-detail/facilities/anchor-128.png"
                                                    width="20" alt=""> {{ $item['MarinaName'] }}</h6>
                                            <div class="boat-features">
                                                <!-- <div class="feature"><span>Head:</span><span>
                                                                                @if ($item['head'])
    YES
@else
    NO
    @endif
                                                                                </span></div>
                                                                                                                            <div class="feature">
                                                                                @if ($item['gps'])
    <img src="{{ asset('images/product-detail/facilities/satellite.png') }}">
    @endif
                                                                                </div>
                                                                                <div class="feature">
                                                                                @if ($item['gps'])
    <img src="{{ asset('images/product-detail/facilities/air-condition.png') }}">
    @endif
                                                                                </div>
                                                                                                                            <div class="feature"><span>Guest:</span><span>
                                                                                @if ($item['pax'])
    {{ $item['pax'] }}
@else
    0
    @endif
                                                                                </span></div> -->
                                                <div class="feature"><span>Guest:</span><span>
                                                        @if ($item['pax'])
                                                            {{ $item['pax'] }}
                                                        @else
                                                            0
                                                        @endif
                                                    </span></div>
                                                <div class="feature facilities">
                                                    <span>Facilities:</span>
                                                    @php
                                                        // var_dump($item['facilities']);
                                                    @endphp
                                                    @if (is_countable($item['facilities']))
                                                        @if (count($item['facilities']) > 0)
                                                            @if ($item['facilities']->air_conditioning > '0')
                                                                <img src="../images/product-detail/facilities/air-condition.png"
                                                                    alt="">
                                                            @endif
                                                            @if ($item['facilities']->jacuzzi > '0')
                                                                <img src="../images/product-detail/facilities/jacuzzi.png"
                                                                    alt="Jacuzzi">
                                                            @endif
                                                            @if ($item['facilities']->toilet > '0')
                                                                <img src="../images/product-detail/facilities/toilet.png"
                                                                    alt="Toilet">
                                                            @endif
                                                        @endif
                                                        @if ($item['self_drive'] == 1 || $item['self_drive'] == 3)
                                                            <img src="../images/product-detail/facilities/self-drive.png"
                                                                alt="Self-Drive">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="more-info"><a href="/boat-detail/{{ $item['boat_id'] }}">MORE
                                                INFO</a></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="trident-fleet-nav bottom">
                <div class="container">
                    <div class="wrapper">
                        <div class="trident-fleet-pagination">
                            <div class="trident-fleet-pagination">
                                {{ $data['dataPerPage']->links('vendor.pagination.boatpagination', ['data' => $data['dataPerPage']]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
