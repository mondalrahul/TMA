@extends('index')
@section('content')
    <div class="trident-fleet-wrapper">
        <div class="trident-fleet-header">
            <div class="background" style="display:none;"><img src="{{ asset('/images/trident-fleet/monohull.png') }}"></div>
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ $data['boat_type'] }}</li>
                        </ol>
                    </div>
                    <div class="fleet-type">
                        <div class="title">TRIDENT&nbsp;<strong>{{ strtoupper($data['boat_type']) }}</strong></div>
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
                        <form id="form-search-trident-fleet" name="form-search-trident-fleet" method="get"
                            action="/trident-fleet/{{ $data['boat_type'] }}">
                            <div class="trident-fleet-filters">
                                <div class="trident-fleet-boat-type">
                                    <label>Boat type</label>
                                    <select class="selectpicker" data-width="140px" disabled>
                                        <option>{{ $data['boat_type'] }}</option>
                                    </select>
                                </div>
                                <div class="trident-fleet-sort">
                                    <label>Country</label>
                                    <select class="selectpicker" name="country_search" data-width="140px"
                                        id="td_country_search">
                                        <option value="" @if ($data['input_search']['country_search']['select'] == '') selected @endif>Show All
                                        </option>
                                        @foreach ($data['input_search']['country_search']['list'] as $key => $item)
                                            <option value="{{ $item }}"
                                                @if ($data['input_search']['country_search']['select'] == $item) selected @endif>{{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="trident-fleet-order">
                                    <label>Price</label>
                                    <select class="selectpicker" name="price_search" data-width="140px"
                                        id="td_price_search">
                                        @foreach ($data['input_search']['price_search']['list'] as $key => $item)
                                            <option value="{{ $key }}"
                                                @if ($data['input_search']['price_search']['select'] == $key) selected @endif>{{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="trident-fleet-order">
                                    <label>Show</label>
                                    <select class="selectpicker" name="item_display_search" data-width="140px"
                                        id="item_display_search">
                                        @foreach ($data['input_search']['item_display_search']['list'] as $key => $item)
                                            <option value="{{ $key }}"
                                                @if ($data['input_search']['item_display_search']['select'] == $key) selected @endif>{{ $item }} per
                                                page</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <p class="text-center"> No value found </p>
            </div>
        @else
            <div class="trident-fleet-nav top" style="margin-top: 175px;">
                <div class="container">
                    <div class="wrapper">
                        <div class="trident-fleet-pagination">
                            {{ $data['dataPerPage']->links('vendor.pagination.boatpagination', ['data' => $data['dataPerPage']]) }}
                        </div>
                        <form id="form-search-trident-fleet" name="form-search-trident-fleet" method="get"
                            action="/trident-fleet/{{ $data['boat_type'] }}">
                            <div class="trident-fleet-filters">
                                <div class="trident-fleet-boat-type">
                                    <label>Boat type</label>
                                    <select class="selectpicker" data-width="140px" disabled>
                                        <option>{{ $data['boat_type'] }}</option>
                                    </select>
                                </div>
                                <div class="trident-fleet-sort">
                                    <label>Country</label>
                                    <select class="selectpicker" name="country_search" data-width="140px"
                                        id="td_country_search">
                                        <option value="" @if ($data['country_search']['select'] == '') selected @endif>Show All
                                        </option>
                                        @foreach ($data['country_search']['list'] as $key => $item)
                                            <option value="{{ $item }}"
                                                @if ($data['country_search']['select'] == $item) selected @endif>{{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="trident-fleet-order">
                                    <label>Price</label>
                                    <select class="selectpicker" name="price_search" data-width="140px"
                                        id="td_price_search">
                                        @foreach ($data['price_search']['list'] as $key => $item)
                                            <option value="{{ $key }}"
                                                @if ($data['price_search']['select'] == $key) selected @endif>{{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="trident-fleet-order">
                                    <label>Show</label>
                                    <select class="selectpicker" name="item_display_search" data-width="140px"
                                        id="item_display_search">
                                        @foreach ($data['item_display_search']['list'] as $key => $item)
                                            <option value="{{ $key }}"
                                                @if ($data['item_display_search']['select'] == $key) selected @endif>{{ $item }} per
                                                page</option>
                                        @endforeach
                                    </select>
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
                                           {{--  @php
                                                $image = public_path('images/product/' . $item['main_photo']);
                                                if (file_exists($image)) {
                                                    $imagePath = asset('images/product/' . $item['main_photo']);
                                                } else {
                                                    $imagePath = asset('/assets/img/boat-thumb.png');
                                                }
                                            @endphp --}}
					@php
    if($item['main_photo'] != null){
            $imagePath = "https://staging.theboatshopasia.com/product/".$item['main_photo'];
    }else{
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
                                                        @if (!$item['boatPrice'])
                                                            {{ $item['currency'] }} 0
                                                        @else
                                                            {{ $item['currency'] }}
                                                            {{ \App\Http\Utils\StringDatabase::executeNiceNumber($item['boatPrice']) }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $fullDetail = \App\Http\Utils\StringDatabase::executeStringToHtml($item['boat_details']);
                                            ?>
                                            <div class="boat-description">
                                                @if (strlen($item['boat_details']) > 88)
                                                    <?php
                                                    $detail = substr($fullDetail, 0, 88);
                                                    ?>
                                                    {{ strip_tags($detail) }}...
                                                @else
                                                    {{ strip_tags($fullDetail) }}
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
                                                <div class="feature"><span>GPS:</span><span>
                                                @if ($item['gps'])
                                                YES
                                                @else
                                                NO
                                                @endif
                                                </span></div>
                                                <div class="feature"><span>Aircon:</span><span>
                                                @if ($item['aircon'])
                                                YES
                                                @else
                                                NO
                                                @endif
                                                </span></div>
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
                                                        $item['facilities'] = json_decode(json_encode($item['facilities']), true);
                                                    @endphp
                                                    @if (is_countable($item['facilities']))
                                                        @if (count($item['facilities']) > 0)
                                                            @if ($item['facilities']['air_conditioning'] > '0')
                                                                <img src="../images/product-detail/facilities/air-condition.png"
                                                                    alt="">
                                                            @endif
                                                            @if ($item['facilities']['jacuzzi'] > '0')
                                                                <img src="../images/product-detail/facilities/jacuzzi.png"
                                                                    alt="Jacuzzi">
                                                            @endif
                                                            @if ($item['facilities']['toilet'] > '0')
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


    @push('scripts')
        @if (!empty($data['dataDisplay']))
            <script type="text/javascript">
                $(document).ready(function() {
                    <?php  foreach ($data['dataDisplay'] as $item) { ?>
                    if ($('#item-{{ $item['boat_id'] }}').length) {
                        $('[id="item-{{ $item['boat_id'] }}"]:gt(0)').remove();
                    }

                    <?php } ?>
                });
            </script>
        @endif
    @endpush
@endsection
