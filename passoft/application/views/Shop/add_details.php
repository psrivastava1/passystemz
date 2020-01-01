<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Add Image</span></h4>
					<div class="panel-tools">
						<div class="dropdown">
							<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
								<i class="fa fa-cog"></i>
							</a>
							<ul class="dropdown-menu dropdown-light pull-right" role="menu">
								<li>
									<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
								</li>
								<li>
									<a class="panel-refresh" href="#">
										<i class="fa fa-refresh"></i> <span>Refresh</span>
									</a>
								</li>
								<li>
									<a class="panel-config" href="#panel-config" data-toggle="modal">
										<i class="fa fa-wrench"></i> <span>Configurations</span>
									</a>
								</li>
								<li>
									<a class="panel-expand" href="#">
										<i class="fa fa-expand"></i> <span>Fullscreen</span>
									</a>
								</li>
							</ul>
						</div>
						<a class="btn btn-xs btn-link panel-close" href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="panel-body">
				    <div class="row">
						<div class="col-md-12 form-group" >
                            <form method="post" id="upload_form" action="" enctype="multipart/form-data">
                                <div class="col-md-4">
                                    <input style="width:300px;" placeholder="Enter Image Type Name" class="form-control" type="text" id="qr_type" name="qr_type"/>
                                </div>
                                <div class="col-md-4">
                                    <input type="file" name="img_1" id="img_1" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <input type="submit" value="Submit" id= "submit" name="submit" class="btn btn-info" style="margin-left:10px;"/></center>
                                </div>
                            </form>
                        </div>
						<script>
							
                            $('#upload_form').on('submit',(function(e){
                                e.preventDefault();
                                $.ajax({ 	
										url: "<?php echo site_url();?>shopController/save_qr_details",
                                    type:"POST",
                                    data: new FormData(this),
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function(data){ 
                                        alert(data);
                                        location.reload();
                                    },
                                    error: function(){
										alert(data);
									}
                                });
                            }));
							
						</script>
					</div>
					<div class="table-responsive">
						<div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
								<thead>
									<tr style="background-color:#1ba593; color:white;">
                                        <th style=" text-align:center" width="10px">SNO</th>
                                        <th style=" text-align:center" width="10px">Payment_Type</th>
                                        <th style=" text-align:center" width="10px">Image</th>
										<th style=" text-align:center" width="10px">Action</th>
									</tr>									
								</thead>
                                <tbody>
                                    <?php
                                    $this->db->where('username',$this->session->userdata('username'));
                                    $e=$this->db->get('bank_qr_details');
                                     $i=1;
                                     foreach($e->result() as $e_data) {
                                      ?>  
                                        <tr class="text-uppercase text-center">
											<input type="hidden" name="row_id<?= $i;?>" id="row_id<?= $i;?>" value="<?= $e_data->id; ?>"/>
                                            <td width="10px"><?php echo $i; ?></td>
                                            <td width="10px"><?php echo $e_data->type; ?></td>
                                            <td width="10px"><img src="https://localhost/passystem/a_pass/images/Qr_code/<?php echo $e_data->image; ?>" style="width:80px;height:80px;"></td>	
											<td width="10px"><input type="button" name="dlt_btn<?= $i;?>" id="dlt_btn<?= $i;?>" class="btn btn-warning" value="Delete"/></td>											
                                        </tr>
										<script>
											$("#dlt_btn<?= $i;?>").click(function(){
												var r_id = $("#row_id<?= $i;?>").val();
												// alert(r_id);
												$.post("<?php echo site_url();?>shopController/dlt_img",{r_id:r_id},function(data){
													if(data==1)
													{
														alert("Succeessfully Deleted");
														location.reload();
													}
													else if(data==0)
													{
														alert("Data Not Deleted");
													}
												});
											});
										</script>
									<?php 
											$i++; } ?>
												
                                </tbody> 
							</table>
						</div>
					</div>
					
				</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
</div>