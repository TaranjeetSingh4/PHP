				 <!-- InstanceEndEditable -->
				 </div>
				 </div>
				 <div class="clearfix"></div>
				 <div class="foot">
				 	Design & Developed by: <a href="https://www.appventurez.com/" target="_blank"><strong style="color:#007BFF;">Appventurez</strong><strong> Mobitech</strong> Pvt. Limited</a> through <a href="https://www.dgmhup.gov.in/" target="_blank"><strong>DGMHUP</strong></a> . This portal is maintained &amp; managed by IT Cell, DGMHUP, Uttar Pradesh.
				 </div>
				 </section>
				 </div>
				 </div>

				 <?php
					require_once './controller/config.php';

					$conn = get_db_connection();

					$query = "select * from roles order by role asc";
					$result = mysqli_query($conn, $query);

					?>


				 <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
				 <script src="//cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
				 <script type="text/javascript" src="js/app.js"></script>
				 <script type="text/javascript" src="js/bootstrap.min.js"></script>
				 <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
				 <script type="text/javascript" src="js/owl.carousel.min.js"></script>
				 <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
				 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
				 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
				 <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


				 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script> -->

				 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
				 <script>
				 	$(document).ready(function() {
				 		$('a').each(function() {
				 			if (location.href === this.href) {
				 				$(this).addClass('active');
				 				$('a').not(this).addClass('none');
				 				return false;
				 			}
				 		});
				 	});
				 	$(function() {
				 		$(".spotlgt").owlCarousel({
				 			slideSpeed: 300,
				 			paginationSpeed: 400,
				 			items: 1,
				 			autoPlay: !0,
				 			navigation: !0,
				 			pagination: false,
				 			itemsDesktop: [1199, 1],
				 			itemsDesktopSmall: [1027, 1],
				 			navigationText: ["<i class='icon-arrow-left icons'></i>", "<i class='icon-arrow-right icons'></i>"]
				 		});

				 	});
				 </script>
				 <script src="js/jquery.bootstrap.wizard.js"></script>
				 <script src="js/prettify.js"></script>
				 <script>
				 	$(document).ready(function() {
				 		$('#rootwizard').bootstrapWizard({
				 			'tabClass': 'bwizard-steps'
				 		});
				 		window.prettyPrint && prettyPrint()
				 	});
				 </script>
				 <script src="Scripts/SelfDeclarationOfHT.js"></script>
				 <script>
				 	console.log("jQuery version:", typeof jQuery !== 'undefined' ? jQuery.fn.jquery : 'jQuery NOT loaded');
				 	$(document).ready(function() {
				 		$(".add_item_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#show_item").append(`<div class="row append_item" id="remove_item">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Field Name <span class="star">*</span></label>
                                        <input name="field_name[]" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Field Type <span class="star">*</span></label>
                                        <select name="field_type[]" style="width:100%;">
                                                <option value="text">String</option>
                                                <option value="number">Integer</option>
                                                <option value="file">File</option>
                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <button class="remove_item_btn btn btn-danger">Remove Field</button>
                                    </div>
                                </div>
                            </div>`);
				 		});

				 		$(".add_section_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#show_section").append(`<div class="row append_section">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Section Name <span class="star">*</span></label>
                        <input name="section_name[]" class="form-control" type="text">
                    </div>
                </div>

                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sub-Field Name <span class="star">*</span></label>
                                        <input name="sub_field_name[]" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sub Field Type <span class="star">*</span></label>
                                        <select name="sub_field_type[]" style="width:100%;">
                                                <option value="text">String</option>
                                                <option value="number">Integer</option>
                                                <option value="file">File</option>
                                        </select>
                                       
                                    </div>
                                </div>
                <div class="col-md-2 mt-2">
                    <div class="form-group">
                        <button class="add_sub btn btn-success">Add More Fields</button>
                    </div>
                </div>

                <div class="col-md-1 mt-2">
                    <div class="form-group">
                        <button class="remove_item_btn btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
                
                
            </div>`);
				 		});



				 		$(".add_dropdown_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#show_section").append(`
            <div class="row append_section">
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Dropdown Label <span class="star">*</span></label>
                        <input name="dropdown_label[]" class="form-control" type="text" placeholder="Enter dropdown label">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Dropdown Options</label>
                        <div class="option-container">
                            <div class="input-group mb-2">
                                <input type="text" name="dropdown_options[0][]" class="form-control option-input" placeholder="Enter option">
                                <button class="btn btn-sm btn-success add_option"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-1 mt-2">
                    <button class="remove_item_btn btn btn-danger"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        `);
				 		});

				 		// Add new dropdown option
				 		$(document).on("click", ".add_option", function(e) {
				 			e.preventDefault();
				 			let optionIndex = $(this).closest(".option-container").find(".input-group").length;
				 			$(this).closest(".option-container").append(`
            <div class="input-group mb-2">
                <input type="text" name="dropdown_options[${optionIndex}][]" class="form-control option-input" placeholder="Enter option">
                <button class="btn btn-sm btn-danger remove_option"><i class="fa fa-trash"></i></button>
            </div>
        `);
				 		});

				 		// Remove an option
				 		$(document).on("click", ".remove_option", function(e) {
				 			e.preventDefault();
				 			$(this).closest(".input-group").remove();
				 		});

				 		// Remove the entire section
				 		$(document).on("click", ".remove_item_btn", function(e) {
				 			e.preventDefault();
				 			$(this).closest(".append_section").remove();
				 		});





				 		$('.add_user_btn').click(function(e) {
				 			e.preventDefault();
				 			$("#show_user_section").append(`<div class="row append_section " style="margin:1px"><div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Name <span class="star">*</span></label>
                                <input required name="name[]" class="form-control" type="text">
                            </div>
                        </div>
               
                        <div class="col-md-3 col-xs-12">
                            <div class="form-group">
                                <label>Email ID <span class="star">*</span></label>
                                <input required name="email[]" class="form-control" type="email">
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Mobile No. <span class="star">*</span></label>
                                <input required name="phone[]" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Designation <span class="star">*</span></label>
                                <input required name="designation[]d" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12">
                            <div class="form-group">
                                <label>Role <span class="star">*</span></label>
                                <select name="role[]" class="form-control">
                                    <option value="null" id="choose-role" style="color:grey">--------- Choose Role ----------</option>
                                   
                                    <?php
									while ($row = mysqli_fetch_assoc($result)) {

									?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['role']; ?></option>
                                    <?php
									}
									?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <button class="remove_user_btn"><i class="fa fa-trash" aria-hidden="true" style="font-size:2rem; background:red; color:white; padding:10px"></i></button>
                        </div></div>`);
				 		});

				 		$(document).on('click', '.remove_user_btn', function(e) {
				 			e.preventDefault();
				 			let row_item = $(this).parent().parent();
				 			let id = this.id;

				 			$(row_item).remove();

				 		});


				 		$(document).on('click', '.add_sub', function(e) {
				 			e.preventDefault();
				 			$("#show_section").append(`<div class="row append_item" id="remove_item">
           <div class="col-md-3">
                    <div class="form-group">
                        <label>Section Name <span class="star">*</span></label>
                        <input name="section_name[]" class="form-control" type="text">
                    </div>
                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sub-Field Name <span class="star">*</span></label>
                                        <input name="sub_field_name[]" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sub Field Type <span class="star">*</span></label>
                                        <select name="sub_field_type[]" style="width:100%;">
                                                <option value="text">String</option>
                                                <option value="number">Integer</option>
                                                <option value="file">File</option>
                                        </select>
                                       
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <div class="form-group">
                                        <button class="remove_item_btn btn btn-danger">Remove Field</button>
                                    </div>
                                </div>
                            </div>`);
				 		});

				 		let count = [];
				 		$(document).on('click', '.remove_item_btn', function(e) {
				 			e.preventDefault();
				 			let row_item = $(this).parent().parent().parent();
				 			let id = this.id;

				 			if (this.id) {
				 				count.push(id);
				 				let element = document.getElementById('delete_field_id');
				 				element.value = count;
				 				$(row_item).remove();
				 			} else {
				 				$(row_item).remove();
				 			}
				 		});

				 		let sub_field_count = []
				 		$(document).on('click', '.remove_sub_field_btn', function(e) {
				 			e.preventDefault();
				 			let row_item = $(this).parent().parent().parent();
				 			let id = this.id;

				 			if (this.id) {
				 				sub_field_count.push(id);
				 				let element = document.getElementById('delete_sub_field_id');
				 				element.value = sub_field_count;
				 				$(row_item).remove();
				 			} else {
				 				$(row_item).remove();
				 			}
				 		});




				 		$('#roles').multiselect({
				 			buttonWidth: '100px',
				 			includeSelectAllOption: true,
				 		});

				 		$('#multiple-roles').multiselect({
				 			buttonWidth: '200px',
				 			includeSelectAllOption: true,
				 		});

				 		$('#formats').multiselect({
				 			buttonWidth: '200px',
				 			includeSelectAllOption: true,
				 		});

				 		// $('#format_mapping_form').on('submit', function(event){
				 		//     event.preventDefault();
				 		//     var form_data = $(this).serialize();
				 		//     $.ajax({
				 		//     url:"./controller/edit_mapping.php",
				 		//     method:"POST",
				 		//     data:form_data,
				 		//     success:function(data)
				 		//         {
				 		//             location.reload();
				 		//             // alert(data);
				 		//             // $('#roles option:selected').each(function(){
				 		//             //     $(this).prop('selected', false);
				 		//             //     });
				 		//             // $('#roles').multiselect('refresh');
				 		//             // alert(data);
				 		//         }
				 		//     });
				 		// });

				 		$('#format-mapping-form').on('submit', function(event) {
				 			event.preventDefault();
				 			var form_data = $(this).serialize();
				 			$.ajax({
				 				url: "./controller/add_mapping.php",
				 				method: "POST",
				 				data: form_data,
				 				success: function(data) {
				 					location.reload();
				 					//alert(data);
				 					// $('#roles option:selected').each(function(){
				 					//     $(this).prop('selected', false);
				 					//     });
				 					// $('#roles').multiselect('refresh');
				 					// alert(data);
				 				}
				 			});
				 		});

				 		$('#edit_format_mapping_form').on('submit', function(event) {
				 			event.preventDefault();
				 			var form_data = $(this).serialize();
				 			$.ajax({
				 				url: "./controller/edit_mapping.php",
				 				method: "POST",
				 				data: form_data,
				 				success: function(data) {

				 					window.location = 'mapping-template.php';

				 				}
				 			});
				 		});




				 		//ajax request to insert all form data

				 		$("#add_form").submit(function(e) {
				 			e.preventDefault();
				 			$("#add_btn").val('Adding.....');
				 			$.ajax({
				 				url: './controller/action.php',
				 				method: 'post',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					console.log(response);
				 					// window.location='dashboard.php';
				 					// $("#add_btn").val('Add');
				 					// $("#add_form")[0].reset();
				 					// $(".append_item").remove();
				 					// $(".append_section").remove();
				 					// $("#show_alert").html(`<h5>${response}</h5>`);
				 				}
				 			});
				 		});

				 		$("#edit_form").submit(function(e) {
				 			e.preventDefault();
				 			$("#edit_btn").val('Updating.....');
				 			$.ajax({
				 				url: './controller/edit_format.php',
				 				method: 'post',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					// console.log(response);
				 					$("#edit_btn").val('Edit');
				 					// // $("#edit_form")[0].reset();
				 					$(".append_item").remove();
				 					location.reload();
				 					$("#show_alert").html(`<h5>${response}</h5>`);
				 				}
				 			});
				 		});

				 		$("#edit_profile_form").submit(function(e) {
				 			e.preventDefault();
				 			$("#edit_profile_btn").val('Updating.....');
				 			var formData = new FormData(this);
				 			$.ajax({
				 				url: './controller/edit_profile.php',
				 				method: 'post',
				 				// data: $(this).serialize(),
				 				data: formData,
				 				contentType: false, // Required for file upload
				 				processData: false,
				 				success: function(response) {
				 					console.log(response);
				 					$("#edit_profile_btn").val('Save');
				 					alert(response);
				 					// // $("#edit_form")[0].reset();
				 					// $(".append_item").remove();
				 					//location.reload();
				 					// $("#show_alert").html(`<h5>${response}</h5>`);
				 				}
				 			});
				 		});

				 		$("#change_password_form").submit(function(e) {
				 			//e.preventDefault();
				 			$("#change_password_btn").val('Updating.....');
				 			$.ajax({
				 				url: './controller/change_password.php',
				 				method: 'post',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					// console.log(response);
				 					$("#change_password_btn").val('Change Password');
				 					// $("#change_password_form").reset();
				 					// $(".append_item").remove();
				 					// location.reload();
				 					$("#show_alert").html(`<h5>${response}</h5>`);
				 					location.reload();
				 				}
				 			});
				 		});


				 		$("#filter_form").submit(function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filters.php',
				 				type: 'post',
				 				data: $(this).serialize(),
				 				// type: 'post',
				 				dataType: 'JSON',
				 				success: function(response) {
				 					// alert(response);
				 					let data = JSON.stringify(response);
				 					// alert(data);
				 					if (data == "null") {

				 						$("#error_show").removeClass('hidden');
				 						// $("#error_show").text('No Data Found');

				 						$('#userTable').parents('div.dataTables_wrapper').first().hide();
				 						$("#userTable").addClass('hidden');
				 						// $("#userTableFilter").hide();

				 						$('#userTableFilter_wrapper').addClass('hidden');
				 						$('#userTableFilter').parents('div.dataTables_wrapper').first().hide();
				 						$("#userTableFilter").addClass('hidden');
				 						var len = 0;

				 						if ($.fn.DataTable.isDataTable('#userTableFilter')) {
				 							// Destroy the existing DataTable instance
				 							$('#userTableFilter').DataTable().destroy();
				 						}

				 						if ($.fn.DataTable.isDataTable('#userTable')) {
				 							// Destroy the existing DataTable instance
				 							$('#userTable').DataTable().destroy();
				 						}
				 						// Destroy the existing DataTable instance
				 						$('#userTableFilter').DataTable().destroy();

				 						// Show the parent div
				 						$('#userTableFilter').parents('div.dataTables_wrapper').first().show();
				 					} else {
				 						// $('#default-filter-table_wrapper').addClass('hidden');
				 						$('#userTable').parents('div.dataTables_wrapper').first().hide();
				 						$("#userTable").addClass('hidden');

				 						if ($.fn.DataTable.isDataTable('#userTable')) {
				 							// Destroy the existing DataTable instance
				 							$('#userTable').DataTable().destroy();
				 						}

				 						$("#userTableFilter").removeClass('hidden');

				 						if ($.fn.DataTable.isDataTable('#userTableFilter')) {
				 							// Destroy the existing DataTable instance
				 							$('#userTableFilter').DataTable().destroy();
				 						}
				 						// Destroy the existing DataTable instance
				 						$('#userTableFilter').DataTable().destroy();

				 						// Show the parent div
				 						$('#userTableFilter').parents('div.dataTables_wrapper').first().show();




				 						// $('#filter-report-table tbody').empty();

				 						// $("#error_show").addClass('hidden');
				 						$("#userTableFilter").show();

				 						var len = response.length;


				 					}


				 					$("#userTable").hide();
				 					$("#userTableFilter").removeClass('hidden');
				 					$('#userTableFilter tbody').empty();


				 					for (var i = 0; i < len; i++) {
				 						var id = response[i].id;
				 						var name = response[i].name;
				 						var email = response[i].email;
				 						var phone = response[i].phone;
				 						var designation = response[i].designation;
				 						var role = response[i].roles_array;
				 						var pwd = response[i].password;
				 						var district = response[i].district_name;
				 						var status = response[i].status;


				 						var tr_str = "<tr>" +
				 							"<td>" + (i + 1) + "</td>" +
				 							"<td>" + name + "</td>" +
				 							"<td>" + email + "</td>" +
				 							"<td>" + pwd + "</td>" +
				 							"<td>" + phone + "</td>" +
				 							"<td>" + district + "</td>" +
				 							"<td>" + designation + "</td>" +
				 							"<td>" + role + "</td>" +
				 							"<td>" + status + "</td>" +

				 							` <td>
                                    <a href="edit-user.php?id=${id}"><i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i> </a>
                            </td>` +
				 							` <td>
                                    
                                    <button class="btn btn-block btn-primary text-center send-message-btn" data-id="${id}">Send Message</button>
                            </td>`
				 						"</tr>";


				 						$("#userTableFilter tbody").append(tr_str);
				 					}


				 					var table = $('#userTableFilter').DataTable({
				 						select: false,
				 						"columnDefs": [{
				 							className: "Name",
				 							// "targets":[0],
				 							"visible": false,
				 							"searchable": false
				 						}]
				 					});


				 				}
				 			});
				 		});


				 		$("#filter_referral_form").submit(function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/referral_filters.php',
				 				type: 'post',
				 				data: $(this).serialize(),
				 				// type: 'post',
				 				dataType: 'JSON',
				 				success: function(response) {
				 					// console.log(response);
				 					let data = JSON.stringify(response);
				 					// alert(data);
				 					if (data == "null") {

				 						$("#error_show").removeClass('hidden');
				 						// $("#error_show").text('No Data Found');

				 						$('#referralTable').parents('div.dataTables_wrapper').first().hide();
				 						$("#referralTable").addClass('hidden');
				 						// $("#userTableFilter").hide();

				 						$('#referralTableFilter_wrapper').addClass('hidden');
				 						$('#referralTableFilter').parents('div.dataTables_wrapper').first().hide();
				 						$("#referralTableFilter").addClass('hidden');
				 						var len = 0;

				 						if ($.fn.DataTable.isDataTable('#referralTableFilter')) {
				 							// Destroy the existing DataTable instance
				 							$('#referralTableFilter').DataTable().destroy();
				 						}

				 						if ($.fn.DataTable.isDataTable('#referralTable')) {
				 							// Destroy the existing DataTable instance
				 							$('#referralTable').DataTable().destroy();
				 						}
				 						// Destroy the existing DataTable instance
				 						$('#referralTableFilter').DataTable().destroy();

				 						// Show the parent div
				 						$('#referralTableFilter').parents('div.dataTables_wrapper').first().show();
				 					} else {
				 						// $('#default-filter-table_wrapper').addClass('hidden');
				 						$('#referralTable').parents('div.dataTables_wrapper').first().hide();
				 						$("#referralTable").addClass('hidden');

				 						if ($.fn.DataTable.isDataTable('#referralTable')) {
				 							// Destroy the existing DataTable instance
				 							$('#referralTable').DataTable().destroy();
				 						}

				 						$("#referralTableFilter").removeClass('hidden');

				 						if ($.fn.DataTable.isDataTable('#referralTableFilter')) {
				 							// Destroy the existing DataTable instance
				 							$('#referralTableFilter').DataTable().destroy();
				 						}
				 						// Destroy the existing DataTable instance
				 						$('#referralTableFilter').DataTable().destroy();

				 						// Show the parent div
				 						$('#referralTableFilter').parents('div.dataTables_wrapper').first().show();




				 						// $('#filter-report-table tbody').empty();

				 						// $("#error_show").addClass('hidden');
				 						$("#referralTableFilter").show();

				 						var len = response.length;


				 					}


				 					$("#referralTable").hide();
				 					$("#referralTableFilter").removeClass('hidden');
				 					$('#referralTableFilter tbody').empty();


				 					for (var i = 0; i < len; i++) {
				 						var id = response[i].id;
				 						var patient_name = response[i].patient_name;
				 						var patient_mobile_no = response[i].patient_mobile_no;
				 						var differential_diagnosis = response[i].differential_diagnosis;
				 						var place_of_referral = response[i].place_of_referral;
				 						var date_of_referral = response[i].date_of_referral;
				 						var follow_up_date = response[i].follow_up_date;
				 						var remarks = response[i].remarks;
				 						var added_by = response[i].name;
				 						var added_by_role = response[i].role;
				 						var division_name = response[i].division_name;
				 						var district_name = response[i].district_name;
				 						const userRole = '<?php echo $_SESSION["user_role"]; ?>';

				 						let editColumn = "";
				 						if (userRole !== "admin" && userRole !== "DNO") {
				 							editColumn = `
                                <td>
                                    <a href="edit-referral.php?id=${id}">
                                        <i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i>
                                    </a>
                                </td>`;
				 						}


				 						var tr_str = "<tr>" +
				 							"<td>" + (i + 1) + "</td>" +
				 							"<td>" + added_by + "</td>" +
				 							"<td>" + added_by_role + "</td>" +
				 							"<td>" + division_name + "</td>" +
				 							"<td>" + district_name + "</td>" +
				 							"<td>" + patient_name + "</td>" +
				 							"<td>" + patient_mobile_no + "</td>" +
				 							"<td>" + differential_diagnosis + "</td>" +
				 							"<td>" + place_of_referral + "</td>" +
				 							"<td>" + date_of_referral + "</td>" +
				 							"<td>" + follow_up_date + "</td>" +
				 							"<td>" + remarks + "</td>" +
				 							editColumn +




				 							"</tr>";


				 						$("#referralTableFilter tbody").append(tr_str);
				 					}


				 					var table = $('#referralTableFilter').DataTable({
				 						select: false,
				 						"columnDefs": [{
				 							className: "Name",
				 							// "targets":[0],
				 							"visible": false,
				 							"searchable": false
				 						}]
				 					});


				 				}
				 			});
				 		});

				 		// <a href="./controller/send-message.php?id=${id}"><button class="btn btn-block btn-primary text-center">Send Message</button></a>

				 		$(document).ready(function() {
				 			$.ajax({
				 				url: './controller/get_user_lisitng.php',
				 				type: 'get',
				 				//type: 'post',
				 				dataType: 'JSON',
				 				success: function(response) {
				 					// alert(response);

				 					let data = JSON.stringify(response);
				 					var len = response.length;

				 					for (var i = 0; i < len; i++) {
				 						var id = response[i].userid;
				 						var name = response[i].name;
				 						var email = response[i].email;
				 						var phone = response[i].phone;
				 						var designation = response[i].designation;
				 						var role = response[i].roles_array;
				 						var pwd = response[i].password;
				 						var district = response[i].district_name;
				 						var total_users_in_district = response[i].total_district_user_count;
				 						var filled_data_user_count = response[i].filled_data_user_count;
				 						var status = response[i].status;


				 						// var last_login=response[i].last_login;
				 						// var last_logout=response[i].last_logout;


				 						var tr_str = "<tr>" +
				 							"<td>" + (i + 1) + "</td>" +
				 							"<td>" + name + "</td>" +
				 							"<td>" + email + "</td>" +
				 							"<td>" + pwd + "</td>" +
				 							"<td>" + phone + "</td>" +
				 							"<td>" + district + "</td>" +
				 							"<td>" + designation + "</td>" +
				 							"<td>" + role + "</td>" +
				 							"<td>" + total_users_in_district + "</td>" +
				 							"<td>" + filled_data_user_count + "</td>" +
				 							"<td>" + status + "</td>" +


				 							` <td>
                                    <a href="edit-user.php?id=${id}"><i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i> </a>
                            </td>` +
				 							` <td>
                                    
                                    <button class="btn btn-block btn-primary text-center send-message-btn" data-id="${id}">Send Message</button>
                            </td>`
				 						"</tr>";

				 						$("#userTable tbody").append(tr_str);

				 					}

				 					var table = $('#userTable').DataTable({
				 						select: false,
				 						"columnDefs": [{
				 							className: "Name",
				 							// "targets":[0],
				 							"visible": false,
				 							"searchable": false
				 						}]
				 					});

				 				}
				 			});


				 			$.ajax({
				 				url: './controller/get_referral_listing.php',
				 				type: 'get',
				 				//type: 'post',
				 				dataType: 'JSON',
				 				success: function(response) {
				 					// console.log(response);

				 					let data = JSON.stringify(response);
				 					var len = response.length;

				 					for (var i = 0; i < len; i++) {
				 						var id = response[i].id;
				 						var patient_name = response[i].patient_name;
				 						var patient_mobile_no = response[i].patient_mobile_no;
				 						var differential_diagnosis = response[i].differential_diagnosis;
				 						var place_of_referral = response[i].place_of_referral;
				 						var date_of_referral = response[i].date_of_referral;
				 						var follow_up_date = response[i].follow_up_date;
				 						var remarks = response[i].remarks;
				 						var added_by = response[i].name;
				 						var added_by_role = response[i].role;
				 						var division_name = response[i].division_name;
				 						var district_name = response[i].district_name;
				 						const userRole = '<?php echo $_SESSION["user_role"]; ?>';


				 						let editColumn = "";

				 						if (userRole !== "admin" && userRole !== "DNO") {
				 							editColumn = `
                                <td>
                                    <a href="edit-referral.php?id=${id}">
                                        <i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i>
                                    </a>
                                </td>`;
				 						}

				 						// var last_login=response[i].last_login;
				 						// var last_logout=response[i].last_logout;


				 						var tr_str = "<tr>" +
				 							"<td>" + (i + 1) + "</td>" +
				 							"<td>" + added_by + "</td>" +
				 							"<td>" + added_by_role + "</td>" +
				 							"<td>" + division_name + "</td>" +
				 							"<td>" + district_name + "</td>" +
				 							"<td>" + patient_name + "</td>" +
				 							"<td>" + patient_mobile_no + "</td>" +
				 							"<td>" + differential_diagnosis + "</td>" +
				 							"<td>" + place_of_referral + "</td>" +
				 							"<td>" + date_of_referral + "</td>" +
				 							"<td>" + follow_up_date + "</td>" +
				 							"<td>" + remarks + "</td>" +

				 							editColumn

				 						"</tr>";

				 						$("#referralTable tbody").append(tr_str);

				 					}

				 					var table = $('#referralTable').DataTable({
				 						select: false,
				 						"columnDefs": [{
				 							className: "Name",
				 							// "targets":[0],
				 							"visible": false,
				 							"searchable": false
				 						}]
				 					});

				 				}
				 			});
				 		});






				 		// <a href="./controller/send-message.php?id=${id}"><button class="btn btn-block btn-primary text-center">Send Message</button></a>


				 		$(document).on('click', '.send-message-btn', function(event) {
				 			event.preventDefault(); // Prevent default button action

				 			var userId = $(this).data('id'); // Get the user ID from data-id attribute

				 			$.ajax({
				 				url: './controller/send-message.php', // URL to send the AJAX request to
				 				type: 'GET', // HTTP method to use
				 				data: {
				 					id: userId
				 				}, // Data to send in the request
				 				success: function(response) {
				 					// Handle success - you can display a message or update the UI
				 					alert('Message sent successfully!');
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle error
				 					alert('An error occurred: ' + error);
				 				}
				 			});
				 		});

				 		$("#listing_type").on('change', function() {
				 			let val = $(this).val();
				 			// alert(val);

				 			$.ajax({
				 				url: './controller/fetch_info.php',
				 				method: 'get',
				 				dataType: 'JSON',
				 				data: {
				 					value: val
				 				},
				 				success: function(response) {
				 					let data = JSON.stringify(response);

				 					if (response.length == 0) {
				 						$('#no-data').removeClass('hidden');
				 						$('#no-data').text('No Data Found !');
				 					} else {
				 						$('#no-data').addClass('hidden');
				 					}
				 					var len = response.length;
				 					if (val == 'active') {
				 						var heading_name = "Active Templates Listing";
				 					} else if (val == 'inactive') {
				 						var heading_name = "Active Templates Listing";
				 					} else {
				 						var heading_name = "All Templates Listing";
				 					}

				 					$('#type-of-template-listing').text(heading_name);

				 					$("#default-listing-table").hide();
				 					$("#filter-listing-table").removeClass('hidden');
				 					$('#filter-listing-table tbody').empty();

				 					for (var i = 0; i < len; i++) {
				 						var id = response[i].id;
				 						var format_name = response[i].format_name;
				 						var format_heading = response[i].format_heading;
				 						var status = response[i].format_status;
				 						if (status == 1) {
				 							var status_icon = "fa-toggle-on";
				 							var active = "active";
				 						} else {
				 							var status_icon = "fa-toggle-off";
				 							var active = "inactive";
				 						}



				 						var tr_str = "<tr>" +
				 							"<td><strong>" + (i + 1) + "</strong></td>" +
				 							"<td><strong>" + format_name + "</strong></td>" +
				 							"<td><strong>" + format_heading + "</strong></td>" +
				 							` <td><strong>
                                    <a href="./controller/delete-template.php?id=${id}&status=${status}"><i class="fa ${status_icon} ${active}" aria-hidden="true"></i></a>
                                    
                                    </strong></td>` +

				 							` <td><strong>
                                    <a href="format-template-view.php?id=${id}"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                    <a href="edit-template.php?id=${id}"><i class="fa fa-pencil edit" aria-hidden="true" style="margin-right:20px"></i> </a>
                                    <a href="./controller/hard-delete-template.php?id=${id}"><i class="fa fa-trash delete" aria-hidden="true"></i></a>
                                    </strong></td>`

				 						"</tr>";

				 						$("#filter-listing-table tbody").append(tr_str);

				 					}
				 				}
				 			});


				 		});


				 		$('#downloadBtn').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_report_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/download_juoi.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);

				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					// alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);


				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});





				 		$('#download_referral_btn').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_referral_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/download_referral_reports.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);

				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					// alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);


				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});


				 		$("#downloadZip").click(function() {
				 			let startMonth = "2025-02"; // Example: January 2024
				 			let endMonth = "2025-02"; // Example: February 2024

				 			$.ajax({
				 				url: "./controller/download_camps.php",
				 				type: "POST",
				 				data: {
				 					start: startMonth,
				 					end: endMonth
				 				},
				 				xhr: function() {
				 					let xhr = new XMLHttpRequest();
				 					xhr.responseType = "blob"; // Handle binary data properly
				 					return xhr;
				 				},
				 				success: function(blob, status, xhr) {

				 					if (!blob || blob.size === 0) {
				 						alert("Error: ZIP file is empty or corrupted.");
				 						return;
				 					}
				 					let filename = "camp_images.zip";


				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					// alert(xhr);
				 					if (disposition && disposition.indexOf("attachment") !== -1) {
				 						let matches = disposition.match(/filename="?(.+)"?/);
				 						if (matches !== null && matches[1]) {
				 							filename = matches[1];
				 						}
				 					}

				 					// let blob = new Blob([data], { type: "application/zip" });
				 					let link = document.createElement("a");
				 					link.href = window.URL.createObjectURL(blob);
				 					link.href = url;
				 					link.download = filename;
				 					// link.download = filename;
				 					document.body.appendChild(link);
				 					link.click();
				 					document.body.removeChild(link);
				 					window.URL.revokeObjectURL(url); // Free memory

				 				},
				 				error: function(xhr, status, error) {
				 					alert("Error: " + error);
				 				}
				 			});
				 		});






				 		$('#downloadOutsouceDataBtn').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_outsource_report_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/doownload_outsource_data_excel.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);

				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);


				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});





				 		// $('#dateInput').change(function() {
				 		//     var date = new Date($(this).val());
				 		//     // var month = date.toLocaleString('default', { month: 'long' }); // Get month name (e.g., January)
				 		//     var year = date.getFullYear(); // Get full year (e.g., 2024)
				 		//     var month = (date.getMonth() + 1).toString().padStart(2, '0');
				 		//     // Set the values in the month and year input fields
				 		//     $('#monthInput').val(month);
				 		//     $('#yearInput').val(year);
				 		// });


				 		$('#editFormDataButton').click(function() {
				 			// Define the parameters

				 			var id = $('input[name="id"]').val();
				 			var user_id = $('input[name="user_id"]').val();
				 			var role_id = $('input[name="role_id"]').val();
				 			var date = $('input[name="date"]').val();
				 			// var id = 15;
				 			// var user_id = 13;
				 			// var role_id = 2;
				 			// var date = '07/25/2024'; // You can dynamically get this value from a date picker or another input

				 			// Construct the URL
				 			var url = "edit-format-data.php?id=" + id + "&user_id=" + user_id + "&role_id=" + role_id + "&date=" + encodeURIComponent(date);

				 			// Perform the redirect using JavaScript
				 			window.location.href = url;
				 		});





				 		$("#filter_report_form").submit(function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filter_report.php',
				 				method: 'post',
				 				dataType: 'JSON',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					// alert(response);
				 					let data = JSON.stringify(response);

				 					if (Object.keys(response).length == 0) {
				 						$('#alert-data').removeClass('hidden');
				 						$('#alert-data').text('No Data Found !');

				 						$("#filter-report-table").addClass('hidden');
				 						$('#default-filter-table_wrapper').addClass('hidden');
				 						$('#default-filter-table').parents('div.dataTables_wrapper').first().hide();
				 						$("#default-filter-table").addClass('hidden');

				 						$('#filter-report-table_wrapper').addClass('hidden');
				 						$('#filter-report-table').parents('div.dataTables_wrapper').first().hide();
				 						$("#filter-report-table").addClass('hidden');
				 					} else {
				 						$('#alert-data').addClass('hidden');

				 						var len = Object.keys(response).length;


				 						// $('#type-of-template-listing').text(heading_name);
				 						$('#default-filter-table_wrapper').addClass('hidden');
				 						$('#default-filter-table').parents('div.dataTables_wrapper').first().hide();
				 						$("#default-filter-table").addClass('hidden');

				 						$("#filter-report-table").removeClass('hidden');

				 						if ($.fn.DataTable.isDataTable('#filter-report-table')) {
				 							// Destroy the existing DataTable instance
				 							$('#filter-report-table').DataTable().destroy();
				 						}
				 						// Destroy the existing DataTable instance
				 						// $('#filter-report-table').DataTable().destroy();

				 						// Show the parent div
				 						$('#filter-report-table').parents('div.dataTables_wrapper').first().show();




				 						$('#filter-report-table tbody').empty();

				 						// var link="<?php echo $_SESSION['link']; ?>";
				 						// alert(link);

				 						// $('#myLink').attr('href', link);



				 						for (var i = 0; i < len; i++) {
				 							// var id = response[i].id;
				 							var id = Object.keys(response)[i];
				 							var user_name = response[id].user_name;
				 							var format_name = response[id].format_name;
				 							var format_heading = response[id].format_heading;
				 							var district_name = response[id].district_name;
				 							var role = response[id].role;
				 							var month = response[id].month;
				 							var year = response[id].year;
				 							var status = response[id].status;
				 							var role_id = response[id].role_id;

				 							var user_id = response[id].user_id;


				 							var format_id = response[id].format_id;
				 							var district_id = response[id].district_id;

				 							var user_role = "<?php echo $_SESSION['user_role']; ?>";







				 							// if(status==1){
				 							//     var status_icon="fa-toggle-on";
				 							//     var active="active";
				 							// }
				 							// else{
				 							//     var status_icon="fa-toggle-off";
				 							//     var active="inactive";
				 							// }
				 							if (status == 1) {
				 								var stats = "Verified";
				 							} else if (status == 3) {
				 								var stats = "Semi-verified";
				 							} else {
				 								var stats = "Unverfied";
				 							}



				 							var tr_str = `<tr>
                                                <td><strong>${i+1}</strong></td>
                                                <td><strong>${user_name}</strong></td>
                                                <td><strong>${district_name}</strong></td>
                                                <td><strong>${role}</strong></td>
                                                <td><strong>${format_name}</strong></td>
                                                
                                                <td><strong>${month}-${year}</strong></td>
                                                <td><strong>${stats}</strong></td>
                                                
                                                <td>`;
				 							if (user_role && user_role == "admin") {
				 								tr_str += `<a href="report-view.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&district_id=${district_id}&month=${month}&year=${year}"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>`;
				 							} else {
				 								tr_str += ` <a href="report-view.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&month=${month}&year=${year}"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <!-- <a href="format-template-view.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil edit" aria-hidden="true"></i> </a> -->
                                                    <a href="./controller/verify_data.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&month=${month}&year=${year}"><i class="fa fa-check-circle verified" aria-hidden="true" style="margin-right:20px"></i> </a>
                                                    <a href="./controller/unverify_data.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&month=${month}&year=${year}"><i class="fa fa-check-circle-o unverified" aria-hidden="true"></i> </a>`
				 							}

				 							tr_str += ` </td>
                                    </tr>`;


				 							$("#filter-report-table tbody").append(tr_str);
				 						}
				 						var table = $('#filter-report-table').DataTable({
				 							select: false,
				 							"columnDefs": [{
				 								className: "Name",
				 								// "targets":[0],
				 								"visible": false,
				 								"searchable": false
				 							}]
				 						});

				 					}



				 				}
				 			});
				 		});






				 		$("#filter_outsource_report_form").submit(function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filter_outsource_report.php',
				 				method: 'post',
				 				dataType: 'JSON',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					// console.log(response);
				 					let data = JSON.stringify(response);

				 					if (Object.keys(response).length == 0) {
				 						$('#alert-data').removeClass('hidden');
				 						$('#alert-data').text('No Data Found !');

				 						$("#filter-outsource-report-table").addClass('hidden');
				 						$('#default-filter-table_wrapper').addClass('hidden');
				 						$('#default-outsource-filter-table').parents('div.dataTables_wrapper').first().hide();
				 						$("#default-outsource-filter-table").addClass('hidden');

				 						$('#filter-report-table_wrapper').addClass('hidden');
				 						$('#filter-outsource-report-table').parents('div.dataTables_wrapper').first().hide();
				 						$("#filter-outsource-report-table").addClass('hidden');
				 					} else {
				 						$('#alert-data').addClass('hidden');

				 						var len = Object.keys(response).length;


				 						// $('#type-of-template-listing').text(heading_name);
				 						$('#default-filter-table_wrapper').addClass('hidden');
				 						$('#default-outsource-filter-table').parents('div.dataTables_wrapper').first().hide();
				 						$("#default-outsource-filter-table").addClass('hidden');

				 						$("#filter-outsource-report-table").removeClass('hidden');

				 						if ($.fn.DataTable.isDataTable('#filter-outsource-report-table')) {
				 							// Destroy the existing DataTable instance
				 							$('#filter-report-table').DataTable().destroy();
				 						}
				 						// Destroy the existing DataTable instance
				 						// $('#filter-report-table').DataTable().destroy();

				 						// Show the parent div
				 						$('#filter-outsource-report-table').parents('div.dataTables_wrapper').first().show();




				 						$('#filter-outsource-report-table tbody').empty();


				 						for (var i = 0; i < len; i++) {
				 							// var id = response[i].id;
				 							var id = Object.keys(response)[i];
				 							var user_name = response[id].name;
				 							var district_name = response[id].district_name;
				 							var role = response[id].role;
				 							var format_name = "Outsource Data";
				 							var month_date = response[id].created_at;


				 							var hospitalName = response[i].hospital_name; // Hospital Name
				 							var hospitalAddress = response[i].hospital_address; // Hospital Address
				 							var employeeName = response[i].employee_name; // Employee Name
				 							var fatherHusbandName = response[i].father_husband_name; // Employee Father/Husband Name
				 							var aadharCardNumber = response[i].aadhar_card; // Aadhar Card Number
				 							var mobileNumber = response[i].mobile_no; // Mobile Number
				 							var designation = response[i].designation; // Designation
				 							var gender = response[i].gender; // Gender
				 							var employeeCategory = response[i].employee_category; // Employee Category (GN/OBC/SC/ST)
				 							var employeeSubCategory = response[i].sub_category; // Employee Category (GN/OBC/SC/ST)
				 							var employeeEpfNo = response[i].emp_epf_no ? response[i].emp_epf_no : "NA"; // Employee Category (GN/OBC/SC/ST)
				 							var employeeEsicNo = response[i].emp_esic_no ? response[i].emp_esic_no : "NA"; // Employee Category (GN/OBC/SC/ST)
				 							var category = response[i].skilled_unskilled; // Category (Skilled/Unskilled)
				 							var joiningDate = response[i].joining_date; // Date of Joining
				 							var outsourcingAgencyName = response[i].agency_name; // Outsourcing Agency Name
				 							var outsourcingAgencyMobile = response[i].agency_mobile; // Outsourcing Agency Name
				 							var outsourcingAgencyEmail = response[i].agency_email; // Outsourcing Agency Name
				 							var outsourcingAgencyAddress = response[i].agency_address; // Outsourcing Agency Name
				 							var outsourcingAgencyCpName = response[i].agency_cp_name; // Outsourcing Agency Name
				 							var outsourcingAgencyCpMobile = response[i].agency_cp_mobile; // Outsourcing Agency Name
				 							var minimumWage = response[i].minimum_wage; // Minimum Wage per Month
				 							var epf = response[i].epf; // EPF @13%
				 							var esi = response[i].esi; // ESI @3.25%
				 							var gross = response[i].gross; // Gross
				 							var totalCost = response[i].total_cost; // Total Cost
				 							var agencyServiceCharge = response[i].agency_charge_percent; // Agency Service Charge
				 							var gst = response[i].gst_percent; // GST
				 							var grandTotal = response[i].grand_total; // Grand Total
				 							var employeeStatus = response[i].employee_status; // Grand Total
				 							var employeeStatusReason = response[i].emp_status_reason ? response[i].emp_status_reason : "NA"; // Grand Total
				 							var postType = response[i].post_type; // Employee Post Against (Sanctioned/Non-Sanctioned)
				 							var sanctionedPost = response[i].sanctioned_post ? response[i].sanctioned_post : "NA"; // Number of Sanctioned Posts
				 							var remarks = response[i].remarks ? response[i].remarks : "NA"; // Remark
				 							var grade = "Grade " + response[i].grade;

				 							var government_order = response[i].government_order;
				 							var files = government_order.split(','); // Split the string into an array
				 							var fileLinks = '';

				 							files.forEach(file => {
				 								var filePath = `${window.location.origin}/uploads/${file.trim()}`; // Generate the file path
				 								fileLinks += `<a href="${filePath}" target="_blank">${file}</a><br>`; // Create the <a> tag for each file
				 							});





				 							var user_role = "<?php echo $_SESSION['user_role']; ?>";







				 							// if(status==1){
				 							//     var status_icon="fa-toggle-on";
				 							//     var active="active";
				 							// }
				 							// else{
				 							//     var status_icon="fa-toggle-off";
				 							//     var active="inactive";
				 							// }
				 							// if(status==1){
				 							//     var stats="Verified";
				 							// }
				 							// else if(status==3){
				 							//     var stats="Semi-verified";
				 							// }
				 							// else{
				 							//     var stats="Unverfied";
				 							// }



				 							var tr_str = `<tr>
                                                <td><strong>${i+1}</strong></td>
                                                <td><strong>${user_name}</strong></td>
                                                <td><strong>${district_name}</strong></td>
                                                <td><strong>${role}</strong></td>
                                                <td><strong>${format_name}</strong></td>
                                                
                                                <td><strong>${hospitalName}</strong></td>
                                                <td><strong>${hospitalAddress}</strong></td>
                                                <td><strong>${employeeName}</strong></td>
                                                <td><strong>${fatherHusbandName}</strong></td>
                                                <td><strong>${aadharCardNumber}</strong></td>
                                                <td><strong>${mobileNumber}</strong></td>
                                                <td><strong>${designation}</strong></td>
                                                <td><strong>${gender}</strong></td>
                                                <td><strong>${grade}</strong></td>
                                                <td><strong>${employeeCategory}</strong></td>
                                                <td><strong>${employeeSubCategory}</strong></td>
                                                <td><strong>${employeeEpfNo}</strong></td>
                                                <td><strong>${employeeEsicNo}</strong></td>
                                                <td><strong>${category}</strong></td>
                                                <td><strong>${joiningDate}</strong></td>
                                                <td><strong>${outsourcingAgencyName}</strong></td>
                                                <td><strong>${outsourcingAgencyMobile}</strong></td>
                                                <td><strong>${outsourcingAgencyEmail}</strong></td>
                                                <td><strong>${outsourcingAgencyAddress}</strong></td>
                                                <td><strong>${outsourcingAgencyCpName}</strong></td>
                                                <td><strong>${outsourcingAgencyCpMobile}</strong></td>
                                                <td><strong>${minimumWage}</strong></td>
                                                <td><strong>${epf}</strong></td>
                                                <td><strong>${esi}</strong></td>
                                                <td><strong>${gross}</strong></td>
                                                <td><strong>${totalCost}</strong></td>
                                                <td><strong>${agencyServiceCharge}</strong></td>
                                                <td><strong>${gst}</strong></td>
                                                <td><strong>${grandTotal}</strong></td>
                                                <td><strong>${employeeStatus}</strong></td>
                                                <td><strong>${employeeStatusReason}</strong></td>
                                                <td><strong>${postType}</strong></td>
                                                <td><strong>${sanctionedPost}</strong></td>
                                                <td><strong>${remarks}</strong></td>
                                                <td><strong>${fileLinks}</strong></td>

                                              
                                                
                                                <td>`;
				 							// if(user_role && user_role=="admin"){
				 							//     tr_str += `<a href="report-view.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&district_id=${district_id}&month=${month}&year=${year}"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>`;
				 							// }
				 							// else{
				 							//     tr_str += ` <a href="report-view.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&month=${month}&year=${year}"><i class="fa fa-eye view" aria-hidden="true" style="margin-right:20px"></i> </a>
				 							//                             <!-- <a href="format-template-view.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil edit" aria-hidden="true"></i> </a> -->
				 							//                             <a href="./controller/verify_data.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&month=${month}&year=${year}"><i class="fa fa-check-circle verified" aria-hidden="true" style="margin-right:20px"></i> </a>
				 							//                             <a href="./controller/unverify_data.php?id=${format_id}&user_id=${user_id}&role_id=${role_id}&month=${month}&year=${year}"><i class="fa fa-check-circle-o unverified" aria-hidden="true"></i> </a>`
				 							// }

				 							tr_str += ` </td>
                                    </tr>`;


				 							$("#filter-outsource-report-table tbody").append(tr_str);
				 						}
				 						var table = $('#filter-outsource-report-table').DataTable({
				 							select: false,
				 							"columnDefs": [{
				 								className: "Name",
				 								// "targets":[0],
				 								"visible": false,
				 								"searchable": false
				 							}]
				 						});

				 					}



				 				}
				 			});
				 		});







				 		// $("#add_user_form").submit(function(e){
				 		//     e.preventDefault();
				 		//     $("#save_user_btn").val('Adding.....');
				 		//     $.ajax({
				 		//         url: './controller/add_user.php',
				 		//         method:'post',
				 		//         data: $(this).serialize(),
				 		//         success: function(response){
				 		//             // console.log(response);
				 		//            location.reload();
				 		//         }
				 		//     });
				 		// });

				 		$("#save_user_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#save_user_btn").val('Adding.....');
				 			var formData = $('#add_user_form').serialize();
				 			$.ajax({
				 				url: './controller/add_user.php',
				 				method: 'post',
				 				data: formData,
				 				success: function(response) {
				 					// console.log(response);
				 					location.reload();
				 				}
				 			});
				 		});

				 		$("#save_sub_user_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#save_sub_user_btn").val('Adding.....');
				 			var formData = $('#add_user_form').serialize();
				 			$.ajax({
				 				url: './controller/add_user.php',
				 				method: 'post',
				 				data: formData,
				 				success: function(response) {
				 					// console.log(response);
				 					location.reload();
				 				}
				 			});
				 		});


				 		$("#save_oral_camp_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#save_oral_camp_btn").val('Adding.....');
				 			// var formData = $('#upload_camp_image_form').serialize();
				 			var form = $('#upload_camp_image_form')[0];
				 			var formData = new FormData(form);
				 			$.ajax({
				 				url: './controller/upload_camp_image_form.php',
				 				method: 'post',
				 				data: formData,
				 				contentType: false,
				 				processData: false,
				 				success: function(response) {
				 					// alert(response);
				 					// console.log(response);
				 					$("#save_oral_camp_btn").val('Upload Camp Image');
				 					location.reload();
				 				}
				 			});
				 		});


				 		$("#save_procedure_camp_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#save_procedure_camp_btn").val('Adding.....');
				 			// var formData = $('#upload_camp_image_form').serialize();
				 			var form = $('#upload_procedure_image_form')[0];
				 			var formData = new FormData(form);
				 			$.ajax({
				 				url: './controller/upload_procedure_image_form.php',
				 				method: 'post',
				 				data: formData,
				 				contentType: false,
				 				processData: false,
				 				success: function(response) {
				 					// alert(response);
				 					// console.log(response);
				 					$("#save_procedure_camp_btn").val('Upload Camp Image');
				 					location.reload();
				 				}
				 			});
				 		});


				 		$("#save_referral_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#save_referral_btn").val('Adding.....');
				 			var formData = $('#add_referral_form').serialize();
				 			$.ajax({
				 				url: './controller/add_referral.php',
				 				method: 'post',
				 				data: formData,
				 				success: function(response) {
				 					// console.log(response);
				 					location.reload();
				 				}
				 			});
				 		});

				 		$("#edit_referral_btn").click(function(e) {
				 			e.preventDefault();
				 			$("#edit_referral_btn").val('Updating.....');
				 			var formData = $('#edit_referral_form').serialize();
				 			$.ajax({
				 				url: './controller/edit_referral.php',
				 				method: 'post',
				 				data: formData,
				 				success: function(response) {
				 					// console.log(response);
				 					location.reload();
				 				}
				 			});
				 		});















				 	});
				 </script>


				 <script>
				 	$(function() {
				 		$('input[name="filled_data_month_year"]').daterangepicker({
				 				singleDatePicker: true,
				 				showDropdowns: true,
				 				minYear: 1901,
				 				maxYear: parseInt(moment().format('YYYY'), 10)
				 			},
				 			// function(start, end, label) {
				 			//     var years = moment().diff(start, 'years');
				 			//     alert("You are " + years + " years old!");
				 			// }
				 		);
				 	});
				 </script>

				 <script>
				 	$(document).ready(function() {



				 		var table = $('#default-filter-table').DataTable({
				 			select: false,
				 			"columnDefs": [{
				 				className: "Name",
				 				// "targets":[0],
				 				"visible": false,
				 				"searchable": false
				 			}]
				 		}); //End of create main table


				 	});

				 	function fetchDistricts(divisionId) {
				 		if (divisionId) {
				 			alert(divisionId);
				 			fetch(`./controller/getDistricts.php?division_id=${divisionId}`)
				 				.then(response => response.json())
				 				.then(data => {
				 					let districtSelect = document.getElementById('district');
				 					districtSelect.innerHTML = '<option value="">------ Select District --------</option>';
				 					data.forEach(district => {
				 						let option = document.createElement('option');
				 						option.value = district.id;
				 						option.textContent = district.district_name;
				 						districtSelect.appendChild(option);
				 					});
				 				});
				 		}
				 	}


				 	function getDistrict(division) {
				 		// alert(division);
				 		$.ajax({
				 			type: "GET",
				 			url: "./controller/fetch_districts.php",
				 			data: {
				 				division_id: division
				 			},
				 			success: function(response) {
				 				console.log(response);
				 				$("#selectDistrict").html(response);
				 			}
				 		});
				 	}
				 </script>

				 <script>
				 	// const postType = document.getElementById('post_type');  
				 	// const sanctionedPostGroup = document.getElementById('sanctioned_post_group');
				 	// const remarksGroup = document.getElementById('remarks_group');

				 	// postType.addEventListener('change', () => {
				 	//     if (postType.value === 'sanctioned') {
				 	//         sanctionedPostGroup.classList.remove('hidden');
				 	//         remarksGroup.classList.add('hidden');
				 	//     } else if (postType.value === 'non-sanctioned') {
				 	//         remarksGroup.classList.remove('hidden');
				 	//         sanctionedPostGroup.classList.add('hidden');
				 	//     } else {
				 	//         sanctionedPostGroup.classList.add('hidden');
				 	//         remarksGroup.classList.add('hidden');
				 	//     }
				 	// });

				 	document.addEventListener('DOMContentLoaded', () => {
				 		const postType = document.getElementById('post_type');
				 		const sanctionedPostGroup = document.getElementById('sanctioned_post_group');
				 		const remarksGroup = document.getElementById('remarks_group');

				 		function updateVisibility() {
				 			if (postType.value === 'sanctioned') {
				 				sanctionedPostGroup.classList.remove('hidden');
				 				remarksGroup.classList.add('hidden');
				 			} else if (postType.value === 'non-sanctioned') {
				 				remarksGroup.classList.remove('hidden');
				 				sanctionedPostGroup.classList.add('hidden');
				 			} else {
				 				sanctionedPostGroup.classList.add('hidden');
				 				remarksGroup.classList.add('hidden');
				 			}
				 		}

				 		// Initialize visibility on page load
				 		updateVisibility();

				 		// Attach event listener
				 		postType.addEventListener('change', updateVisibility);
				 	});
				 </script>


				 <script>
				 	const minimumWageInput = document.getElementById('minimum_wage');
				 	const epfInput = document.getElementById('epf');
				 	const esiInput = document.getElementById('esi');
				 	const grossInput = document.getElementById('gross');
				 	const totalCostInput = document.getElementById('total_cost');
				 	const agencyChargePercentInput = document.getElementById('agency_charge_percent'); // Percent input
				 	const gstPercentInput = document.getElementById('gst_percent'); // Percent input
				 	const agencyChargeAmountInput = document.getElementById('agency_charge_amount'); // Computed amount
				 	const gstAmountInput = document.getElementById('gst_amount'); // Computed amount
				 	const grandTotalInput = document.getElementById('grand_total');

				 	// Event listeners for dynamic calculations
				 	minimumWageInput.addEventListener('input', calculateFields);
				 	agencyChargePercentInput.addEventListener('input', calculateFields);
				 	gstPercentInput.addEventListener('input', calculateFields);

				 	function calculateFields() {
				 		const minimumWage = parseFloat(minimumWageInput.value) || 0;
				 		const agencyChargePercent = parseFloat(agencyChargePercentInput.value) || 0;
				 		const gstPercent = parseFloat(gstPercentInput.value) || 0;

				 		// Calculate EPF (13%) and ESI (3.25%)
				 		const epf = (minimumWage * 13) / 100;
				 		const esi = (minimumWage * 3.25) / 100;

				 		// Calculate Gross = Minimum Wage + EPF + ESI
				 		const gross = minimumWage + epf + esi;

				 		// Total Cost = Gross
				 		const totalCost = gross;

				 		// Calculate Agency Charge (percent of Total Cost)


				 		const agencyChargeAmount = (totalCost * agencyChargePercent) / 100;

				 		// Calculate GST (percent of Total Cost + Agency Charge)
				 		const gstAmount = ((totalCost + agencyChargeAmount) * gstPercent) / 100;

				 		// Grand Total = Total Cost + Agency Charge Amount + GST Amount
				 		const grandTotal = totalCost + agencyChargeAmount + gstAmount;

				 		// Set calculated values in the fields
				 		epfInput.value = epf.toFixed(2);
				 		esiInput.value = esi.toFixed(2);
				 		grossInput.value = gross.toFixed(2);
				 		totalCostInput.value = totalCost.toFixed(2);
				 		agencyChargeAmountInput.value = agencyChargeAmount.toFixed(2);
				 		gstAmountInput.value = gstAmount.toFixed(2);
				 		grandTotalInput.value = grandTotal.toFixed(2);
				 	}

				 	document.addEventListener('DOMContentLoaded', () => {
				 		calculateFields(); // Trigger the calculation when the page loads
				 	});

				 	$(document).ready(function() {
				 		// This will make all form inputs automatically convert to uppercase as you type
				 		$('input').on('input', function() {
				 			$(this).val($(this).val().toUpperCase());
				 		});
				 	});

				 	document.getElementById('designation').addEventListener('input', function(event) {
				 		// Remove slashes and special characters (except spaces, alphabets, and numbers)
				 		this.value = this.value.replace(/[^\w\s]/gi, '');
				 	});
				 </script>

				 <script>
				 	$(document).ready(function() {
				 		let maxCount = 1; // Maximum additional times the form can be added
				 		let count = 0;

				 		$(document).on('click', '.add-oral-image-btn', function() {
				 			if (count < maxCount) {
				 				let newFields = $('.camp-fields:first').clone();
				 				newFields.find('input').val(""); // Clear input fields
				 				newFields.append('<div class="col-md-2 col-xs-12 d-flex align-items-center" style="margin-top:10px"><button type="button" class="btn btn-danger remove-btn">-</button></div>');
				 				$('#camp-container').append(newFields);
				 				count++;
				 			}
				 		});

				 		$(document).on('click', '.remove-btn', function() {
				 			$(this).closest('.camp-fields').remove();
				 			count--;
				 		});

				 		$(document).on('change', '.file-input', function() {
				 			let file = this.files[0];
				 			let fileError = $(this).closest('.form-group').find('.file-error');

				 			if (file) {
				 				let fileType = file.type;
				 				let fileSize = file.size / 1024 / 1024; // Convert size to MB
				 				let allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

				 				if (!allowedTypes.includes(fileType)) {
				 					fileError.text("Invalid file type! Only JPG, JPEG, and PNG are allowed.");
				 					$(this).val(''); // Clear the input
				 				} else if (fileSize > 2) {
				 					fileError.text("File size exceeds 2MB.");
				 					$(this).val(''); // Clear the input
				 				} else {
				 					fileError.text(""); // No error
				 				}
				 			}
				 		});

				 		$.ajax({
				 			url: './controller/oral_awareness_images.php',
				 			type: 'POST',
				 			success: function(response) {
				 				const $slider = $('#imageSlider');
				 				$slider.html(response);

				 				if ($slider.hasClass('slick-initialized')) {
				 					$slider.slick('unslick');
				 				}

				 				if ($slider.children().length > 0) {
				 					$slider.slick({
				 						slidesToShow: 2,
				 						slidesToScroll: 1,
				 						autoplay: true,
				 						autoplaySpeed: 2000,
				 						arrows: true,
				 						dots: false
				 					});
				 				}
				 			}
				 		});


				 		$.ajax({
				 			url: './controller/critical_procedures_images.php',
				 			type: 'POST',
				 			success: function(response) {
				 				const $slider = $('#imageProcedureSlider');
				 				$slider.html(response);

				 				if ($slider.hasClass('slick-initialized')) {
				 					$slider.slick('unslick');
				 				}

				 				if ($slider.children().length > 0) {
				 					$slider.slick({
				 						slidesToShow: 2,
				 						slidesToScroll: 1,
				 						autoplay: true,
				 						autoplaySpeed: 2000,
				 						arrows: true,
				 						dots: false
				 					});
				 				}
				 			}
				 		});





				 		$('#filterOralForm').on('submit', function(e) {
				 			e.preventDefault(); // Prevent form from reloading the page

				 			const formData = $(this).serialize(); // Serialize form values

				 			$.ajax({
				 				url: './controller/oral_awareness_images.php',
				 				type: 'POST',
				 				data: formData,
				 				success: function(response) {
				 					console.log(response);
				 					const $slider = $('#imageSlider');
				 					$slider.html(response);

				 					if ($slider.hasClass('slick-initialized')) {
				 						$slider.slick('unslick');
				 					}

				 					if ($slider.children().length > 0) {
				 						$slider.slick({
				 							slidesToShow: 2,
				 							slidesToScroll: 1,
				 							autoplay: true,
				 							autoplaySpeed: 2000,
				 							arrows: true,
				 							dots: false
				 						});
				 					}
				 				}
				 			});
				 		});

				 		$('#filterProcedureForm').on('submit', function(e) {
				 			e.preventDefault(); // Prevent form from reloading the page

				 			const formData = $(this).serialize(); // Serialize form values

				 			$.ajax({
				 				url: './controller/critical_procedures_images.php',
				 				type: 'POST',
				 				data: formData,
				 				success: function(response) {
				 					const $slider = $('#imageProcedureSlider');
				 					$slider.html(response);

				 					if ($slider.hasClass('slick-initialized')) {
				 						$slider.slick('unslick');
				 					}

				 					if ($slider.children().length > 0) {
				 						$slider.slick({
				 							slidesToShow: 2,
				 							slidesToScroll: 1,
				 							autoplay: true,
				 							autoplaySpeed: 2000,
				 							arrows: true,
				 							dots: false
				 						});
				 					}
				 				}
				 			});
				 		});
				 	});
				 </script>

				 <script>
				 	$(document).ready(function() {
				 		let maxCountProcedure = 3; // Maximum additional times the form can be added
				 		let count = 0;

				 		$(document).on('click', '.add-procedure-image-btn', function() {
				 			if (count < maxCountProcedure) {
				 				let newFields = $('.procedure-fields:first').clone();
				 				newFields.find('input').val(""); // Clear input fields
				 				newFields.append('<div class="col-md-2 col-xs-12 d-flex align-items-center" style="margin-top:10px"><button type="button" class="btn btn-danger remove-btn">-</button></div>');
				 				$('#procedure-container').append(newFields);
				 				count++;
				 			}
				 		});

				 		$(document).on('click', '.remove-btn', function() {
				 			$(this).closest('.procedure-fields').remove();
				 			count--;
				 		});

				 		$(document).on('change', '.file-input', function() {
				 			let file = this.files[0];
				 			let fileError = $(this).closest('.form-group').find('.file-error');

				 			if (file) {
				 				let fileType = file.type;
				 				let fileSize = file.size / 1024 / 1024; // Convert size to MB
				 				let allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

				 				if (!allowedTypes.includes(fileType)) {
				 					fileError.text("Invalid file type! Only JPG, JPEG, and PNG are allowed.");
				 					$(this).val(''); // Clear the input
				 				} else if (fileSize > 2) {
				 					fileError.text("File size exceeds 2MB.");
				 					$(this).val(''); // Clear the input
				 				} else {
				 					fileError.text(""); // No error
				 				}
				 			}
				 		});
				 	});



				 	// function loadImages(category = '') {
				 	//     $.ajax({
				 	//         url: './controller/oral_awareness_images.php',
				 	//         type: 'POST',
				 	//         data: { category: category },
				 	//         success: function (response) {

				 	//             const slider = $('#imageSlider');
				 	//             slider.html(response); // Update with new images
				 	//             if (slider.hasClass('slick-initialized')) {
				 	//                     slider.slick('unslick');
				 	//             }

				 	//             if (slider.children().length > 0) {
				 	//                 slider.slick({
				 	//                     // slick options here
				 	//                     slidesToShow: 2,
				 	//                     autoplay: true,
				 	//                     arrows: true,
				 	//                 });
				 	//             } else {
				 	//                 console.warn('No slides found for Slick.');
				 	//             }
				 	//             // Reinit slider
				 	//         }
				 	//     });
				 	// }

				 	// $('#categoryFilter').change(function () {
				 	//     const category = $(this).val();
				 	//     loadImages(category);
				 	// });

				 	// $(document).ready(function () {
				 	//     loadImages(); // Load all initially
				 	// });
				 </script>

				 <!-- script for dua se dawa tak filter -->
				 <script>
				 	$(function() {
				 		$("#filter_dua_form").on('submit', function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filter_dua_se_dawa.php',
				 				method: 'post',
				 				dataType: 'json',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					console.log("AJAX success", response);

				 					$('#referralTable_wrapper').hide();

				 					// Show the filtered table
				 					$('#filter-report-dua').removeClass('hidden').find('tbody').html();

				 					// Reinitialize DataTable for filtered table
				 					if ($.fn.DataTable.isDataTable('#filter-report-dua')) {
				 						$('#filter-report-dua').DataTable().clear().destroy();
				 					}


				 					if (Object.keys(response).length === 0) {
				 						$('#alert-data').removeClass('hidden').text('No Data Found !');
				 						$("#filter-report-dua").addClass('hidden');
				 						$("#referralTable").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 					} else {
				 						$('#alert-data').addClass('hidden');
				 						$("#referralTable").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 						$("#filter-report-dua").removeClass('hidden').parents('div.dataTables_wrapper').first().show();

				 						if ($.fn.DataTable.isDataTable('#filter-report-dua')) {
				 							$('#filter-report-dua').DataTable().destroy();
				 						}

				 						$('#filter-report-dua tbody').empty();



				 						Object.keys(response).forEach((key, i) => {
				 							let row = response[key];


				 							let actionLinks = `<a class="btn btn-primary" href="edit_dua_se_dawa_tak.php?id=${row.id}">Edit</a>`;


				 							$('#filter-report-dua tbody').append(`
                                                <tr>
                                                    <td><strong>${i+1}</strong></td>
                                                    <td><strong>${row.district_name}</strong></td>
                                                    <td><strong>${row.total_dawa_camps}</strong></td>
                                                    <td><strong>${row.persons_screened}</strong></td>
                                                    <td><strong>${row.patients_referred_district_hospital}</strong></td>
                                                    <td>${actionLinks}</td>
                                                </tr>
                                            `);
				 						});

				 						$('#filter-report-dua').DataTable();
				 					}
				 				},
				 				error: function(xhr, status, error) {
				 					console.error("AJAX Error:", status, error);
				 				}
				 			});
				 		});

				 		// Initialize referralTable only once
				 		$('#referralTable').DataTable({
				 			select: false,
				 			language: {
				 				emptyTable: "No data available"
				 			},
				 			columnDefs: [{
				 				className: "Name",
				 				visible: false,
				 				searchable: false
				 			}]
				 		});


				 		$('#downloadBtnDua').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_dua_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/download_dua_form.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					console.log("Download success", response);
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);
				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					// alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);
				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});


				 		//script for man kaksh filter
				 		$("#filter_kaksh_form").on('submit', function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filter_kaksh.php',
				 				method: 'post',
				 				dataType: 'json',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					console.log("AJAX success", response);

				 					$('#referralKakshTable_wrapper').hide();

				 					// Show the filtered table
				 					$('#filter-report-kaksh').removeClass('hidden').find('tbody').html();

				 					// Reinitialize DataTable for filtered table
				 					if ($.fn.DataTable.isDataTable('#filter-report-kaksh')) {
				 						$('#filter-report-kaksh').DataTable().clear().destroy();
				 					}


				 					if (Object.keys(response).length === 0) {
				 						$('#alert-data').removeClass('hidden').text('No Data Found !');
				 						$("#filter-report-kaksh").addClass('hidden');
				 						$("#referralTable").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 					} else {
				 						$('#alert-data').addClass('hidden');
				 						$("#referralKakshTable").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 						$("#filter-report-kaksh").removeClass('hidden').parents('div.dataTables_wrapper').first().show();

				 						if ($.fn.DataTable.isDataTable('#filter-report-kaksh')) {
				 							$('#filter-report-kaksh').DataTable().destroy();
				 						}

				 						$('#filter-report-kaksh tbody').empty();



				 						Object.keys(response).forEach((key, i) => {
				 							let row = response[key];


				 							let actionLinks = `<a class="btn btn-primary" href="edit_mankaksh.php?id=${row.id}">Edit</a>`;


				 							$('#filter-report-kaksh tbody').append(`
                                        <tr>
                                            <td><strong>${i+1}</strong></td>
                                            <td><strong>${row.district_name}</strong></td>
                                            <td><strong>${row.new_cases_man_kaksh}</strong></td>
                                            <td><strong>${row.followup_cases_man_kaksh}</strong></td>
                                            <td><strong>${row.total_cases}</strong></td>
                                            <td><strong>${row.common_mental_disorders}</strong></td>
                                            <td><strong>${row.severe_mental_disorders}</strong></td>
                                            <td><strong>${row.family_therapy}</strong></td>
                                            <td><strong>${row.crisis_help_cases}</strong></td>
                                            <td><strong>${row.suicide}</strong></td>
                                            <td><strong>${row.disaster}</strong></td>
                                            <td><strong>${row.any_other}</strong></td>
                                            <td><strong>${row.psychological_interventions}</strong></td>
                                            <td><strong>${row.disability_certifications}</strong></td>
                                            <td><strong>${row.IQ}</strong></td>
                                            <td><strong>${row.ASD}</strong></td>
                                            <td><strong>${row.LD}</strong></td>
                                            <td><strong>${row.addiction_cases}</strong></td>
                                            <td><strong>${row.tobacco}</strong></td>
                                            <td><strong>${row.alcohol}</strong></td>
                                            <td><strong>${row.opioids}</strong></td>
                                            <td><strong>${row.mobile_addiction}</strong></td>
                                            <td><strong>${row.addiction_any_other}</strong></td>
                                            <td><strong>${row.referrals_from_teaching_institutes}</strong></td>
                                            <td>${actionLinks}</td>
                                        </tr>


                          
                        `);
				 						});

				 						$('#filter-report-kaksh').DataTable();
				 					}
				 				},
				 				error: function(xhr, status, error) {
				 					console.error("AJAX Error:", status, error);
				 				}
				 			});
				 		});

				 		// Initialize referralTable only once
				 		$('#referralKakshTable').DataTable({
				 			select: false,
				 			language: {
				 				emptyTable: "No data available"
				 			},
				 			columnDefs: [{
				 				className: "Name",
				 				visible: false,
				 				searchable: false
				 			}]
				 		});


				 		//download kaksh data
				 		$('#downloadBtnKaksh').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_kaksh_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/download_kaksh_form.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					console.log("Download success", response);
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);
				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					// alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);
				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});


				 		//script for dmhp filter
				 		$("#filter_dmhp_form").on('submit', function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filter_dmhp.php',
				 				method: 'post',
				 				dataType: 'json',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					console.log("AJAX success", response);

				 					$('#referralDmhpTable_wrapper').hide();

				 					// Show the filtered table
				 					$('#filter-report-dmhp').removeClass('hidden').find('tbody').html();

				 					// Reinitialize DataTable for filtered table
				 					if ($.fn.DataTable.isDataTable('#filter-report-dmhp')) {
				 						$('#filter-report-dmhp').DataTable().clear().destroy();
				 					}


				 					if (Object.keys(response).length === 0) {
				 						$('#alert-data').removeClass('hidden').text('No Data Found !');
				 						$("#filter-report-dmhp").addClass('hidden');
				 						$("#referralDmhpTable").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 					} else {
				 						$('#alert-data').addClass('hidden');
				 						$("#referralDmhpTable").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 						$("#filter-report-dmhp").removeClass('hidden').parents('div.dataTables_wrapper').first().show();

				 						if ($.fn.DataTable.isDataTable('#filter-report-dmhp')) {
				 							$('#filter-report-dmhp').DataTable().destroy();
				 						}

				 						$('#filter-report-dmhp tbody').empty();

				 						Object.keys(response).forEach((key, i) => {
				 							let row = response[key];
				 							let actionLinks = `<a class="btn btn-primary" href="edit_dmhp_monthly_report.php?id=${row.id}">Edit</a>`;
				 							$('#filter-report-dmhp tbody').append(`
                                                <tr>
                                                    <td><strong>${i+1}</strong></td>
                                                    <td><strong>${row.district_name}</strong></td>
                                                    <td><strong>${row.nodal_officer_name}</strong></td>
                                                    <td><strong>${row.nodal_officer_mobile}</strong></td>
                                                    <td><strong>${row.nodal_officer_email}</strong></td>
                                                    <td><strong>${row.psychiatrist}</strong></td>
                                                    <td><strong>${row.trained_mo_psychiatrist}</strong></td>
                                                    <td><strong>${row.clinical_psychologist}</strong></td>
                                                    <td><strong>${row.trained_psychologist}</strong></td>
                                                    <td><strong>${row.psychiatric_social_worker}</strong></td>
                                                    <td><strong>${row.trained_social_worker}</strong></td>
                                                    <td><strong>${row.psychiatric_nurse}</strong></td>
                                                    <td>${actionLinks}</td>
                                                </tr>
                                            `);
				 						});

				 						$('#filter-report-dmhp').DataTable();
				 					}
				 				},
				 				error: function(xhr, status, error) {
				 					console.error("AJAX Error:", status, error);
				 				}
				 			});
				 		});

				 		// Initialize referralTable only once
				 		$('#referralDmhpTable').DataTable({
				 			select: false,
				 			language: {
				 				emptyTable: "No data available"
				 			},
				 			columnDefs: [{
				 				className: "Name",
				 				visible: false,
				 				searchable: false
				 			}]
				 		});



				 		$('#downloadBtnDmhp').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_dmhp_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/download_dmhp_form.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					console.log("Download success", response);
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);
				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					// alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);
				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});


				 		//script for man chetna diwas filter
				 		$("#filter_chetna_form").on('submit', function(e) {
				 			e.preventDefault();
				 			$.ajax({
				 				url: './controller/filter_man_chetna.php',
				 				method: 'post',
				 				dataType: 'json',
				 				data: $(this).serialize(),
				 				success: function(response) {
				 					console.log("AJAX success", response);

				 					$('#referralChetna_wrapper').hide();

				 					// Show the filtered table
				 					$('#filter-report-chetna').removeClass('hidden').find('tbody').html();

				 					// Reinitialize DataTable for filtered table
				 					if ($.fn.DataTable.isDataTable('#filter-report-chetna')) {
				 						$('#filter-report-chetna').DataTable().clear().destroy();
				 					}


				 					if (Object.keys(response).length === 0) {
				 						$('#alert-data').removeClass('hidden').text('No Data Found !');
				 						$("#filter-report-chetna").addClass('hidden');
				 						$("#referralChetna").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 					} else {
				 						$('#alert-data').addClass('hidden');
				 						$("#referralChetna").addClass('hidden').parents('div.dataTables_wrapper').first().hide();
				 						$("#filter-report-chetna").removeClass('hidden').parents('div.dataTables_wrapper').first().show();

				 						if ($.fn.DataTable.isDataTable('#filter-report-chetna')) {
				 							$('#filter-report-chetna').DataTable().destroy();
				 						}

				 						$('#filter-report-chetna tbody').empty();



				 						Object.keys(response).forEach((key, i) => {
				 							let row = response[key];


				 							let actionLinks = `<a class="btn btn-primary" href="edit_man_chetna_diwas.php?id=${row.id}">Edit</a>`;

				 							$('#filter-report-chetna tbody').append(`
                                                <tr>
                                                    <td><strong>${i+1}</strong></td>
                                                    <td><strong>${row.district_name}</strong></td>
                                                    <td><strong>${row.chc_phc_name}</strong></td>
                                                    <td><strong>${row.new_opd_patients}</strong></td>
                                                    <td><strong>${row.follow_up_cases_opd}</strong></td>
                                                    <td><strong>${row.patients_counselled}</strong></td>
                                                    <td><strong>${row.referred_to_dh}</strong></td>
                                                    <td><strong>${row.referred_back_from_dh}</strong></td>
                                                    <td>${actionLinks}</td>
                                                </tr>
                                            `);
				 						});

				 						$('#filter-report-chetna').DataTable();
				 					}
				 				},
				 				error: function(xhr, status, error) {
				 					console.error("AJAX Error:", status, error);
				 				}
				 			});
				 		});

				 		// Initialize referralChetna only once
				 		$('#referralChetna').DataTable({
				 			select: false,
				 			language: {
				 				emptyTable: "No data available"
				 			},
				 			columnDefs: [{
				 				className: "Name",
				 				visible: false,
				 				searchable: false
				 			}]
				 		});


				 		$('#downloadBtnChetna').click(function() {
				 			// Serialize form data

				 			var formData = $('#filter_chetna_form').serialize();

				 			// Send AJAX request
				 			$.ajax({
				 				type: 'POST',
				 				url: './controller/download_man_chetna_diwas_report.php', // The URL of the PHP page
				 				data: formData,
				 				xhrFields: {
				 					responseType: 'text' // Important
				 				},
				 				success: function(response, status, xhr) {
				 					console.log("Download success", response);
				 					// Handle the response from the PHP page
				 					// $('#response').html(response);
				 					var disposition = xhr.getResponseHeader('Content-Disposition');
				 					var filename = "output.csv"; // Default filename
				 					if (disposition && disposition.indexOf('attachment') !== -1) {
				 						var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(disposition);
				 						if (matches != null && matches[1]) {
				 							filename = matches[1].replace(/['"]/g, '');
				 						}
				 					}
				 					// alert(filename);
				 					var blob = new Blob([response], {
				 						type: 'text/csv'
				 					});
				 					var downloadUrl = URL.createObjectURL(blob);
				 					// Create a link element, use it to download the blob, then remove it
				 					var a = document.createElement("a");
				 					a.href = downloadUrl;
				 					a.download = filename;
				 					document.body.appendChild(a);
				 					a.click();
				 					document.body.removeChild(a);
				 					URL.revokeObjectURL(downloadUrl)
				 				},
				 				error: function(xhr, status, error) {
				 					// Handle any errors
				 					$('#response').html('An error occurred: ' + error);
				 				}
				 			});
				 		});

				 	});
				 </script>


				 <?php unset($_SESSION['alert-msg']);
					unset($_SESSION['alert-type']);
					unset($_SESSION['alert_msg'])
					?>
				 </body>
				 <!-- InstanceEnd -->

				 </html>