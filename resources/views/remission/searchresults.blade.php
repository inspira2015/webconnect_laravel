@extends('layouts.app')

@section('content')
<hr class="bail-remission">
<div class="body-content">
  <h1>Remissions</h1>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Edit Info</button>
  @include('chunks.editBailMasterInfo')
  <div class="col-md-10 offset-md-1" style="margin-bottom: 50px;">
    <hr class="my-3">
      @include('chunks.defendantData')
    <hr class="my-4">
      @include('chunks.bailFinancialTable')
    <hr class="my-3">
      @include('chunks.comments')
      @include('chunks.transactionHistory')
    <hr class="my-4">

  </div>
</div>
<script type="text/javascript">
 var old_posted_date = '{{ old('m_posted_date', $m_posted_date) }}';
 console.log(old_posted_date);

 DatePickerObj.posted_date = old_posted_date;
 DatePickerObj.date_input = $('input[name="m_posted_date"]'); //our date input has the name "date"
 DatePickerObj.container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
 DatePickerObj.writeDate();


 DatePickerObj.posted_date = old_posted_date;
 DatePickerObj.date_input = $('input[name="m_posted_date2"]'); //our date input has the name "date"
 DatePickerObj.container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
 DatePickerObj.writeDate();



  $(document).ready(function() {
    src = "{{ route('addComment') }}";

    $('#commentButton').click(function (event) {
      event.preventDefault();

      var bail_master_id = $('#new-comment').data('id');
      var new_comment = $.trim($('#new-comment').val());

      if (!new_comment) {
        return ;
      }

      $.ajax({
        url: src,
        dataType: "json",
        data: {
               "_token": "{{ csrf_token() }}",
               "type": "bailmaster",
               "id": bail_master_id,
               "newComment": new_comment,
        },
        success: function(data) {
          console.log(data.comment);
          $("#comment_list").append('<li><div class="commentText"><p class="">' + data.comment + '</p><span class="date sub-text">' + data.added_at + '</span>'+
            '<button id="removeButton" data-id="' + data.id + '"  data-toggle="modal" data-target="#removeComment" class="removeComment btn btn-sm btn-danger">Remove</button>'
            +'</li>');
        }
      });
      $('#new-comment').val('');
  });

  var balance = parseFloat({{ $balance }});
  var county_fee = parseFloat({{ $bailDetails['fee_percentaje'] }});

  $('#Multi-Check-payment').on('show.bs.modal', function () {
   var multicheck_payment = parseFloat($('#multicheck-payment').val());
   var check_court = $("#select_court_check option:selected").text();
   var check_court_id = $('#select_court_check').val();

   if (multicheck_payment == balance) {
    var partial_amount_fee = parseFloat(multicheck_payment * county_fee);
    var partial_plus_fee = parseFloat(multicheck_payment - partial_amount_fee);
    var remain_balance = 0;
    var multicheck_payment_show = partial_plus_fee;
   } else {
    var partial_amount_fee = parseFloat(multicheck_payment * county_fee);
    var partial_plus_fee = parseFloat(multicheck_payment + partial_amount_fee);
    var remain_balance = parseFloat(balance - partial_plus_fee);
    var multicheck_payment_show = multicheck_payment;
   }

   $('#multicheck-payment_modal').html(multicheck_payment_show);
   $('#check_court').html(check_court);
   $('#multicheck_amount_fee').html(partial_amount_fee);
   $('#muticheck_balance').html(remain_balance);
   $('#multicheck_amount').val(multicheck_payment);
   $('#courtcheck_id').val(check_court_id);

   if (remain_balance < 0) {
    $('#refund-multicheck').attr("disabled", "disabled");
   } else {
    $('#refund-multicheck').removeAttr("disabled");
   }
  });

  $('.button-reverse').on('click', function() {
   var transaction_id =  $(this).attr("data-transaction");
   var transaction_amount = $('#t-amount-' + transaction_id).val();
   var transaction_type = $(this).data('transaction-type');

   if (transaction_type == 'P') {
    var transaction_type_text = "Payment";
   }
   $('#t_id').val(transaction_id);
   $('#transaction-type').html(transaction_type_text);
   $('#transaction-amount').html('$' + transaction_amount);
  });

  $('#Reverse-transaction').on('show.bs.modal', function () {
   var transaction_id =  $('#t_id').val();
   var multicheck_payment = parseFloat($('#multicheck-payment').val());
   var check_court = $("#select_court_check option:selected").text();
   var partial_amount_fee = parseFloat(multicheck_payment * county_fee);
   var partial_plus_fee = parseFloat(multicheck_payment + partial_amount_fee);
   var remain_balance = parseFloat(balance - partial_plus_fee);

    $('#multicheck-payment_modal').html(multicheck_payment);
    $('#check_court').html(check_court);
    $('#multicheck_amount_fee').html(partial_amount_fee);
    $('#muticheck_balance').html(remain_balance);

    if (remain_balance < 0) {
     $('#refund-manual').attr("disabled", "disabled");
    } else {
     $('#refund-manual').removeAttr("disabled");
    }
  });

  $('#Partial-payment').on('show.bs.modal', function () {
   var balance = parseFloat({{ $balance }});
   var county_fee = parseFloat({{ $bailDetails['fee_percentaje'] }});
   var partial_amount = parseFloat($('#partial-payment').val());
   var partial_amount_fee = partial_amount * county_fee;
   var partial_plus_fee = partial_amount + partial_amount_fee;
   var remain_balance = parseFloat(balance - partial_plus_fee);

   $('#partialAmount').html(partial_amount);
   $('#partial_amount_fee').html(partial_amount_fee);
   $('#remaining_balance').html(remain_balance);
   $('#refund_amount').val(partial_amount);
   if (remain_balance < 0) {
    $('#refund-manual').attr("disabled", "disabled");
   } else {
    $('#refund-manual').removeAttr("disabled");
   }
  });

  $('#removeComment').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var comment_id = button.data('id');
    var recipient = button.siblings("p").html(); // Extract info from data-* attributes
    $('.modal-body').html(recipient);
    $('.removeNow').data('id', comment_id);
  });

  $('.removeNow').click(function () {
    var commentId = $(this).data('id');
    var src_remove = "{{ route('removeComment') }}";

    $.ajax({
      url: src_remove,
      dataType: "json",
      data: {
              "_token": "{{ csrf_token() }}",
              "type": "bailmaster",
              "id": commentId,
      },
      success: function(data) {
        if (data.remove_comment) {
          $('#' + 'comment' + commentId).remove();
        }
      }
    })
    $('#removeComment').modal('toggle');
  });
 });
</script>
@endsection