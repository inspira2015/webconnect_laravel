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
    console.log(this.posted_date);
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
    console.log(objData);
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


var RemoveComment = {
  removeButton: '',
  removeNowClass: '',

  onReady: function () {
    $('#' + this.removeButton).on('show.bs.modal', function (event) {
      console.log('hereeeee');
      var button = $(event.relatedTarget); // Button that triggered the modal
      var comment_id = button.data('id');
      var recipient = button.siblings("p").html(); // Extract info from data-* attributes
      $('.modal-body').html(recipient);
      $('.removeNow').data('id', comment_id);
      console.log(comment_id);
    });
  },

  removeNow: function () {
    event.data = {test: 'test'};
   $('.removeNow').click(function (event) {
      var commentId = $(this).data('id');
      console.log(event);
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
  },

};


 