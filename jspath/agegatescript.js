// Age Gate Used for front end validation to enter a site. Slightly modified for presentation.


//<![CDATA[
function getUrlVars() {
	// Find the params in the URL, Used when linking from another site that has already screened for age
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


// Calculate your age based on inputs
$(function(){
	      	var day = $("#birthDay").val();
            var month = $("#birthMonth").val();
            var year = $("#birthYear").val();   
// Disallow Letters into the Age Gate Input Fields
$('#ageGateForm input.ageInput').on('input', function() {
 this.value = this.value.replace(/[\s\D]/g, '', function(){
 });
 if ($(this).val().length == $(this).attr('maxlength'))  {
	if($('#birthDay').val() > 31 || $('#birthMonth').val() > 12 || $('#birthYear').val() > 2014) {
		$(this).val('');
		}
	if($('html').hasClass('no-touch')) {
 		$(this).parent().next().find('input.ageInput').focus();}
 	};
}); 
 



$("#ageGate456Form").click(function(){


  //$(document).on('submit','#userAllocdssdsateForm', function(event){
    event.preventDefault();
			var day = $("#birthDay").val();
            var month = $("#birthMonth").val();
            var year = $("#birthYear").val();
            var age  = $("#requiredAge").val();

            // If Input Fields are left empty or not Formatted Correctly Display Message 
            if (day == "" || month == "" || year == "" || month.length < 2 || day.length < 2 || year.length < 4){
            	$('li.errors').html("Please Fill out All Fields with the correct formatting.").slideDown(300);
               
              return false
             }
            var mydate = new Date();
            mydate.setFullYear(year, month-1, day);
        
            var currdate = new Date();
            currdate.setFullYear(currdate.getFullYear() - age);

            //  If Underage Redirect to Google Homepage 
            if ((currdate - mydate) < 0){
             	$.cookie('age_verify', 'underage', { expires: 1, path:'/'});
            	$('#ageGateForm').html("<p class='message'>Sorry, only persons over the age of " + age + " may enter this site</p>");
                 return false
             }
  

             // If Age is Validated Hide form and show contents
            else {
            $.cookie('age_verify' , 'legal' , { expires: 1, path:'/'});
            	$('#ageGateForm').html("<p class='message'>Congrats you are over 21... you may enter</p>");
			
			 return false 
         }
     
        });
  });

//]]>