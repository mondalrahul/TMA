"use strict";

function show_alert(message, icon) {
  swal({
    text: message,
    icon: icon,
    button: "OK",
  });
}
$(document).ready(function () {
  $("#forgotRating").modal();
  $(".has-datepicker .form-input").datepicker({
    format: "yyyy-mm-dd",
  });
  /*$('#boat-calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month'
          },
          views: {
              month: {
                  columnFormat:'dddd'
              }
          },
          events: [
              {
                title: 'All Day Event',
                start: '2018-02-01',
              },
              {
                title: 'Long Event',
                start: '2018-02-07',
                end: '2018-02-10'
              },
              {
                id: 999,
                title: 'Repeating Event',
                start: '2018-02-09T16:00:00'
              },
              {
                id: 999,
                title: 'Repeating Event',
                start: '2018-02-16T16:00:00'
              },
              {
                title: 'Conference',
                start: '2018-02-2',
                end: '2018-02-13'
              },
              {
                title: 'Meeting',
                start: '2018-02-12T10:30:00',
                end: '2018-02-12T12:30:00'
              },
              {
                title: 'Lunch',
                start: '2018-02-12T12:00:00'
              },
              {
                title: 'Meeting',
                start: '2018-02-12T14:30:00'
              },
              {
                title: 'Happy Hour',
                start: '2018-02-12T17:30:00'
              },
              {
                title: 'Dinner',
                start: '2018-02-12T20:00:00'
              },
              {
                title: 'Birthday Party',
                start: '2018-02-13T07:00:00'
              },
              {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2018-02-28'
              }
            ]
      });*/
  window.datesWithTimeSlot = [];
  ajaxSetup();

  $(".package-enquire").click(function () {
    $("#contactEnquiryModal").modal();
    return false;
  });

  $("#btn-send-enquiry").on("click", function (e) {
    e.preventDefault();
    var user_name = $("[name=enquiry_user_name]").val();
    var user_email = $("[name=enquiry_user_email]").val();
    var user_phone = $("[name=enquiry_user_phone]").val();
    var user_alter_phone = $("[name=enquiry_user_alter_phone]").val();
    var user_selected_date = $("[name=enquiry_user_selected_date]").val();
    var user_other_info = $("[name=enquiry_user_other_info]").val();
    var book_boat_name = $('[name="book-boat-name"]').val();
    var charter_agreement = $("[name=book-sea-sports-list]").is(":checked");
    var charter_seas_sports_lists_ids = $("[name=js-seas-sports-lists]").val();

    if (
      user_name.trim().length === 0 ||
      user_email.trim().length === 0 ||
      user_selected_date.trim().length === 0
    ) {
      alert("Please enter your name, email and selected date to continue.");
      return false;
    }

    var form_values = {
      enquiry_user_name: user_name,
      enquiry_user_email: user_email,
      enquiry_user_phone: user_phone,
      enquiry_user_alter_phone: user_alter_phone,
      enquiry_user_selected_date: user_selected_date,
      enquiry_user_other_info: user_other_info,
      enquiry_book_boat_name: book_boat_name,
      charter_agreement: charter_agreement,
      charter_seas_sports_lists_ids: charter_seas_sports_lists_ids,
    };
    ajaxSetup();
    ajaxSend("/send-mail/enquiry-box", form_values, "email-enquiry", "POST");
  });

  $("#btn-send-wire-transfer").on("click", function (e) {
    var wire_transfer_email = $("[name=wire_transfer_email]").val();
    var boat_id = $("[name=boat_id]").val();
    var booked_time_date = $("[name=book-time-date]").val();
    var booked_time_list = $("[name=book-time-list]").val();
    var booked_skipper = $("[name=book-skipper]:checked").val();
    var charter_agreement = $("[name=book-sea-sports-list]").is(":checked");
    var charter_rate = $("[name=boat-rate-from]").val();
    var addition_request = $("[name=additional_info]").val();
    var additional_deposite = $("#additional_deposite").val();
    var country = $("#country").val();
    var charter_seas_sports_lists_ids = $("[name=js-seas-sports-lists]").val();
    var discount_type = $("[name=discount_type]").val();
    var credit_id = $("[name=credit_id]").val();
    var discount_price = $("[name=discount_price]").val();
    var membership_id = $("[name=membership_id]").val();

    var form_values = {
      payment_method:
        $("select.payment-methods").val() === "wire-transfer"
          ? "Bank Account Transfer"
          : "Paypal",
      boat_id: boat_id,
      wire_transfer_email: wire_transfer_email,
      addition_request: addition_request,
      charter_rate: charter_rate,
      additional_deposite: additional_deposite,
      booked_time_date: booked_time_date,
      booked_time_list: booked_time_list,
      booked_skipper: booked_skipper,
      charter_agreement: charter_agreement,
      country: country,
      charter_seas_sports_lists_ids: charter_seas_sports_lists_ids,
      discount_type: discount_type,
      credit_id: credit_id,
      discount_price: discount_price,
      membership_id: membership_id,
    };
    console.log(wire_transfer_email);
    if (wire_transfer_email.trim().length === 0) {
      alert("Please enter all information to continue");
      return false;
    }
    $("#wireTransferModal").modal("hide");
    ajaxSetup();
    ajaxBookConfirm(
      "/boat-book/booking-confirm",
      form_values,
      "valid_date",
      "GET"
    );
  });

  var time = moment();
  var startOfMonth = time.startOf("month").format("YYYY-MM-DD");
  var endOfMonth = time.endOf("month").format("YYYY-MM-DD");
  getDatesWithTimeSlot(startOfMonth, endOfMonth);

  $("input[type=password]").on("keyup", function () {
    $('input[name="user_password_hidden"]').val($(this).val());
  });
  $(document).on("click", "#register_btn", function (e) {
    e.preventDefault();
    // get value form
    var user_name = $('input[name="name"]').val();
    var user_email = $('input[name="user_email"]').val();
    var user_address = $('input[name="user_address"]').val();
    var user_country = $('select[name="user_country"] :selected').text();
    var user_state = $('select[name="user_state"] :selected').text();
    var user_zip = $('input[name="user_zip"]').val();
    var user_phone = $('input[name="user_phone"]').val();
    var user_password = $('input[name="user_password_hidden"]').val();
    var user_city = $('input[name="user_city"]').val();
    // var captcha = $("#g-recaptcha-response").val();

    var form_values = {
      name: user_name,
      user_email: user_email,
      user_address: user_address,
      user_country: user_country,
      user_state: user_state,
      user_zip: user_zip,
      user_phone: user_phone,
      user_password: user_password,
      user_city: user_city,
      // captcha: captcha
    };

    ajaxSetup();
    /*  $.ajax({
                  url: 'https://www.theboatshopasia.com/googlesheet/quickstart.php',
                  data: { name : form_values , user_email : user_email, user_address : user_address, user_state : user_state, user_zip: user_zip, user_phone : user_phone },
                  dataType: 'PHP',
                  type: 'POST',
                  success: function (result) {
                  alert(result);
                  }
               });*/
    ajaxSend("/register", form_values, "register", "POST");
  });

  // update my account
  $("#btn-update-account").on("click", function (e) {
    e.preventDefault();

    // get value form
    var user_name = $('input[name="user_name"]').val();
    var user_email = $('input[name="user_email"]').val();
    var user_address = $('input[name="user_address"]').val();
    var user_country = $('input[name="user_country"]').val();
    var user_state = $('input[name="user_state"]').val();
    var user_zip = $('input[name="user_zip"]').val();
    var user_phone = $('input[name="user_phone"]').val();
    var user_password = $('input[name="user_password"]').val();
    var user_city = $('input[name="user_city"]').val();
    var isValid = true;

    if (user_name.trim().length == 0) {
      displayErrorHidden("user_name", "User name can not empty!");
      isValid = false;
    }
    if (user_email.trim().length == "") {
      displayErrorHidden("user_email", "User email can not empty!");
      isValid = false;
    }
    if (user_address.trim().length == "") {
      displayErrorHidden("user_address", "User address can not empty!");
      isValid = false;
    }
    if (user_country.trim().length == "") {
      displayErrorHidden("user_country", "User country can not empty!");
      isValid = false;
    }
    if (user_city.trim().length == "") {
      displayErrorHidden("user_city", "User city can not empty!");
      isValid = false;
    }
    if (user_password.trim().length == "") {
      displayErrorHidden("user_password", "User password can not empty!");
      isValid = false;
    }
    if (!isValid) {
      return;
    }
    $("#form_update_account").submit();
  });

  $("input[name=login_password]").on("keyup", function () {
    $('input[name="login_password_hidden"]').val($(this).val());
  });
  $(document).on("click", "#login_btn", function (e) {
    e.preventDefault();
    // get value form
    var login_email = $('input[name="login_email"]').val();
    var login_password = $('input[name="login_password"]').val();

    var form_values = {
      login_email: login_email,
      login_password: login_password,
    };
    ajaxSetup();
    ajaxSend("/login", form_values, "login", "POST");
  });

  $("#log-out").on("click", function () {
    ajaxSetup();
    ajaxSend("/logout", {}, "logout", "GET");
  });

  $("#td_country_search").on("change", function () {
    $("#form-search-trident-fleet").submit();
  });
  $("#td_price_search").on("change", function () {
    $("#form-search-trident-fleet").submit();
  });
  $("#item_display_search").on("change", function () {
    $("#form-search-trident-fleet").submit();
  });

  $("#h_people_number_search").on("change", function () {
    $("#form-search-trident-home").submit();
  });
  $("#h_occasion_search").on("change", function () {
    $("#form-search-trident-home").submit();
  });
  $("#h_boat_type_search").on("change", function () {
    $("#form-search-trident-home").submit();
  });
  $("#h_country_search").on("change", function () {
    $("#form-search-trident-home").submit();
  });
  $("#h_price_search").on("change", function () {
    $("#form-search-trident-home").submit();
  });
  $("#h_item_display_search").on("change", function () {
    $("#form-search-trident-home").submit();
  });

  print_country("user_country");
  print_state("user_state", 0);
  $("#user_country").on("change", function () {
    $("#user_state").empty();
    print_state("user_state", this.selectedIndex);
  });

  var date = new Date();
  date.setDate(date.getDate() + 2);
  // calendar
  $(".product-detail-calendar")
    .datepicker({
      startDate: date,
      todayHighlight: true,
    })
    .on("changeMonth", function (e) {
      var time = moment(e.date);
      var startOfMonth = time.startOf("month").format("YYYY-MM-DD");
      var endOfMonth = time.endOf("month").format("YYYY-MM-DD");
      getDatesWithTimeSlot(startOfMonth, endOfMonth);
    })
    .on("changeDate", function (e) {
      // init
      var datePicked = $(this).datepicker("getDate");
      var dateFormatted = formatDate(datePicked);
      $('[name="enquiry_user_selected_date"]').val(dateFormatted);
      $(".updatepricerefresh").css("opacity", "0.2");

      // reset
      $('input[type="hidden"][name="book-time-list"]').val("");
      $('input[type="hidden"][name="book-time-date"]').val(dateFormatted);

      resetBookBoatPrice();

      /*if (window.datesWithTimeSlot.indexOf(moment(e.date).format('YYYY-MM-DD')) === -1) {
                      $('#enquiryModal').modal();
                      return false;
                  }*/

      // Reset price on date change
      calBookTimePrice();

      // display book charter
      var nameMonth = getNameOfMonth(datePicked);
      var contentCharter =
        '<p>Charter Date: <span class="highlight">' +
        datePicked.getDate() +
        " " +
        nameMonth +
        " " +
        datePicked.getFullYear() +
        "</span></p>";
      $("#book-charter-date").html(contentCharter);

      var boatId = $('input[name="boat_id"]').val();
      // validate
      var ajax_values = {
        datePicked: dateFormatted,
        boatId: boatId,
        currency: getParam("currencyCountry"),
      };
      ajaxSetup();
      ajaxSend("/boat-book/validDate", ajax_values, "valid_date", "GET");
    });
  // event book time
  $(document).on("click", 'input[name="book-time-item"]', function () {
    calBookTimePrice();
  });
  $('input[name="book-skipper"]').on("change", function () {
    if ($('[name="book-skipper"]:checked').val() === "1") {
      $("#div-skipper-rate").removeClass("hidden");
    } else {
      $("#div-skipper-rate").addClass("hidden");
    }
    if (needCalBookTimePrice()) {
      calBookTimePrice();
    }
  });

  // send contact
  $("#btn-send-contact").on("click", function (e) {
    e.preventDefault();
    var first_name = $('[name="first_name"]').val();
    var last_name = $('[name="last_name"]').val();
    var email = $('[name="email"]').val();
    var message = $('[name="message"]').val();
    if (first_name === "") {
      $("#first_name_error").text("First name can not empty");
      $("#first_name_error").show();
      return;
    }
    if (last_name === "") {
      $("#last_name_error").text("Last name can not empty");
      $("#last_name_error").show();
      return;
    }
    if (email === "") {
      $("#email_error").text("Email can not empty");
      $("#email_error").show();
      return;
    }
    if (message === "") {
      $("#message_error").text("Message can not empty");
      $("#message_error").show();
      return;
    }
    $("#form_contact").submit();
  });

  $(document).on("click", "#enquiry-now", function () {
    var bookTimeDate = $('input[type="hidden"][name="book-time-date"]').val();
    // if (bookTimeDate === '') {
    //     alert('Please choose valid date before enquiry.');
    //     return;
    // }
    $("#enquiryModal").modal();
    return false;
  });

  // Proceed checkout
  $(document).on("click", "#proceed-to-checkout", function (e) {
    e.preventDefault();
    var payment_option = $("select.payment-methods").val();
    if (payment_option === "wire-transfer") {
      if ($('[name="charter-agreement"]').is(":checked") === false) {
        alert(
          "You must check into Charter Agreement before Proceed to checkout."
        );
        return;
      }
      $("#wireTransferModal").modal();

      return;
    } else {
      console.log(payment_option);
      var loginUser = $('[name="login-user-name"]').val();
      var datePicked = $(".product-detail-calendar").datepicker("getDate");
      if ($('input[type="hidden"][name="book-time-date"]').val() === "") {
        alert("Please choose valid date before Proceed to checkout.");
        return;
      }
      var bookTimeList = $("#book-time-list").val();
      if (loginUser === "") {
        alert("You must login before Proceed to checkout.");
        return;
      }
      if (datePicked === "" || datePicked === null) {
        alert("You must choose date time before Proceed to checkout.");
        return;
      }
      if (bookTimeList === "") {
        alert("You must choose time slot before Proceed to checkout.");
        return;
      }
      if ($('[name="charter-agreement"]').is(":checked") === false) {
        alert(
          "You must check into Charter Agreement before Proceed to checkout."
        );
        return;
      }
    }

    var boat_id = $("[name=boat_id]").val();
    var booked_time_date = $("[name=book-time-date]").val();
    var booked_time_list = $("[name=book-time-list]").val();
    var booked_skipper = $("[name=book-skipper]:checked").val();
    var additional_deposite = $("#additional_deposite").val();
    var charter_agreement = $("[name=book-sea-sports-list]").is(":checked");
    var charter_rate = $("[name=boat-rate-from]").val();
    var addition_request = $("[name=additional_info]").val();
    var country = $("#country").val();
    var charter_seas_sports_lists_ids = $("[name=js-seas-sports-lists]").val();
    var discount_type = $("[name=discount_type]").val();
    var credit_id = $("[name=credit_id]").val();
    var discount_price = $("[name=discount_price]").val();
    var membership_id = $("[name=membership_id]").val();

    var payment_type;
    if (payment_option === "wire-transfer") {
      payment_type = "Bank Account Transfer";
    } else if (payment_option === "paypal") {
      payment_type = "Paypal";
    } else if (payment_option === "stripe") {
      payment_type = "Stripe";
    } else {
      payment_type = "Not Defined";
    }

    var form_values = {
      payment_method: payment_type,
      boat_id: boat_id,
      addition_request: addition_request,
      additional_deposite: additional_deposite,
      charter_rate: charter_rate,
      booked_time_date: booked_time_date,
      booked_time_list: booked_time_list,
      booked_skipper: booked_skipper,
      country: country,
      charter_agreement: charter_agreement,
      charter_seas_sports_lists_ids: charter_seas_sports_lists_ids,
      discount_type: discount_type,
      credit_id: credit_id,
      discount_price: discount_price,
      membership_id: membership_id,
    };
    ajaxSetup();
    ajaxBookConfirm("/boat-book/booking-confirm", form_values, "valid_date","GET");
  });

  $(document).on("click", "#btn-proceed-to-checkout", function (e) {
    console.log("Check");
    document.getElementById("proceed-to-checkout").disabled = true;
    setTimeout(function () {
      document.getElementById("proceed-to-checkout").disabled = false;
    }, 8000);
    // Process
    if (
      $("select.payment-methods").val() === "paypal" ||
      $("select.payment-methods").val() === "stripe"
    ) {
      $("#form-process-checkout").submit();
      return;
    }

    $("#btn-proceed-to-checkout").prop("disabled", "disabled");
    closeModalDialog("paypalConfirmModal");
    var wire_transfer_email = $("[name=wire_transfer_email]").val();
    var boat_id = $("[name=boat_id]").val();
    var booked_time_date = $("[name=book-time-date]").val();
    var booked_time_list = $("[name=book-time-list]").val();
    var booked_skipper = $("[name=book-skipper]:checked").val();
    var charter_agreement = $("[name=book-sea-sports-list]").is(":checked");
    var charter_seas_sports_lists_ids = $("[name=js-seas-sports-lists]").val();
    var comment = $("[name=additional_info]").val();
    var country = $("[name=country]").val();
    var discount_type = $("[name=discount_type]").val();
    var credit_id = $("[name=credit_id]").val();
    var discount_price = $("[name=discount_price]").val();
    var membership_id = $("[name=membership_id]").val();

    var form_values = {
      wire_transfer_email: wire_transfer_email,
      boat_id: boat_id,
      booked_time_date: booked_time_date,
      booked_time_list: booked_time_list,
      booked_skipper: booked_skipper,
      charter_agreement: charter_agreement,
      comment: comment,
      country: country,
      charter_seas_sports_lists_ids: charter_seas_sports_lists_ids,
      discount_type: discount_type,
      credit_id: credit_id,
      discount_price: discount_price,
      membership_id: membership_id,
    };

    ajaxSetup();
    ajaxSend(
      "/send-mail/wire-transfer",
      form_values,
      "email-wire-transfer",
      "POST"
    );
  });

  if ($('[name="message_checkout"]').length) {
    alert($('[name="message_checkout"]').val());
  }

  $(".create-account-btn").click(function () {
    // close login modal
    $("#loginModal").modal("hide");
    // show register modal
    $("#registerModal").modal("show");
  });

  $(".login-btn").click(function () {
    // close register modal
    $("#registerModal").modal("hide");
    // show login modal
    $("#loginModal").modal("show");
  });

  displayPaypalFee(".payment-methods");
  $(".payment-methods").on("change", function () {
    calBookTimePrice();
    displayPaypalFee(this);
  });
  $("#avatar-file").change(function (e) {
    var files = e.target.files;
    if (files.length !== 1) {
      return;
    }
    var file = files[0];
    var objectURL = URL.createObjectURL(file);
    $("#avatar-preview").attr("src", objectURL);
  });

  // sea sports
  // default not check
  $("[name=book-sea-sports-list]").prop("checked", false);
  resetFormSeaSport();
  // check change
  $("[name=book-sea-sports-list]").on("click", function () {
    if ($(this).is(":checked")) {
      $("#div-sea-sports-list").removeClass("hidden");
      calBookTimePrice();
      // addRemoveAddOnInput($(this));
    } else {
      $("#div-sea-sports-list").addClass("hidden");
      resetFormSeaSport();
      resetSeaSportDetails();
      calBookTimePrice();
      // addRemoveAddOnInput($(this));
    }
  });

  $("[name^=lists-sea-sports-]").on("change", function () {
    calBookTimePrice();
    // addRemoveAddOnInput($(this));
  });
});




function addRemoveAddOnInput(checkbox) {
  var checkboxValue = checkbox.data('id');
  var hiddenInputId = 'add-ons-' + checkboxValue;
  var hiddenInput = $('[id="' + hiddenInputId + '"]');

  if (checkbox.is(':checked')) {

    if (hiddenInput.length === 0) {
      var checkboxId = checkbox.data('id');
      $('<input>').attr({
        type: 'hidden',
        name: 'all-checked-add-ons[]',
        value: checkboxValue,
        id: hiddenInputId,
        'data-id': checkboxId
      }).appendTo('#form-process-checkout');
    }
  } else {
    if (hiddenInput.length > 0) {
      hiddenInput.remove();
    }
  }
  console.log('Done');
}



function calBookTimePrice() {
  var allCheckBoxes = $('.add-ons-checkboxes');

  allCheckBoxes.each(function () {
    $(this).prop('disabled', true);
  });




  var totalPrice = 0,
    excessDeposit = 0,
    skipperPrice = 0,
    price = 0,
    paypalFee = 0,
    seasportFee = 0;
  var listSeaSportsWithoutTimeSlots = [];
  var additional_deposite = $("#additional_deposite").val();
  var countTimeSlots = 0;
  var excessDeposit = parseInt(excessDeposit) + parseInt(additional_deposite);
  $("[name^=lists-sea-sports-]").each(function () {
    var elementName = this.getAttribute("name");
    var elementValue = $(this).val();
    var elementText = $("[name=hidden-" + elementName + "]").val();
    listSeaSportsWithoutTimeSlots.push({
      name: elementName,
      price: elementValue,
      text: elementText,
    });
  });

  $("[name=book-time-item]:checked").each(function () {
    countTimeSlots++;
    var data = $(this).data("data");
    excessDeposit += parseInt(data.excessDeposit);
    skipperPrice += parseInt(data.skipperPrice);
    price += parseInt(data.price);
    listSeaSportsWithoutTimeSlots.forEach(function (item, index) {
      if ($("[name=book-sea-sports-list]").is(":checked")) {
        if ($("[name=" + item.name + "]").is(":checked")) {
          seasportFee += parseInt(item.price);
          removeHidden("div-" + item.name);
          $(".price-" + item.name).html(item.price * countTimeSlots);
        } else {
          addHidden("div-" + item.name);
          $(".price-" + item.name).html(0);
        }
      } else {
        addHidden("div-" + item.name);
        $(".price-" + item.name).html(0);
      }
    });
  });

  // display when not select time slots
  if ($("[name=book-time-item]:checked").length === 0) {
    // sea sports brochure checked
    listSeaSportsWithoutTimeSlots.forEach(function (item, index) {
      if ($("[name=book-sea-sports-list]").is(":checked")) {
        if ($("[name=" + item.name + "]").is(":checked")) {
          seasportFee += parseInt(item.price);
          removeHidden("div-" + item.name);
          $(".price-" + item.name).html(item.price);
        } else {
          addHidden("div-" + item.name);
          $(".price-" + item.name).html(0);
        }
      } else {
        addHidden("div-" + item.name);
        $(".price-" + item.name).html(0);
      }
    });
  }

  if ($('input[name="book-skipper"]:checked').val() === "1") {
    excessDeposit = parseInt(additional_deposite);
    totalPrice = skipperPrice + price + seasportFee + excessDeposit;
  } else {
    skipperPrice = 0;
    totalPrice = excessDeposit + price + seasportFee;
  }

  if ($('[name="payment_method"]').val() === "paypal" || $('[name="payment_method"]').val() === "stripe") {
    paypalFee = (totalPrice * 3) / 100;
    totalPrice = totalPrice + paypalFee;
  }

  console.log(totalPrice);

  $(".excess-deposit").html(excessDeposit);
  $(".skipper-rate").html(skipperPrice);
  $(".total-price").html(totalPrice);
  $(".price-time-slot").html(price);
  $(".paypal-fee").html(paypalFee);
  var bookTimeLists = document.getElementsByName("book-time-item");
  var storeLists = $('input[type="hidden"][id="book-time-list"]');
  storeLists.val("");
  for (var i = 0; bookTimeLists[i]; ++i) {
    if (bookTimeLists[i].checked) {
      var oldValue = storeLists.val();
      if (oldValue !== "") {
        storeLists.val(oldValue + "," + bookTimeLists[i].value);
      } else {
        storeLists.val(bookTimeLists[i].value);
      }
    }
  }

  var storeSeaSportsLists = $("[name=js-seas-sports-lists]");
  storeSeaSportsLists.val("");
  listSeaSportsWithoutTimeSlots.forEach(function (item, index) {
    if ($("[name=" + item.name + "]").is(":checked")) {
      var oldValue = storeSeaSportsLists.val();
      if (oldValue !== "") {
        storeSeaSportsLists.val(
          oldValue + "," + item.name.substring(item.name.lastIndexOf("-") + 1)
        );
      } else {
        storeSeaSportsLists.val(
          item.name.substring(item.name.lastIndexOf("-") + 1)
        );
      }
    }
  });
  $(".updatepricerefresh").css("opacity", "0.1");
  if (
    $('[name="discount_type"]').val() == "0" ||
    $('[name="discount_type"]').val() == "1"
  ) {
    applydiscount($('[name="discount_type"]').val());
  }

  if ($("select[name=creditinfo]").val() != "") {
    var cval = $("select[name=creditinfo]").val();
    checkcreditavailable(cval);
  }

  /* -------------- Update Total Price -------------*/
  setTimeout(function () {
    var discountprice = $("#discount_price").val();
    var total_Price = $(".total-price").html();

    var totalPrice = parseFloat(total_Price) - parseFloat(discountprice);
    $(".updatepricerefresh").css("opacity", "1");
    $(".total-price").html(totalPrice);
  }, 2000);

  // console.log('func end');
  setTimeout(() => {
    allCheckBoxes.each(function () {
      $(this).prop('disabled', false);
    });
  }, 500);
}

function needCalBookTimePrice() {
  var bookTimeLists = document.getElementsByName("book-time-item");
  for (var i = 0; bookTimeLists[i]; ++i) {
    if (bookTimeLists[i].checked) {
      return true;
    }
  }
  return false;
}

function formatDate(date) {
  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();

  return year + "-" + (monthIndex + 1) + "-" + day;
}

function getNameOfMonth(date) {
  var nameMonthList = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  var monthIndex = date.getMonth();
  return nameMonthList[monthIndex];
}

function genCheckboxBookTime(data) {
  var divBookTime = $(".collection-book-time");
  data.forEach(function (item, index) {
    if (item.timeFrom > 12 && item.timeFrom < 24) {
      var timeFromType = "pm";
    } else {
      var timeFromType = "am";
    }
    if (item.timeTo > 12 && item.timeTo < 24) {
      var timeToType = "pm";
    } else {
      var timeToType = "am";
    }
    var itemHtml = $(
      '<label> <input type="checkbox" id="book-time-item-' +
      item.id +
      '" name="book-time-item" value="' +
      item.id +
      '">' +
      item.timeFrom.toFixed(2) +
      timeFromType +
      " to " +
      item.timeTo.toFixed(2) +
      timeToType +
      "</label>"
    );
    itemHtml.find("input").data("data", item);
    divBookTime.append(itemHtml);
    if (item.is_booked === true) {
      document.getElementById("book-time-item-" + item.id).disabled = true;
    }
  });
}

function resetFormRegister() {
  $('input[name="name"]').val("");
  $('input[name="user_email"]').val("");
  $('input[name="user_address"]').val("");
  $('input[name="user_zip"]').val("");
  $('input[name="user_phone"]').val("");
  $('input[name="user_password_hidden"]').val("");
  $('input[name="user_password"]').val("");
}

function resetFormLogin() {
  $('input[name="login_email"]').val("");
  $('input[name="login_password"]').val("");
  $('input[name="login_password_hidden"]').val("");
}

function resetBookBoatPrice() {
  $(".collection-book-time").html("");
  $(".price-time-slot").html(0);
  var additional_deposite = $("#additional_deposite").val();
  $(".excess-deposit").html(additional_deposite);
  $(".skipper-rate").html(0);
  $(".paypal-fee").html(0);
  $(".total-price").html(0);
  $("#credit_id").val("");
  $("#discount_price").val("0");
  $("#membership_id").val("0");
  $("#ifmember").addClass("d-none");
  $("#myCredits").addClass("d-none");
  if (document.getElementById("discount_type") !== null) {
    document.getElementById("discount_type").selectedIndex = "0";
  }
}

function resetFormEnquiry() {
  $('input[name="enquiry_user_name_user_name"]').val("");
  $('input[name="enquiry_user_name_user_email"]').val("");
  $('input[name="enquiry_user_name_user_phone"]').val("");
  $('input[name="enquiry_user_name_user_alter_phone"]').val("");
  $('input[name="enquiry_user_name_user_rate_from"]').val("");
  $('input[name="enquiry_user_name_user_other_info"]').val("");
}

function resetFormSeaSport() {
  $("div#div-sea-sports-list input[type='checkbox']").prop("checked", false);
  /* $('input[name="book-sea-sports-thrill"]').prop('checked', false);
       $('input[name="book-sea-sports-chill"]').prop('checked', false);
       $('input[name="book-sea-sports-fun"]').prop('checked', false);
       $('input[name="book-sea-sports-jetsurf"]').prop('checked', false);
       $('input[name="book-sea-sports-jetski"]').prop('checked', false);*/
}

function resetSeaSportDetails() {
  addHidden("div-thrill-pack-fee");
  addHidden("div-chill-pack-fee");
  addHidden("div-fun-pack-fee");
  addHidden("div-jetsurf-fee");
  addHidden("div-jetski-fee");
  $(".thrill-pack-fee").html(0);
  $(".chill-pack-fee").html(0);
  $(".fun-pack-fee").html(0);
  $(".jetsurf-fee").html(0);
  $(".jetski-fee").html(0);
}

function removeHidden(tagId) {
  $("#" + tagId).removeClass("hidden");
}

function addHidden(tagId) {
  $("#" + tagId).addClass("hidden");
}

function closeModalDialog(tagId) {
  $("#" + tagId).modal("hide");
}

/**
 * Set up for ajax
 */
function ajaxSetup() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
}

/**
 * Send ajax
 *
 * @param url
 * @param data
 * @param action
 */
function ajaxSend(url, data, action, type) {
  $.ajax({
    url: url,
    data: data,
    dataType: "json",
    type: type,
    success: function (result) {
      if (result.result === false) {
        console.log(result);
        switch (action) {
          case "login":
            if (!result.errors) {
              removeHidden("common_error");
              $("#common_error").text(
                "Email or password is wrong. Please check again."
              );
            } else {
              for (var key in result.errors) {
                removeHidden(key + "_error");
                $("#" + key + "_error").text(result.errors[key][0]);
              }
            }
            break;
          case "email-enquiry":
          case "email-wire-transfer":
            console.log(result);
            show_alert(result.message, "error");
            break;
          case "register":
            for (var key in result.errors) {
              removeHidden(key + "_error");
              $("#" + key + "_error").text(result.errors[key][0]);
            }
            break;
          case "valid_date":
            $(".collection-book-time").addClass("hidden");
            removeProcessCheckoutButton();
            createEnquiryButton();
            if (result.max_date) {
              var curDate = new Date();
              var datePicked = new Date(data.datePicked);
              if (curDate.getTime() > datePicked.getTime()) {
                $('input[type="hidden"][name="book-time-date"]').val("");
                alert("Please choose date is bigger or equal today.");
                return;
              }
              alert(
                "You can choose date " +
                result.max_date +
                " for valid time slots."
              );
            } else {
              //alert('No valid range time to book. Contact for more information');
            }
            break;
          case "boat_cal_price":
            alert("Wrong param");
            break;
        }
      } else {
        console.log(result);
        switch (action) {
          case "register":
            // close dialog
            closeModalDialog("registerModal");
            // hide error class
            $("#registerModal").find("div.alert-danger").addClass("hidden");
            // reset form input
            resetFormRegister();

            alert("Registration was successful, Please check your email!");

            break;
          case "login":
            // close dialog
            closeModalDialog("loginModal");
            // hide error class
            $("#loginModal").find("div.alert-danger").addClass("hidden");
            // reset form input
            resetFormLogin();
            location.reload();
            break;
          case "logout":
            location.reload();
            break;
          case "valid_date":
            $(".collection-book-time").removeClass("hidden");
            $(".collection-book-time").html("");
            genCheckboxBookTime(result.data);
            // display process to checkout
            removeEnquiryButton();
            //  createProcessCheckoutButton();
            break;
          case "email-enquiry":
            closeModalDialog("enquiryModal");
            $("#enquiryModal").find("div.alert-danger").addClass("hidden");
            resetFormEnquiry();
            show_alert("Enquiry sent successfully!", "success");
            // alert('Send enquiry was success!');
            break;
          case "email-wire-transfer":
            //closeModalDialog('paypalConfirmModal');
            $("#wireTransferModal").find("div.alert-danger").addClass("hidden");
            swal({
              text: "Thank you for your tentative booking. Please check your email for payment information.",
              icon: "success",
              showCancelButton: false,
              confirmButtonClass: "btn btn-success",
              cancelButtonClass: "btn btn-danger",
              confirmButtonText: "OK",
              buttonsStyling: false,
            }).then(function (result) {
              window.location = "/";
            });
            // alert('Thank you for your tentative booking. Please check your email for payment information.');
            // window.location = "/";
            break;
          case "boat_cal_price":
            alert(result.data);
            break;
          case "booking-confirm":
            //$('#paypalConfirmModal').html(result);
            break;
        }
      }
    },
    error: function (result) {
      console.log("Error:", result);
    },
  });
}

function ajaxBookConfirm(url, data, action, type) {
  let overlay = document.getElementsByClassName('loading-overlay')[0];
  overlay.classList.toggle('is-active');
  $.ajax({
    url: url,
    data: data,
    dataType: "html",
    type: type,
    success: function (result) {
      overlay.classList.toggle('is-active');
      $("#paypalConfirmModal").html(result);
      $("#paypalConfirmModal").modal();
    },
    error: function (result) {
      overlay.classList.toggle('is-active');
      console.log(result.responseText);
      // $("#paypalConfirmModal").html(result.responseText);
      // $("#paypalConfirmModal").modal();
      //   alert(result.message);
    },
  });
}

function getParam(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getDatesWithTimeSlot(dateStart, dateEnd) {
  var boatId = $("input[name=boat_id]").val();
  $.get(
    "/boat-book/filterDate",
    {
      boatId,
      dateStart,
      dateEnd,
    },
    function (data) {
      if (data.result === true) {
        window.datesWithTimeSlot = window.datesWithTimeSlot || [];
        window.datesWithTimeSlot = window.datesWithTimeSlot.concat(
          data.validDateList
        );
      }
    },
    "json"
  );
}

function displayPaypalFee(methodElement) {
  if ($(methodElement).val() === "paypal" || $(methodElement).val() === "stripe") {
    $("#div-paypal-fee").removeClass("d-none");
  } else {
    $("#div-paypal-fee").addClass("d-none");
  }
}

function displayErrorHidden(name, message) {
  removeHidden(name + "_error");
  $("#" + name + "_error").text(message);
}

function createProcessCheckoutButton() {
  if ($("#proceed-to-checkout").length === 0) {
    var buttonProcessCheckout = document.createElement("button");
    buttonProcessCheckout.setAttribute("id", "proceed-to-checkout");
    buttonProcessCheckout.setAttribute("type", "button");
    buttonProcessCheckout.innerHTML = "PROCEED TO CHECKOUT";
    $("#form-process-checkout").append(buttonProcessCheckout);
  }
}

function removeProcessCheckoutButton() {
  if ($("#proceed-to-checkout").length > 0) {
    $("#proceed-to-checkout").remove();
  }
}

function createEnquiryButton() {
  if ($("#enquiry-now").length === 0) {
    var buttonEnquiry = document.createElement("button");
    buttonEnquiry.setAttribute("id", "enquiry-now");
    buttonEnquiry.setAttribute("type", "button");
    buttonEnquiry.innerHTML = "ENQUIRE NOW";
    $("#form-process-checkout").append(buttonEnquiry);
  }
}

function removeEnquiryButton() {
  if ($("#enquiry-now").length > 0) {
    $("#enquiry-now").remove();
  }
}

function deleteMyBoats(boatIds) {
  if (
    !boatIds ||
    !Array.isArray(boatIds) ||
    boatIds.length === 0 ||
    !confirm("Are you sure you want to delete these boats?")
  ) {
    return false;
  }

  $.post(
    "/my-boats/delete",
    {
      boatIds: boatIds,
    },
    function (data) {
      if (data.success !== true) {
        alert("Error happened, please try again.");
      } else {
        alert("Deleted " + boatIds.length + " boats.");
        window.location.reload();
      }
    },
    "json"
  ).fail(function () {
    alert("Error happened, please try again.");
  });

  return false;
}

function highlightStar(obj, id) {
  removeHighlight(id);
  jQuery(".demo-table #tutorial-" + id + " li").each(function (index) {
    jQuery(this).addClass("highlight");
    if (index == jQuery(".demo-table #tutorial-" + id + " li").index(obj)) {
      return false;
    }
  });
}

function removeHighlight(id) {
  jQuery(".demo-table #tutorial-" + id + " li").removeClass("selected");
  jQuery(".demo-table #tutorial-" + id + " li").removeClass("highlight");
}

function addRating(obj, id) {
  jQuery(".demo-table #tutorial-" + id + " li").each(function (index) {
    jQuery(this).addClass("selected");
    jQuery("#tutorial-" + id + " #rating").val(index + 1);
    if (index == jQuery(".demo-table #tutorial-" + id + " li").index(obj)) {
      return false;
    }
  });
}

function resetRating(id) {
  if (jQuery("#tutorial-" + id + " #rating").val() != 0) {
    jQuery(".demo-table #tutorial-" + id + " li").each(function (index) {
      jQuery(this).addClass("selected");
      if (index + 1 == jQuery("#tutorial-" + id + " #rating").val()) {
        return false;
      }
    });
  }
}
