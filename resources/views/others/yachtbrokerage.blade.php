@extends('index')
@section('content')
    <div class="yacht-brokerage-page">
        <div class="yacht-brokerage-header">
            <div class="background"><img src="../images/yacht-brokerage/header.jpg"></div>
            <div class="container">
                <div class="wrapper">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Yacht Brokerage</li>
                        </ol>
                    </div>
                    <div class="page-title">
                        <div class="title">YACHT&nbsp;<strong>BROKERAGE</strong></div>
                        <div class="description">
                            <p><strong>Want to own a yacht?</strong></p>
                            <p>We have the best deal here on Trident Marine Asia!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="yacht-brokerage-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="filter">
                            <form>
                                <p class="title">Filter Yacht For Sale</p>
                                <div class="form-group">
                                    <label>Boat Make</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Boat Model</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Length Range</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Passenger</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Price Range</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. Of Engine</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Fuel</label>
                                    <select name="boat_make">
                                        <option value="">SELECT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Keyword</label>
                                    <input type="text">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="button button-highlight">FILTERED SEARCH</button>
                                    <button type="reset" class="button">CLEAR FILTER</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="yacht-list">
                            <p class="note">Note that the prices of boats shown here are the indicative prices in Singapore dollars. Please contact us for any more information or to view any of these boats.</p>
                            <div class="yachts">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="yacht">
                                            <div class="image"><img src="../images/yacht-brokerage/1.jpg" alt=""></div>
                                            <p class="title">CENTRE CONSOLE</p>
                                            <p class="description">Centre Console boats are usually from 13'45'. They are so-named because their..</p><a class="more button button-highlight" href="#">MORE INFO</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="yacht-pagination">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">First</a></li>
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                <li class="page-item"><a class="page-link" href="#">Last</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
