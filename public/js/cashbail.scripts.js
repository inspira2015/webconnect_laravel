/*
 * jQuery Currency v0.6 ( January 2015 )
 *
 */

var MyNamespace = {
  myString: "someString",
  myInt: 123,
  myFunc: function() {
  return this.myString + " " + this.myInt;
  }
};

var DatePickerObj = {
  posted_date: new Date(),
  date_input: '', //our date input has the name "date"
  container: '',
  options: {
    format: 'mm/dd/yyyy',
    container: this.container,
    todayHighlight: true,
    autoclose: true,
    forceParse: false,
  },
  writeDate: function() {
    this.date_input.datepicker(this.options).datepicker("setDate", this.posted_date);
  }
};

var AddNewComment = {
  commentButton: '',
  urdata: '',
  bail_master_id: '',
  comment: '',
  target_comment: '',
  
  onReady: function() {
    $('#' + this.commentButton).click(function (event) {
      event.preventDefault();
      var ajaxUrl = event.view.AddNewComment.urdata;
      var bail_master_id = event.view.AddNewComment.bail_master_id;
      var comment = event.view.AddNewComment.comment;
      var target_comment = event.view.AddNewComment.target_comment;
      var new_comment = $("#" + comment).val();

      if (!new_comment) {
        return ;
      }
      AddNewComment.ApiCall({
                  ajaxUrl: ajaxUrl,
                  bail_master_id: bail_master_id,
                  new_comment: new_comment,
                  target_comment: target_comment,
                 });
      $("#" + comment).val('');
    });
  },
 

  ApiCall: function (objData) {
    $.ajax({
        url: objData.ajaxUrl,
        dataType: "json",
        data: {
            "_token": "{{ csrf_token() }}",
            "type": "bailmaster",
            "id": objData.bail_master_id,
            "newComment": objData.new_comment,
        },
        success: function(data) {
          $("#" + objData.target_comment).append('<li id="comment'+ data.id +'">'
                               + '<div class="commentText"><p class="">' 
                               + data.comment 
                               + '</p><span class="date sub-text">' 
                               + data.added_at 
                               + '</span>' 
                               + '<button id="removeButton" data-id="' 
                               + data.id 
                               + '"  data-toggle="modal" '
                               + 'data-target="#removeComment" class="removeComment btn btn-sm btn-danger">Remove</button>'
                               + '</li>');
        }
    });
  },
};

var removeButtonId = 'removeComment';
var testVariable = 'outside var';

var removeButton = function() {
  $('#' + removeButtonId).on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var comment_id = button.data('id');
    $('#comment_notworking').attr('data-commentid', comment_id);
    var recipient = button.siblings("p").html(); // Extract info from data-* attributes
    $('.modal-body').html(recipient);
  });
}


var removeModalClass = 'removeNow';
var commentType = 'bailmaster';
var removeCommentSectionId = 'removeComment'

var removeModalBox = function () {
   $('.' + removeModalClass).click(function (event) {
      var commentId = $(this).data('commentid');
      var src_remove = $('#removeNowRoute').val();

      $.ajax({
        url: src_remove,
        dataType: "json",
        data: {
                "_token": "{{ csrf_token() }}",
                "type": commentType,
                "id": commentId,
        },
        success: function(data) {
          if (data.remove_comment) {
            $('#' + 'comment' + commentId).remove();
          }
        }
      })

      $('#' + removeCommentSectionId).modal('toggle');
    });
}

var RemoveComment = {
  removeButton: '',
  removeNowClass: '',

  removeNow: function () {
    var test = 'test';
   $('.' + this.removeNowClass).click(function (event) {
      var commentId = $(this).data('commentid');
      var src_remove = $('#removeNowRoute').val();

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
  },

};

var buttonReverse = function (module_var) {
    var test2 = module_var;

  $('.button-reverse').on('click', function() {
    var transaction_id =  $(this).attr("data-transaction");
    var transaction_amount = $('#t-amount-' + transaction_id).val();
    var transaction_type = $(this).data('transaction-type');

    if (transaction_type == 'P') {
      var transaction_type_text = "Payment";
    }

    $('#module_name').val(test2);
    $('#t_id').val(transaction_id);
    $('#transaction-type').html(transaction_type_text);
    $('#transaction-amount').html('$' + transaction_amount);
  });
};


var reverseTransactionModel = function (county_fee, balance) {

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
};


var remitBalanceModel = function(balance) {
  $('#Remit-Balance').on('show.bs.modal', function () {
    var check_number = $('#check-number').val();
    $('#remitAmount').html(balance);
    $('#check-number-html').html(check_number);

    $('#refund_amount').val(balance);
    $('#remit_check').val(check_number);
    console.log('here' + balance);
  });
};


var stateSelector = function (state_id, state_outside_us) {

  if (state_outside_us) {
    var outside_length = state_outside_us.length;

    if (outside_length > 0) {
      $('.outside-state').show();
      $('#m_surety_state').val(state_id);
      $('#non_us_state').val(state_outside_us);
    } else {
      $('.outside-state').hide();
    }
  } else {
    $('.outside-state').hide();
    $('#m_surety_state').val(state_id);
  }
    $('#m_surety_state').change(function() {
      let state_id = $(this).val();
      let state_string = $("#m_surety_state option:selected" ).text();

      if (state_string == 'Other State (Outside US)') {
        $('.outside-state').show();
      } else {
        $('.outside-state').hide();
      }
    });
};

//forfeitures
var action_message = function(bf_active, updated_at) {
  if (bf_active == 1) {
    $('#forfeiture-action').html('<span class="green"><strong> Added to Forfeiture </strong></span>');
    $('#forfeiture-title').removeClass('black');
    $('#forfeiture-title').addClass('green');
  } else if(updated_at) {
    $('#forfeiture-title').removeClass('green');
    $('#forfeiture-action').html('<strong> Remove from Forfiture </strong>');
  } else {
    $('#forfeiture-title').removeClass('green');
    $('#forfeiture-action').html('<strong> Not Added </strong>');
  }
};

//forfeitures
var update_info = function(updated_at) {
  if (updated_at) {
    $('#forfeiture-updated-date').html('Updated at: <strong>' + updated_at + '</strong>');
  }
};

//forfeitures
var username_info = function(user_name) {
  if (user_name) {
    $('#forfeiture-user').html('Last Updated By: <strong>' + user_name + '</strong>');
  }
};

var checkForfeitureStatus = function(bf_active) {
  if (bf_active == 1) {
    return 1;
  } else {
    return 0;
  }
};

var forfeituresAddRemove = function (m_id, src__add_remove){
  $('#forfeituresCheckbox').on('change', function () {
    var toggle_state = $("#forfeituresCheckbox").is(":checked");

    $.ajax({
      url: src__add_remove,
      dataType: "json",
      data : { checkbox : toggle_state, bailMaster_id : m_id },
      success: function(data) {
        action_message(data.bf_active, data.bf_updated_at);
        update_info(data.bf_updated_at);
        username_info(data.user);
      }
    });
  });
};
