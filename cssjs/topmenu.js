
	$(document).ready(function(){

       //Navigation Menu Slider
        $('#nav-expander').on('click',function(e){
      		e.preventDefault();
      		$('body').toggleClass('nav-expanded');
      	});
      	$('#nav-close').on('click',function(e){
      		e.preventDefault();
      		$('body').removeClass('nav-expanded');
      	});
        $('#icon_search').on('click',function(e){
			var inputsearch = $("#inputsearch");

			if(inputsearch.css('display')=='none')
			{
				inputsearch.slideDown("1000").focus();
			}else{
				inputsearch.slideUp("1000");
			}

      	});

		$("#inputsearch").keypress(function(e){
  		code = (e.keyCode ? e.keyCode : e.which);

  			if (code == 13)
  			{

				location.href="search.php?key="+$("#inputsearch").val();

  			}
  		});

//-----------------------------商品數量增減-----------------------
function addinput(num)
{
	snum=num;
	if(snum>0)
	{
		$('#addinput_area').css('display','');
		$('#numinput_area').css('display','none');
		$('#sqty').val(snum);
	}else
	{
		$('#addinput_area').css('display','none');
		$('#numinput_area').css('display','');
		$('#sqty').val(0);
	}
}
  // This button will increment the value
  $('.sqtyplus').click(function(e) {
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('field');
    // Get its current value
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());
    // If is not undefined
    if (!isNaN(currentVal)) {
      // Increment
      $('input[name=' + fieldName + ']').val(currentVal + 1);
    } else {
      // Otherwise put a 0 there
      $('input[name=' + fieldName + ']').val(1);
    }
  });
  // This button will decrement the value till 0
  $(".sqtyminus").click(function(e) {


    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('field');
    // Get its current value
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());
    // If it isn't undefined or its greater than 0
    if (!isNaN(currentVal) && currentVal > snum) {
      // Decrement one
      $('input[name=' + fieldName + ']').val(currentVal - 1);
    }
  });

  // This button will increment the value
  $('.qtyplus').click(function(e) {
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('field');
    // Get its current value
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());
    // If is not undefined
    if (!isNaN(currentVal)) {
      // Increment
      $('input[name=' + fieldName + ']').val(currentVal + 1);
    } else {
      // Otherwise put a 0 there
      $('input[name=' + fieldName + ']').val(1);
    }
	});
  // This button will decrement the value till 0
  $(".qtyminus").click(function(e) {
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    fieldName = $(this).attr('field');
    // Get its current value
    var currentVal = parseInt($('input[name=' + fieldName + ']').val());
    // If it isn't undefined or its greater than 0
    if (!isNaN(currentVal) && currentVal > 1) {
      // Decrement one
      $('input[name=' + fieldName + ']').val(currentVal - 1);
    } else {
      // Otherwise put a 0 there
      $('input[name=' + fieldName + ']').val(1);
    }
  });

function send()
{
	qty=$("#qty").val();
	sqty=$("#sqty").val();
	if(isNaN(qty) || qty<=0)
	{
		$("#qty").val(1);
	}
	else if(isNaN(sqty) || parseInt(sqty) < parseInt(snum))
	{
		alert('數量最少為'+snum+"斤");
		$("#sqty").val(snum);
	}
	else
	{

		document.addgoods.submit();

	}
}
//-----------------------------商品數量增減-----------------------


      	// Initialize navgoco with default options
        $(".main-menu").navgoco({
            caret: '<span class="caret"></span>',
            accordion: false,
            openClass: 'open',
            save: true,
            cookie: {
                name: 'navgoco',
                expires: false,
                path: '/'
            },
            slide: {
                duration: 300,
                easing: 'swing'
            }
        });
      });
