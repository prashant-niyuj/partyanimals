img_ab_path ="/admin/uploads/clublogo/resize/";
function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

$(document).ready(function() {
	
	$("#menuicon").click(function(event){
	   $("#menupanel").toggleClass("left");
	   	event.stopPropagation();
    });

	$("#menupanel .menuicon").click(function(event){
	   $("#menupanel").toggleClass("left");
	   	event.stopPropagation();
    });

	$(".container").click(function(event){
	   if($('#menupanel').hasClass('left') == true)
	   		$("#menupanel").toggleClass("left");
    });
	
	

    $(".clickbtn").click(function(){
        $(this).children('.clickbtn figcaption').toggleClass('bg');
		$(this).next(".form").slideToggle("fast");
	});
	var md = new MobileDetect(window.navigator.userAgent);
	if(md.phone())
	{
		$('.mobile-search-header').show();
	}
	$("#location").typeahead({
		name: "localityjson",
		remote: "index.php?r=booking/locality&q=%QUERY",
		limit: 10
	});
	
	$('#location').on('typeahead:selected', function (e, datum) {
		search_send();
	});
		
	$("#location").focusout(function() {	
		search_send();
	})
	$("#club_name").focusout(function() {	
		search_send();
	})
	$("#ccity").typeahead({
		name: "cityjson",
		remote: "index.php?r=booking/city&q=%QUERY",
		limit: 10
	});
	
	$("#club_name").typeahead({
		name: "clubjson",
		remote: "index.php?r=booking/clublist&q=%QUERY&locality="+$("#location").val(),
		limit: 10
	});
	$('#club_name').on('typeahead:selected', function (e, datum) {
		search_send();
	});
	
	$(".changeCity").click(function(){
		$("#ccity").val(readCookie("selectcity"));
		if(readCookie("selectcity"))
		{
			$(".popup_buttons_group").hide();
			$(".modal-footer button").show();
		}
		$("#selectCity").modal({backdrop: 'static'});
	});
	
	if(!readCookie("selectcity")) {
		$(".modal-footer button").hide();
		$("#selectCity").modal({backdrop: "static"});
	}
	else
	{
		$(".changeCity").html(readCookie("selectcity"));
	}

	$( ".submit_city" ).click(function() {
		if($("#ccity").val()) {
			createCookie("selectcity",$("#ccity").val(),365);
			$(".changeCity").html($("#ccity").val());
			if($(this).attr('data')=='guest' || $(this).attr('data')=='ok') {
				$("#selectCity").modal("hide");
				load_club();
				$(".location").val("");
				$(".club_name").val("");
			}
			if($(this).attr('data')=='signin') {
				window.location.href= 'index.php?r=user/security/login';
			}
			if($(this).attr('data')=='signup') {
				window.location.href= 'index.php?r=user/registration/register';
			}	
		}
		else
		{
			$("#selectCity .twitter-typeahead").addClass("has-error");
		}
	});

	$("#btn_search_club").on("click",function() {
		search_send();
	});
			
	var tmp = $.fn.popover.Constructor.prototype.show;
	$.fn.popover.Constructor.prototype.show = function () {
	  tmp.call(this);
	  if (this.options.callback) {
		this.options.callback();
	  }
	}
	
});

function saveintoCookie(key,value) {
	if($.super_cookie().check("booking_data"))
	{
		if(value)
			$.super_cookie().add_value("booking_data",key,value);
	}
	else
	{
		$.super_cookie().create("booking_data",{key:value});
	}	
}

function call_booking_popup(id)
{
	$("#selectbooknow").modal({backdrop: 'static'});
	$("#pc_id").val(id);
}

function load_club() 
{
	hide_popup();
	postData= 0;
	$.ajax({
        type : 'POST',
        url : "index.php?r=booking/search",
        async : true,
        data : postData,
        beforeSend : function (){
            $("#req_res_loading").show();
        },
        success : function (returnData) {
		$("#req_res_loading").hide();
		var obj = jQuery.parseJSON(returnData);
		if(obj.length > 0) {
		$(".no_data_found").hide();
		var responce_str= '';
		var a=false;
		round = 0;
		outerround = 0;
		var item_render = 8;
		var one_row_item_render = 4;
		var md = new MobileDetect(window.navigator.userAgent);
		if(md.phone())
		{
			item_render = 4;
			one_row_item_render=2
		}
		for (i in obj)
		{
			//console.log(obj[i].id)
			
			if(i%item_render == 0 )
			{
				outerround = outerround + 1;
				if(outerround == 1) 
				{
					responce_str += '<div class="item active"><div class="carousel-caption">';
				}
				else
				{
					responce_str += '</div></div></div><div class="item"><div class="carousel-caption">';
				}
				
				if(i%one_row_item_render == 0 )
				{
					round = round + 1;
					if(round == 1) {
						responce_str += '<div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
					}
					else {
						responce_str += '</div><div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
						//responce_str += '</div><div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><a href="javascript:void(0)" class="btn_book_now" data='+obj[i].id+'><p>Book Now</p></a></div></div>';
					}
					if(round == 2)
						round=0;
				}
				else
				{
					responce_str += '<div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
				}
				

			}
			else
			{
				if(i%one_row_item_render == 0 )
				{
					round = round + 1;
					if(round == 1) {
						responce_str += '<div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
					}
					else {
						responce_str += '</div><div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
					}
					if(round == 2)
						round=0;
				}
				else
				{
					responce_str += '<div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
				}
			}
		}
			responce_str +='</div></div>';
			$(".carousel-inner").empty();
			$(".carousel-inner").append(responce_str);
			
			$('[data-toggle="popover"]').popover({ 
			placement: 'bottom',
			content: function() {
				return $("#popover-content").html();
			},
			callback: function(e) {
				popup_callback();
			} 
			}).click(function (e) {
			
			$('.txt_datepicker').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				startDate: "month",
				endDate: "+7d",
				daysOfWeekDisabled:$(this).attr("close_days")
			}).on('changeDate', function(ev){
				//console.log(ev);
				//alert($('#myForm #txt_datepicker').val());
				update_rates($('#myForm #c_id').val(),$('#myForm #txt_datepicker').val());
			});
			
			//console.log($(this).attr("c_data"));
			$('#myForm #c_id').val($(this).attr("c_data"));
			update_rates($(this).attr("c_data"),$('#txt_datepicker').val());
			e.preventDefault();
		 });
	 }
	 else
	 {
		$(".carousel-inner").empty();
		$(".no_data_found").show();
	 }
       },
	error : function (xhr, textStatus, errorThrown) {
		 load_club();
	},
});

}
function update_rates(c_id,currdate) {
	$.ajax({
	   type: "GET",
	   url: "index.php?r=booking/getratebydate&c_id="+c_id+"&currdate="+currdate,
	   success: function(data)
	   {
			jobj = $.parseJSON(data);
			console.log(jobj.boy);
			if(jobj.boy) {
				if(jobj.boy == "0") {
					$('#myForm .span_boy').html("N/A");
					$('#myForm .span_boy').closest('label').css("text-decoration", "line-through");
					$('#myForm #radio_boy').attr("disabled", "true");
				}
				else
				{
					$('#myForm .span_boy').closest('label').css("text-decoration", "none");
					$('#myForm #radio_boy').removeAttr("disabled");
					$('#myForm .span_boy').html(jobj.boy);
				}	
			}	
			if(jobj.girl)
			{	
				if(jobj.girl == '0')
					$('#myForm .span_girl').html("Free");	
				else	
					$('#myForm .span_girl').html(jobj.girl);	
			}	
			if(jobj.couple)
				$('#myForm .span_couple').html(jobj.couple);			
	   }
	 });
}

function popup_callback() {
	$(".tr_group").hide();
	$(".error_club_full").hide();
	
	$("input:radio").change(function() {
	   if($(this).val() == 'group')
	   {
			$('.tr_group').show();
	   }
	   else
	   {
			$('.tr_group').hide();
	   }
	});
	
	$("#myForm").submit(function() {
		var paramObj = {};
		$.each($('#myForm').serializeArray(), function(_, kv) {
		  paramObj[kv.name] = kv.value;
		});
						
		//console.log(paramObj);
		if(paramObj['txt_datepicker'] == "")
		{
			$('.txt_datepicker').closest('.form-group').addClass('has-error');
		}
		else
		{
			$('.txt_datepicker').closest('.form-group').removeClass('has-error');
		}
		if('b_type' in paramObj)
		{
			$('.radio').closest('.form-group').removeClass('has-error');
			if(paramObj['b_type'] == 'group')
			{
				if(paramObj['popup_drop_boys'] == "0" && paramObj['popup_drop_girls'] == "0")
				{
					$('.popup_drop_boys').closest('.form-group').addClass('has-error');
				}
				else
				{
					$('.popup_drop_boys').closest('.form-group').removeClass('has-error');
				}
			}
		}
		else
		{
			$('.radio').closest('.form-group').addClass('has-error');
		}
		
		if ( $( '#myForm .form-group' ).hasClass( "has-error" ) ) {
			return false;
		}
		else 
		{
			
			$.ajax({
			   type: "POST",
			   url: "index.php?r=booking/checkclubookingstatus",
			   data: $("#myForm").serialize(),
			   success: function(data)
			   {
					jobj = $.parseJSON(data);
					if(jobj['status'] == true)
					{
						$('.error_club_full').hide();
						window.location.href= 'signup.html';
					}
					else
					{
						
						$('.error_club_full').show();
						$('#txt_datepicker').closest('.form-group').addClass('has-error');
						return false;
					}
					
			   }
			 });
			 
			 return false;
		}
	});
}
function hide_popup() {
	$( ".popover" ).each(function() {
		$('.popover').hide();
		$('.popover').removeClass('in');
		$('.popover').remove();
	});
}
function search_send()
{
	hide_popup();
   	var data=$("#search_club").serialize();
  	postData= 0;
	$.ajax({
            type : 'POST',
            url : "index.php?r=booking/search",
            async : true,
            data : data,
            beforeSend : function (){
                $("#req_res_loading").show();
            },
            success : function (returnData) {
                $("#req_res_loading").hide();
				var obj = jQuery.parseJSON(returnData);
				if(obj.length > 0) {		
				
				$(".no_data_found").hide();
				var responce_str= '';
				var a=false;
				round = 0;
				outerround = 0;
				var item_render = 8;
				var one_row_item_render = 4;
				var md = new MobileDetect(window.navigator.userAgent);
				if(md.phone())
				{
					item_render = 4;
					one_row_item_render=2
				}

				for (i in obj)
				{
					//console.log(obj[i].id)
					
					if(i%item_render == 0 )
					{
						outerround = outerround + 1;
						if(outerround == 1) 
						{
							responce_str += '<div class="item active"><div class="carousel-caption">';
						}
						else
						{
							responce_str += '</div></div></div><div class="item"><div class="carousel-caption">';
						}
						
						if(i%one_row_item_render == 0 )
						{
							round = round + 1;
							if(round == 1) {
								responce_str += '<div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
							}
							else {
								responce_str += '</div><div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
								//responce_str += '</div><div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><a href="javascript:void(0)" class="btn_book_now" data='+obj[i].id+'><p>Book Now</p></a></div></div>';
							}
							if(round == 2)
								round=0;
						}
						else
						{
							responce_str += '<div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
						}
						

					}
					else
					{
						if(i%one_row_item_render == 0 )
						{
							round = round + 1;
							if(round == 1) {
								responce_str += '<div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
							}
							else {
								responce_str += '</div><div class="row group-'+round+'"><div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
							}
							if(round == 2)
								round=0;
						}
						else
						{
							responce_str += '<div class="col-md-3"><div class="club-hover"><a tabindex="0" role="button" data-toggle="popover" data-html="true" c_data='+obj[i].id+' close_days="'+obj[i].club_open_days+'"><img src="'+img_ab_path+obj[i].logo+'" class="img-responsive"><div class="c_title">'+obj[i].name+' </div></a></div></div>';
						}
					}
				}
					responce_str +='</div></div>';
					$(".carousel-inner").empty();
					$(".carousel-inner").append(responce_str);
					
					$('[data-toggle="popover"]').popover({ 
					placement: 'bottom',
					content: function() {
						return $("#popover-content").html();
					},
					callback: function() {
						popup_callback();
					} 
					}).click(function (e) {
						
						$('.txt_datepicker').datepicker({
							format: "dd-mm-yyyy",
							autoclose: true,
							startDate: "month",
							endDate: "+30d",
							daysOfWeekDisabled:$(this).attr("close_days")
						}).on('changeDate', function(ev){
							//console.log(ev);
							//alert($('#myForm #txt_datepicker').val());
							update_rates($('#myForm #c_id').val(),$('#myForm #txt_datepicker').val());
						});
						
						$('#myForm #c_id').val($(this).attr("c_data"));
						update_rates($(this).attr("c_data"),$('#txt_datepicker').val());
						e.preventDefault();
					 });
			}		 
			 else
			 {
				console.log("no data");
				$(".carousel-inner").empty();
				$(".no_data_found").show();
			 }	 
			},
			error : function (xhr, textStatus, errorThrown) {
				 alert("Search error");
			},
					
	});
}
