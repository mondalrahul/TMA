@extends('index')
@section('content')
    <div class="my-boat-page bottom-background">
        <div class="page-nav account-page-nav">
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <div class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">My Boats</a></li>
                                <li class="breadcrumb-item active">My Boat Listing</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content account-page-content">
            <div class="container">
                <div class="page-wrapper">
                    <h1 class="account-page-title">My Boats</h1>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="boat-list-search">
                                <h2>Search Booking</h2>
                                <form>
                                    <div class="filter">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row row-item">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-3"><span class="filter-item">Boat Name</span>
                                                            </div>
                                                            <div class="col-lg-9">
                                                                <input class="full-width" type="text" name="boat_name"
                                                                    value="{{ $filterData['boat_name'] }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-item">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-3"><span class="filter-item">Marina</span>
                                                            </div>
                                                            <div class="col-lg-9">
                                                                <select class="full-width" name="marina">
                                                                    <option value="">Select</option>
                                                                    @foreach ($marinas as $marina)
                                                                        <option value="{{ $marina->marinas_id }}"
                                                                            {{ $marina->marinas_id == $filterData['marina'] ? 'selected' : '' }}>
                                                                            {{ $marina->marinas_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row row-item">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-3"><span class="filter-item">Boat Type</span>
                                                            </div>
                                                            <div class="col-lg-9">
                                                                <select class="full-width" name="boat_type">
                                                                    <option value="">Select</option>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->category_id }}"
                                                                            {{ $category->category_id == $filterData['boat_type'] ? 'selected' : '' }}>
                                                                            {{ $category->category_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="font-700 no-margin">Search by alphabet</p>
                                                <div class="boat-list-filter">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <a href="{{ url('my-boats') }}">ALL</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=A') }}">A</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=B') }}">B</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=C') }}">C</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=D') }}">D</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=E') }}">E</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=F') }}">F</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=G') }}">G</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=H') }}">H</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=I') }}">I</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=J') }}">J</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=K') }}">K</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=L') }}">L</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=M') }}">M</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=N') }}">N</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=O') }}">O</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=P') }}">P</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=Q') }}">Q</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=R') }}">R</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=S') }}">S</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=T') }}">T</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=U') }}">U</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=V') }}">V</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=W') }}">W</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=X') }}">X</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=Y') }}">Y</a><span
                                                                class="separate">|</span>
                                                            <a href="{{ url('my-boats/?start_with=Z') }}">Z</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit">
                                        <button class="button button-highlight">SEARCH NOW</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="boat-list-filter">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a href="{{ url('my-boats') }}">All ({{ array_sum($boatStatus) }})</a>
                                        <span class="separate">|</span>
                                        <a href="{{ url('my-boats?status=y') }}">Active ({{ $boatStatus['y'] }})</a>
                                        <span class="separate">|</span>
                                        <a href="{{ url('my-boats?status=p') }}">Need Payment
                                            ({{ $boatStatus['p'] }})</a>
                                        <span class="separate">|</span>
                                        <a href="{{ url('my-boats?status=n') }}">Inactive ({{ $boatStatus['n'] }})</a>
                                        <span class="separate">|</span>
                                        <a href="{{ url('my-boats/add') }}">Add New</a>
                                        <span class="separate">|</span>
                                        <a href="#"
                                            onclick="$('[name=\'boat_id[]\']').prop('checked', true); return false;">Check
                                            All</a>
                                        <span class="separate">|</span>
                                        <a href="#"
                                            onclick="$('[name=\'boat_id[]\']').prop('checked', false); return false;">Uncheck
                                            All</a>
                                        <span class="separate">|</span>
                                        <a class="red" href="#"
                                            onclick="return deleteMyBoats($('[name=\'boat_id[]\']:checked').map(function(index, item) { return $(item).val() }).get());">Delete</a>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        Found <span class="color-highlight">{{ $boats->total() }}</span> records. Showing
                                        <span
                                            class="color-highlight">{{ $boats->total() ? $boats->firstItem() : 0 }}</span>
                                        to <span
                                            class="color-highlight">{{ $boats->total() ? $boats->lastItem() : 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="boat-list-table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Book ID</th>
                                            <th>Boat Name</th>
                                            <th>Type</th>
                                            <th>Address</th>
                                            <th>Product Image</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
                                            <th>Last Updated</th>
                                            <th>View Calendar</th>
                                            <th>Set Calendar</th>
                                            <th>Boat Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($boats as $boat)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="boat_id[]"
                                                        value="{{ $boat->boat_id }}">
                                                </td>
                                                <td>{{ $boat->boat_id }}</td>
                                                <td>
                                                    <p>{{ $boat->boat_name }}</p>
                                                </td>
                                                <td>{{ $boat->category_name }}</td>
                                                <td>
                                                    <p>{{ $boat->marinas_name }}</p>
                                                    <p>{{ $boat->country }}</p>
                                                </td>
                                                <td>
                                                    <a href="#">
                                                        <img class="product-thumbnail"
                                                            src="{{ url('images/product/' . $boat->main_photo) }}"
                                                            alt="">
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @if ($boat->status === 'y')
                                                        <p><img src="../images/new.png" alt=""></p>
                                                        <p>Active</p>
                                                    @elseif ($boat->status === 'n')
                                                        <p>Inactive</p>
                                                    @else
                                                        <p>Need Payment</p>
                                                    @endif
                                                </td>
                                                <td>{{ $boat->add_date }}</td>
                                                <td>{{ $boat->date_updated < $boat->add_date ? $boat->add_date : $boat->date_updated }}
                                                </td>
                                                <td class="text-center"><a class="view-calendar-button"
                                                        href="{{ url('boat-book-calendar', $boat->boat_id) }}"></a></td>
                                                <td class="text-center"><a class="set-calendar-button"
                                                        href="#"></a></td>
                                                <td class="text-center"><a class="boat-detail-button"
                                                        href="{{ url('my-boats/update', $boat->boat_id) }}"></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $boats->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
