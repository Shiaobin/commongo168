// JavaScript Document

$(document).ready(function(){

	/* Update Record  */
    // $(document).on('change', '#sellerRating-UpdateForm :input', function() {
	$("#sellerRating-UpdateForm").change(function() {
        $.post("rating.php", $(this).serialize())
        .done(function(data){
            // console.log(data);
        });
        return false;
    });
	/* Update Record  */
});
