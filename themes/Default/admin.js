		$('#race_name').keyup(function(){
			var data = "search_race="+$("#race_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#race_table").html(result);
				}
			});
		});
		$('#search_race').click(function(){
			var data = "search_race="+$("#race_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#race_table").html(result);
				}
			});
		});
		
		$('#user_name').keyup(function(){
			var data = "search_user_name="+$("#user_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#user_table").html(result);
				}
			});
		});
		$('#search_user').click(function(){
			var data = "search_user_name="+$("#user_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#user_table").html(result);
				}
			});
		});
		
		$('#quick_signup_user_name').keyup(function(){
			var data = "quick_signup_search_user_name="+$("#quick_signup_user_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#quick_signup_user_table").html(result);
				}
			});
		});
		$('#quick_signup_search_user').click(function(){
			var data = "quick_signup_search_user_name="+$("#quick_signup_user_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#quick_signup_user_table").html(result);
				}
			});
		});
		
		$('#article_name').keyup(function(){
			var data = "search_article="+$("#article_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#article_table").html(result);
				}
			});
		});
		$('#search_article').click(function(){
			var data = "search_article="+$("#article_name").val();
			$.ajax({
				type: "POST",
				url: "search.php",
				data: data,
				cache: false,
				success: function(result){
					$("#article_table").html(result);
				}
			});
		});