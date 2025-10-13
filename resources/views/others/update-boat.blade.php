@extends('index')
@section('content')
<div class="add-boat-page bottom-background">
        <div class="page-nav account-page-nav">
          <div class="container">
            <div class="wrapper">
              <div class="breadcrumb-wrapper">
                <div class="page-breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Upgrade Account</a></li>
                    <li class="breadcrumb-item active">Update Boat</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-content account-page-content">
          <div class="container">
            <div class="page-wrapper">
              <h1 class="account-page-title">Update Boat</h1>
              <div class="row">
                <div class="col-lg-9 col-md-12">
                  <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="boat_id" value="{{ $boat->boat_id }}">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="form-group col-lg-12">
                        <label class="form-label">Boat Name<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[boat_name]" value="{{ $boat->boat_name }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Boat Reg<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[boat_reg]" value="{{ $boat->boat_reg }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">MMSI<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[mmsi]" value="{{ $boat->mmsi }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Insurance</label>
                        <input class="form-input form-item" name="boatData[insurance_no]" value="{{ $boat->insurance_no }}">
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Insurar</label>
                        <input class="form-input form-item" name="boatData[insurar]" value="{{ $boat->insurar }}">
                      </div>
                      <div class="form-group date-item col-lg-12 has-datepicker">
                        <label class="form-label">Insurance Expiry</label>
                        <input class="form-input form-item" name="boatData[insurance_exp]" value="{{ $boat->insurance_exp }}">
                      </div>
                      <div class="form-group date-item col-lg-12 has-datepicker">
                        <label class="form-label">Last Inspection</label>
                        <input class="form-input form-item" name="boatData[last_inspection]" value="{{ $boat->last_inspection }}">
                      </div>
                      <div class="form-group date-item col-lg-12 has-datepicker">
                        <label class="form-label">Next Inspection</label>
                        <input class="form-input form-item" name="boatData[next_inspection]" value="{{ $boat->next_inspection }}">
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Country<span class="required">*</span></label>
                        <select class="form-select form-item" name="boatData[country]" required>
                            <option value="">Select</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['name'] }}" {{ $country['name'] === $boat->country ? 'selected' : '' }}>{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Boat Type<span class="required">*</span></label>
                        <select class="form-select form-item" name="boatData[boat_type_tma]" required>
                          <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{ $category['categoryId'] }}" {{ $category['categoryId'] === $boat->boat_type_tma ? 'selected' : '' }}>{{ $category['categoryName'] }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Marina<span class="required">*</span></label>
                        <select class="form-select form-item" name="boatData[marina]" required>
                          <option value="">Select</option>
                            @foreach($marinas as $marina)
                            <option value="{{ $marina->marinas_id }}" {{ $marina->marinas_id === $boat->marina ? 'selected' : '' }}>{{ $marina->marinas_name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Fuel Type</label>
                        <select class="form-select form-item" name="boatData[fuel_type]">
                          <option value="Petrol" {{ $boat->fuel_type === 'Petrol' ? 'selected' : '' }}>Petrol</option>
                          <option value="Diesel" {{ $boat->fuel_type === 'Diesel' ? 'selected' : '' }}>Diesel </option>
                        </select>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Fuel Consumption (KM/Lire)</label>
                        <input class="form-input form-item" name="boatData[fuel_consumption]" value="{{ $boat->fuel_consumption }}">
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Pax<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[pax]" value="{{ $boat->pax }}" required>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Booking Date Manageable?</label>
                        <label>
                          <input type="radio" name="boatData[manage]" value="1" {{ $boat->manage == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[manage]" value="0" {{ $boat->manage == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Party</label>
                        <label>
                          <input type="radio" name="boatData[party]" value="1" {{ $boat->party == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[party]" value="0" {{ $boat->party == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Fishing</label>
                        <label>
                          <input type="radio" name="boatData[fishing]" value="1" {{ $boat->fishing == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[fishing]" value="0" {{ $boat->fishing == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Wakeboarding</label>
                        <label>
                          <input type="radio" name="boatData[wakeboarding]" value="1" {{ $boat->wakeboarding == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[wakeboarding]" value="0" {{ $boat->wakeboarding == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Cruising</label>
                        <label>
                          <input type="radio" name="boatData[cruising]" value="1" {{ $boat->cruising == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[cruising]" value="0" {{ $boat->cruising == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">VHF</label>
                        <label>
                          <input type="radio" name="boatData[vhf]" value="1" {{ $boat->vhf == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[vhf]" value="0" {{ $boat->vhf == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Fishfinder</label>
                        <label>
                          <input type="radio" name="boatData[fishfinder]" value="1" {{ $boat->fishfinder == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[fishfinder]" value="0" {{ $boat->fishfinder == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">GPS</label>
                        <label>
                          <input type="radio" name="boatData[gps]" value="1" {{ $boat->gps == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[gps]" value="0" {{ $boat->gps == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Aircon</label>
                        <label>
                          <input type="radio" name="boatData[aircon]" value="1" {{ $boat->aircon == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[aircon]" value="0" {{ $boat->aircon == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Head</label>
                        <label>
                          <input type="radio" name="boatData[head]" value="1" {{ $boat->head == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[head]" value="0" {{ $boat->head == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Engine Type</label>
                        <label>
                          <input type="radio" name="boatData[engine_type]" value="inboard" {{ $boat->engine_type == 'inboard' ? 'checked' : '' }}>Inboard
                        </label>
                        <label>
                          <input type="radio" name="boatData[engine_type]" value="outboard" {{ $boat->engine_type == 'outboard' ? 'checked' : '' }}>Outboard
                        </label>
                        <label>
                          <input type="radio" name="boatData[engine_type]" value="shaft" {{ $boat->engine_type == 'shaft' ? 'checked' : '' }}>Shaft
                        </label>
                      </div>
                      <div class="form-group col-lg-12 has-checkbox">
                        <label class="form-label">Self-drive</label>
                        <label>
                          <input type="radio" name="boatData[self_drive]" value="1" {{ $boat->self_drive == '1' ? 'checked' : '' }}>Yes
                        </label>
                        <label>
                          <input type="radio" name="boatData[self_drive]" value="0" {{ $boat->self_drive == '0' ? 'checked' : '' }}>No
                        </label>
                      </div>
                      <div class="form-group col-lg-12 no-input">
                        <label class="form-label">Status</label>
                        <p class="new-icon-indicator">New Boat</p>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">No. of Engine<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[no_engine]" value="{{ $boat->no_engine }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Beam (M)<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[beam]" value="{{ $boat->beam }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Length (M)<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[length]" value="{{ $boat->length }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Built Year (YYYY)<span class="required">*</span></label>
                        <input class="form-input form-item" name="boatData[year_create]" value="{{ $boat->year_create }}" required>
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Others</label>
                        <input class="form-input form-item" name="boatData[other]" value="{{ $boat->other }}">
                      </div>
                      <div class="form-group col-lg-12 has-datepicker">
                        <label class="form-label">Last Maintenance Date</label>
                        <input class="form-input form-item" name="boatData[last_maintain]" value="{{ $boat->last_maintain }}">
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Last Engine Hour</label>
                        <input class="form-input form-item" name="boatData[last_engine_hour]" value="{{ $boat->last_engine_hour }}">
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Description</label>
                        <input class="form-input form-item" name="boatData[boat_details]" value="{{ $boat->boat_details }}">
                      </div>
                      <div class="form-group col-lg-12">
                        <label class="form-label">Note About Boat</label>
                        <input class="form-input form-item" name="boatData[boatnote]" value="{{ $boat->boatnote }}">
                      </div>
                      <div class="form-group col-lg-12 has-file">
                        <label class="form-label">Charter Contract</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="contractpaper">
                          @if (empty($boat->contractpaper))
                            <br />
                            <a href="{{ url('pdf', $boat->contractpaper) }}">[View]</a>
                          @endif
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file">
                        <label class="form-label">Brokerage Contract</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="contractpdf">
                          @if (!empty($boat->contractpdf))
                            <br />
                            <a href="{{ url('pdf', $boat->contractpdf) }}">[View]</a>
                          @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <p class="explain"><span>Please fill up the PDF form, sign it and upload it for validation before your boat is approved for charter. Allow us up to 48 hours for approval.</span><a href="#">Download sample Contract</a></p>
                      </div>
                      <div class="form-group col-lg-12 has-file">
                        <label class="form-label">Itinerary PDF 1</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="contractpdf1">
                          @if (!empty($boat->contractpdf1))
                            <br />
                            <a href="{{ url('pdf', $boat->contractpdf1) }}">[View]</a>
                          @endif
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file">
                        <label class="form-label">Itinerary PDF 2</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="contractpdf2">
                          @if (!empty($boat->contractpdf2))
                            <br />
                            <a href="{{ url('pdf', $boat->contractpdf2) }}">[View]</a>
                          @endif
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file">
                        <label class="form-label">Itinerary PDF 2</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="contractpdf2">
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file">
                        <label class="form-label">Main Boat Image</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="main_photo">
                          @if (!empty($boat->main_photo))
                            <input type="hidden" name="remove_main_photo" value="0">
                              <div class="main_photo-image">
                                <img src="{{ url('images/product', $boat->main_photo) }}" class="small-thumbnail">
                                <a href="#" onclick="$('[name=remove_main_photo]').val('1'); $('.main_photo-image').remove(); return false;">[Remove]</a>
                              </div>
                          @endif
                        </div>
                        <div>
                          <a href="#" onclick="$('.photo1').removeClass('hidden'); return false;">[+]</a>
                        </div>
                      </div>
                      <div class="form-group">
                        <p class="explain">Click on the (+) sign to add more or delete already uploaded photo</p>
                      </div>
                      <div class="form-group col-lg-12 has-file photo1 hidden">
                        <label class="form-label">Photo 1</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="photo1">
                          @if (!empty($boat->photo1))
                            <input type="hidden" name="remove_photo1" value="0">
                            <div class="photo1-image">
                              <img src="{{ url('images/product', $boat->photo1) }}" class="small-thumbnail">
                              <a href="#" onclick="$('[name=remove_photo1]').val('1'); $('.photo1-image').remove(); return false;">[Remove]</a>
                            </div>
                          @endif
                        </div>
                        <div>
                          <a href="#" onclick="$('.photo2').removeClass('hidden'); return false;">[+]</a>
                          <a href="#" onclick="$('.photo1').addClass('hidden'); return false;">[-]</a>
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file photo2 hidden">
                        <label class="form-label">Photo 2</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="photo2">
                          @if (!empty($boat->photo2))
                            <input type="hidden" name="remove_photo2" value="0">
                              <div class="photo2-image">
                                <img src="{{ url('images/product', $boat->photo2) }}" class="small-thumbnail">
                                <a href="#" onclick="$('[name=remove_photo2]').val('1'); $('.photo2-image').remove(); return false;">[Remove]</a>
                              </div>
                          @endif
                        </div>
                        <div>
                          <a href="#" onclick="$('.photo3').removeClass('hidden'); return false;">[+]</a>
                          <a href="#" onclick="$('.photo2').addClass('hidden'); return false;">[-]</a>
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file photo3 hidden">
                        <label class="form-label">Photo 3</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="photo3">
                          @if (!empty($boat->photo3))
                              <input type="hidden" name="remove_photo3" value="0">
                              <div class="photo3-image">
                                <img src="{{ url('images/product', $boat->photo3) }}" class="small-thumbnail">
                                <a href="#" onclick="$('[name=remove_photo3]').val('1'); $('.photo3-image').remove(); return false;">[Remove]</a>
                              </div>
                          @endif
                        </div>
                        <div>
                          <a href="#" onclick="$('.photo4').removeClass('hidden'); return false;">[+]</a>
                          <a href="#" onclick="$('.photo3').addClass('hidden'); return false;">[-]</a>
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file photo4 hidden">
                        <label class="form-label">Photo 4</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="photo4">
                          @if (!empty($boat->photo4))
                            <input type="hidden" name="remove_photo4" value="0">
                              <div class="photo4-image">
                                <img src="{{ url('images/product', $boat->photo4) }}" class="small-thumbnail">
                                <a href="#" onclick="$('[name=remove_photo4]').val('1'); $('.photo4-image').remove(); return false;">[Remove]</a>
                              </div>
                          @endif
                        </div>
                        <div>
                          <a href="#" onclick="$('.photo5').removeClass('hidden'); return false;">[+]</a>
                          <a href="#" onclick="$('.photo4').addClass('hidden'); return false;">[-]</a>
                        </div>
                      </div>
                      <div class="form-group col-lg-12 has-file photo5 hidden">
                        <label class="form-label">Photo 5</label>
                        <div class="file-wrapper">
                          <input class="form-input form-item" type="file" name="photo5">
                          @if (!empty($boat->photo5))
                              <input type="hidden" name="remove_photo5" value="0">
                              <div class="photo5-image">
                                <img src="{{ url('images/product', $boat->photo5) }}" class="small-thumbnail photo5-image">
                                <a href="#" onclick="$('[name=remove_photo5]').val('1'); $('.photo5-image').remove(); return false;">[Remove]</a>
                              </div>
                          @endif
                        </div>
                        <div>
                          <a href="#" onclick="$('.photo5').addClass('hidden'); return false;">[-]</a>
                        </div>
                      </div>
                      <div class="form-group submit-form">
                        <button class="button button-highlight">SUBMIT</button>
                      </div>
                      <div class="form-group">
                        <p class="explain bold-explain">Note: After activation of your boat, you cannot edit your boat details.</p>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-lg-3 col-md-12">
                  <div class="contact-box">
                    <p class="contact-box-title">Contact Details</p>
                    <p class="call">For more information, call:<a class="phone-number" href="tel:+65 3163 1367">+65 3163 1367</a></p>
                    <p class="email">or you can email us anytime<a class="email-address" href="mailto:sales@tridentmarineasia.com">sales@tridentmarineasia.com</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection