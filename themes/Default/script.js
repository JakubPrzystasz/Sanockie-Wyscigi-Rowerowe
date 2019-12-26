	function get_signed(url_id){
		var data = "table=signed&race_id="+url_id;
		$.ajax({
			type: "POST",
			url: "scores.php",
			data: data,
			cache: false,
			success: function(result){
				$("#signed_table").html(result);
			}
		});
	}
	
	function get_scores(url_id,category){
		var data = "table=scores&race_id="+url_id+"&category="+category;
		$.ajax({
			type: "POST",
			url: "scores.php",
			data: data,
			cache: false,
			success: function(result){
				$("#scores_table").html(result);
			}
		});
	}
	
	function get_classification(url_id,category){
		var data = "table=classification&race_id="+url_id+"&category="+category;
		$.ajax({
			type: "POST",
			url: "scores.php",
			data: data,
			cache: false,
			success: function(result){
				$("#scores_table").html(result);
			}
		});
	}
	
	function signup_race_modal(race_id){
		var data = "race_id="+race_id;
		$.ajax({
			type: "POST",
			url: "signup_modal.php",
			data: data,
			cache: false,
			success: function(result){
				$("#signup_race_modal_body").html(result);
			}
		});
	}

	$(document).ready(function(){
		
		 $('[data-toggle="popover"]').popover(); 
		
		jQuery(document).on('keyup',function(hide_modal){
			if(hide_modal.keyCode == 27){
				$('#notification').modal('hide');
				$('#search_modal').modal('hide');
			}
		});
			
		$("#register_email").change(function(){
			var data = "register_email="+$("#register_email").val();
			$.ajax({
				type: "POST",
				url: "/modules/user_managment/register.php",
				data: data,
				cache: false,
				success: function(result){
					$("#info-register-email").html(result);
				}
			});
		});
		
		$("#register_login").change(function(){
			var data = "register_login="+$("#register_login").val();
			$.ajax({
				type: "POST",
				url: "/modules/user_managment/register.php",
				data: data,
				cache: false,
				success: function(result){
					$("#info-register-login").html(result);
				}
			});
		});
		
		$("#register_password").change(function(){
			var data = "register_password="+$("#register_password").val();
			$.ajax({
				type: "POST",
				url: "/modules/user_managment/register.php",
				data: data,
				cache: false,
				success: function(result){
					$("#info-register-password").html(result);
				}
			});
		});
		
		$("#register_repeat_password").change(function(){
			var data = "register_first_password="+$("#register_password").val()+"&register_second_password="+$("#register_repeat_password").val();
			$.ajax({
				type: "POST",
				url: "/modules/user_managment/register.php",
				data: data,
				cache: false,
				success: function(result){
					$("#info-register-repeat-password").html(result);
				}
			});
		});
		
		function search(){
			var data = "search="+$("#search_box").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#search_body").html(result);
				}
			});	
		}
		
		$("#search_button").click(function(){
			if($("#search_box").val() != "")
			{
				search();
				$("#search_modal").modal('show');
			}else{
				$("#search_box").popover('toggle');
				setTimeout(function(){ $("#search_box").popover('hide'); }, 3000);
			}
		});
		$("#search_box").keypress(function(enter) {
			var keycode = enter.keyCode || enter.which;
			if(keycode == '13') {
				if($("#search_box").val() != "")
				{
					search();
					$("#search_modal").modal('show');
				}else{
					$("#search_box").popover('toggle');
					setTimeout(function(){ $("#search_box").popover('hide'); }, 3000);
				}
			}
		});
	
	});