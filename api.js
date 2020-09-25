
			$("button").click(function(e) {
			    e.preventDefault();

			    var from_date = $("#from_date").val();
			    var todate   = $("#todate").val();

			    $.ajax({
			    	       type: "POST",
			    	       url: "total_profit.php",
				           data: "from_date=" + from_date +"&todate=" + todate,
				  
						   success: function (data) {
						   	    console.log(data);
					            $('#total_profit').append(data);
							},
						   error:function (error) {
						        console.log(error);
						    }

						});
			});

 