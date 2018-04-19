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