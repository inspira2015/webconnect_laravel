<script>
  var state_id         = "";
  var state_outside_us = "";
  $(document).ready(stateSelector(state_id, state_outside_us));

  $(document).ready(function() {
    $('.outside-state').hide();

  var src = "{{ route('validateindexyear') }}";
  var old_posted_date = '{{ old('m_posted_date', $m_posted_date) }}';
  var old_date_of_record = '{{ old('date_of_record') }}';
  var date_of_record = new Date();
  var posted_date = new Date();

  if (old_posted_date) {
   posted_date = old_posted_date;
  }

  if (old_date_of_record) {
   date_of_record = old_date_of_record;
  }

  $.validator.addMethod(
   "uniqueNumberYear",
   function(value, element) {
    var index_number = $('#m_index_number').val();
    var index_year = $('#m_index_year').val();
    var result = false;

    $.ajax({
     type: "GET",
     url: src,
     async: false,
     data: { number : index_number, year : index_year },
     dataType: "json",
     success: function (data) {
      if (data.result == 'empty') {
       result = true;
      }
     }
    });
    return result;
   },""
  );

  var date_input = $('input[name="m_posted_date"]'); //our date input has the name "date"
  var container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  var options = {
   format: 'mm/dd/yyyy',
   container: container,
   autoclose: true,
   forceParse: false,
  };
  date_input.datepicker(options).datepicker("setDate", posted_date);

  var date_input = $('input[name="date_of_record"]'); //our date input has the name "date"
  var container = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  var options = {
   format: 'mm/dd/yyyy',
   container: container,
   autoclose: true,
   setDate: 0,
  };
  date_input.datepicker(options).datepicker("setDate", date_of_record);

  var validate_index_number = function() {
   var index_number = $('#m_index_number').val();
   var index_year = $('#m_index_year').val();

   if (index_year && index_number) {
    $.ajax({
     url: src,
     dataType: "json",
     data : { number : index_number, year : index_year },
     success: function(data) {
      if (data.result == 'empty') {
       $('#indexyear_message').removeClass("error");
       $('#indexyear_message').addClass("green");
       $('#indexyear_message').html('Index Number/Year are unique');
       $('#valid_indexyear').val(0);
      } else {
       $('#indexyear_message').removeClass("green");
       $('#indexyear_message').addClass("error");
       $('#indexyear_message').html('Index Number/Year are duplicate');
       $('#valid_indexyear').val(1);
      }
     }
    });
   }
  }

  $("#m_index_number").change(function(){
   validate_index_number();
  });

  $("#m_index_year").change(function(){
   validate_index_number();
  });

 });

 $( "#manual-bail-entry" ).validate({
  success: function(label,element) {
    label.hide();
  },

  rules: {
   t_numis_doc_id: {
    required: true,
    number: true
   },
   m_receipt_amount: {
    required: true,
    number: true
   },
   m_index_year: {
    required: true,
    uniqueNumberYear: true
   },
  }
 });
</script>
