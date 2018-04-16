@extends('layouts.app')

@section('content')
<style type="text/css">

.detailBox {
    width: 95%;
    border:1px solid #bbb;
    margin: 20px;
}
.titleBox {
    background-color:#fdfdfd;
    padding: 5px;
}
.titleBox label{
  color:#444;
  margin:0;
  display:inline-block;
}

.commentBox {
    padding:10px;
    border-top:1px dotted #bbb;
}
.commentBox .form-group:first-child, .actionBox .form-group:first-child {
    width:80%;
}
.commentBox .form-group:nth-child(2), .actionBox .form-group:nth-child(2) {
    width:18%;
}
.actionBox .form-group * {
    width:100%;
}
.taskDescription {
    margin-top:10px 0;
}
.commentList {
    padding:0;
    list-style:none;
    max-height: 300px;
    overflow:auto;
}
.commentList li {
    margin:0;
    margin-top:7px;
}
.commentList li > div {
    display:table-cell;
}
.commenterImage {
    width:30px;
    margin-right:5px;
    height:100%;
    float:left;
}
.commenterImage img {
    width:100%;
    border-radius:50%;
}
.commentText p {
    margin:0;
}
.sub-text {
    color:#aaa;
    font-family:verdana;
    font-size:11px;
}
.actionBox {
    border-top:1px dotted #bbb;
    padding:10px;
}
</style>


<div class="body-content">
  <h1>Remissions</h1>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Edit Info</button>

  @include('chunks.editBailMasterInfo')

  <div class="col-md-10 offset-md-1" style="margin-bottom: 50px;">
    <hr class="my-3">
    <div class="form-row mt-4">
      <div style="width: 100%; text-align: left;">
        <h2>Defendant Data</h2>
      </div>
      <div class="col-sm-3 pb-3">
        <label for="m_def_first_name">Defendant First Name</label>
        <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  disabled>
      </div>
      <div class="col-sm-3 pb-3">
        <label for="m_def_last_name">Defendant Last Name</label>
        <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" disabled>
      </div>
      <div class="col-sm-1 pb-3">
        <label for="m_index_number">Indx Number: </label>
        <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" disabled>
        <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;"></div>
      </div>
      <div class="col-sm-1 pb-3">
        <label for="m_index_year">Index Year:</label>
        <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" disabled>
      </div>
      <div class="col-sm-2 pb-3">
        <label for="exampleAccount">Date Posted:</label>
        <input type="text" class="form-control" disabled id="m_posted_date2" name="m_posted_date2" placeholder="MM/DD/YYY">
      </div>
      <div class="col-sm-2 pb-3">
        <label for="m_court_number">Court Number: </label>
        {!! Form::select('m_court_number', $courtList, $bailMaster->m_court_number, array('class' => 'form-control',
       'disabled' => 'disabled')) !!}
      </div>
      <hr class="my-5">
      <div style="width: 100%; text-align: left;">
        <h2>Surety Data</h2>
      </div>
      <div class="col-sm-3 pb-3">
        <label for="m_surety_first_name">Surety First Name</label>
        <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" disabled>
      </div>
      <div class="col-sm-3 pb-3">
        <label for="m_surety_last_name">Surety Last Name</label>
        <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" disabled>
      </div>
      <div class="col-sm-4 pb-3">
        <label for="m_surety_address">Address</label>
        <input type="text" class="form-control" id="m_surety_address" name="m_surety_address"  value="{{ old('m_surety_address', $bailMaster->m_surety_address) }}" disabled>
      </div>
      <div class="col-sm-2 pb-3">
        <label for="m_surety_city">City</label>
        <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city', $bailMaster->m_surety_city) }}" disabled>
      </div>
      <div class="col-sm-2 pb-3">
        <label for="m_surety_state">State</label>
        {!! Form::select('m_surety_state', $stateList, $bailMaster->m_surety_state, array('class' => 'form-control',
                            'disabled' => 'disabled')) !!}
      </div>
      <div class="col-sm-2 pb-3">
        <label for="m_surety_zip">Zip Code</label>
        <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" disabled>
      </div>
    </div>
    <hr class="my-4">

    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Bail Amount </div></td>
        <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Forfeit/Purge</div></td>
        <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Payment</div></td>
        <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">County Fee </div></td>
        <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Balance</div></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_receipt_amount }}</div></td>
        <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_forfeit_amount }}</div></td>
        <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_payment_amount }}</div></td>
        <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_city_fee_amount }}</div></td>
        <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $balance }}</div></td>
      </tr>
    </table>
    <hr class="my-3">

    @include('chunks.comments')

    @include('chunks.transactionHistory')

    <hr class="my-4">
    <div style="width: 100%; text-align: left;">
      <h2>Process Bail Options</h2>
    </div>

    <div class="container">
      <div class="row">
        <div class="col">
          <button type="button" class="btn btn-primary btn-lg top-margin15" data-toggle="modal" data-target="#Refund-balance" >Refund Balance</button>
        </div>
        <div class="col" >
          <button type="button" class="btn btn-primary btn-lg top-margin15" data-toggle="modal" data-target="#Refund-balance-with-fee" style="margin-top: 12px;">Refund Balance Retaining 3%</button>
        </div>
        <div class="col">
          <input type="text" class="form-control" id="partial-payment" name="partial-payment" value="" style="margin-bottom: 5px;"  placeholder="Enter Payment Amount..">

          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Partial-payment" data-whatever="@fat">Partial Payment</button>
        </div>
        <div class="col">
          <input type="text"  style="margin-top: 5px;" class="form-control" id="multicheck-payment" name="multicheck-payment" value=""   placeholder="Enter Payment Amount..">
          {!! Form::select('court_check_list', $courtCheckList, '', array('class' => 'form-control',
      'id' => 'select_court_check')) !!}
          <button type="button" style="margin-top: 5px;" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#Multi-Check-payment" data-whatever="@fat">MultiCheck</button>
        </div>
      </div>
    </div>
    @include('chunks.transactionOptions')

  </div>
</div>
<script type="text/javascript">

 var old_posted_date = '{{ old('m_posted_date', $m_posted_date) }}';
 var posted_date = new Date();

 if (old_posted_date) {
  posted_date = old_posted_date;
 }

 var date_input = $('input[name="m_posted_date"]'); //our date input has the name "date"
 var date_input_disabled = $('input[name="m_posted_date2"]');
 var container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
 var options = {
  format: 'mm/dd/yyyy',
  container: container,
  //todayHighlight: true,
  autoclose: true,
  forceParse: false,
 };
 date_input.datepicker(options).datepicker("setDate", posted_date);
 date_input_disabled.datepicker(options).datepicker("setDate", posted_date);

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