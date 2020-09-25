
			$("button").click(function(e) {
			    e.preventDefault();

			    var from_date = $("#from_date").val();
			    var todate   = $("#todate").val();
			    
			    $.ajax({
			    	       type: "POST",
			    	       url: "item_type.php",
				           data: "from_date=" + from_date +"&todate=" + todate,
						   success: function (data) {
						        var dat = JSON.parse(data);
						       
					            var html = "<table id='data-table-default' class='table table-bordered table-striped' border='1|1'>";
							    for (let item of dat) {
							        html+="<tr>";
							        html+="<td>"+item.Item_Type+"</td>";
							        html+="<td>"+item.value+"</td>";
							        html+="</tr>";                    

							    }
							    html+="</table>";
							    $("#myDiv").append(html);

					 
							},
						   error:function (error) {
						        console.log(error);
						    }

						});
			});

 