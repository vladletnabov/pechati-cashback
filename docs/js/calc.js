$(document).ready(function() {
	var reg = /<[^>]+>/g;
	var price1 = 0;
	var price2 = 0;
	viewTotalPrice = function() {
		var sum = price1+price2+"<span>руб</span>";
		$('.total-price').html(sum);
		$('input[name=total_sum]').val(sum);
		if ((price1>0) && (price2>0)) {
			$(".rezult-block").show();
			$("#form-block").css({cssFloat : "right"});
		}
	} 

	$(".item").click(function(){
		var step1 = $(this).find("h4").html().replace(reg,"")
					+": "+$(this).find(".price").html().replace(reg,"");
		$('input[name=type]').val(step1);
		
		$(".rezult-block p").first().html(step1);
		price1 = parseInt($(this).find(".price").html().replace(reg,"").replace(" ",""));
		viewTotalPrice();
		$(".item").removeClass("active-item");
		$(this).addClass("active-item");

	});
	$(".slider ul li").click(function(){
		var step2 = $(this).find(".osnastka").html().replace(reg,"")
					+": "+$(this).find(".price").html().replace(reg,"");
		$('input[name=osnastka]').val(step2);
		
		$(".rezult-block p").eq(1).html(step2);
		$(".rezult-block img").attr("src",$(this).find("img").attr("src"));
		price2 = parseInt($(this).find(".price").html().replace(reg,"").replace(" ",""));
		viewTotalPrice();
		$(".slider ul li").removeClass("active-item");
		$(this).addClass("active-item");
	});

	// $(".item").first().trigger("click");
	// $(".slider ul li").first().trigger("click");

});