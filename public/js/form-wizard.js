jQuery(function($) {

	$('#my-wizard')
.ace_wizard({
  //step: 2 //optional argument. wizard will jump to step "2" at first
  //buttons: '.my-action-buttons' //which is possibly located somewhere else and is not a sibling of wizard
})
.on('actionclicked.fu.wizard' , function(e, info) {
   //info.step
   //info.direction
   
   //use e.preventDefault to cancel
})
.on('changed.fu.wizard', function() {
  
})
.on('finished.fu.wizard', function(e) {
   //do something when finish button is clicked

}).on('stepclick.fu.wizard', function(e) {
   //e.preventDefault();//this will prevent clicking and selecting steps
});
})