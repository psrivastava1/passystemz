<?php if($this->session->userdata("login_type")==1) { ?>
      	            <div>
      	                <strong><center> <h2 style='color: green'> OUT Daybook Record From Admin To Branch & Shop </h2></center></strong>
                    </div>
<?php } elseif($this->session->userdata("login_type")==2) { ?>
      	            <div>
      	                <strong><center> <h2 style='color: green'> OUT Daybook Record From Branch To Admin & Shop </h2></center></strong>
                    </div>
<?php } elseif($this->session->userdata("login_type")==4) { ?>
      	            <div>
      	                <strong><center> <h2 style='color: green'> OUT Daybook Record From Shop To Admin & Branch </h2></center></strong>
                    </div>
<?php }?>
				
				
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Product Record History</span></h4>
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
						<div class="col-md-12" >
						<?php if($this->session->userdata("login_type")==1) { ?>
							<center><label>Select Sender:</label>
							<select name="sel_ct" id="sel_ct">
							<option disabled selected><--SELECT--></option>
							<?php 
							$b = $this->db->get('branch'); 
							foreach($b->result() as $b_data){ ?>
							<option value="<?= $b_data->username; ?>"><?= "[BRANCH] ".$b_data->b_name." [".$b_data->username." ]"?></option>
							<?php } ?>
							<?php 
							$sb = $this->db->get('sub_branch'); 
							foreach($sb->result() as $sb_data){ ?>
							<option value="<?= $sb_data->username; ?>"><?= "[SHOP] ".$sb_data->bname." [".$sb_data->username." ]"?></option>
							<?php } ?>
							</select>
						<?php } elseif($this->session->userdata("login_type")==2) { ?>
							<center><label>Select Sender:</label>
							<select name="sel_ct" id="sel_ct">
							<option disabled selected><--SELECT--></option>
							<option value="admin">Admin</option>
							<?php $this->db->where('district',$this->session->userdata('id'));
							$sb = $this->db->get('sub_branch'); 
							foreach($sb->result() as $sb_data){ ?>
							<option value="<?= $sb_data->username; ?>"><?= $sb_data->bname." [".$sb_data->username." ]"?></option>
							<?php } ?>
							</select>
						<?php } elseif($this->session->userdata("login_type")==4) { ?>
							<center><label>Select Sender:</label>
							<select name="sel_ct" id="sel_ct">
							<option disabled selected><--SELECT--></option>
							<option value="admin">Admin</option>
							<?php $this->db->where('id',$this->session->userdata('district'));
							$sb = $this->db->get('branch'); 
							foreach($sb->result() as $sb_data){ ?>
							<option value="<?= $sb_data->username; ?>"><?= $sb_data->b_name." [".$sb_data->username." ]"?></option>
							<?php } ?>
							</select>
						<?php }?>
							
							<input type="submit" value="Submit" id= "sub_1" name="sub_1" class="btn btn-info" style="margin-left:10px;"/></center>
						</div>
						<script>
							$("#sub_1").click(function(){
								var uname = $("#sel_ct").val();
								// alert(uname);
								<?php if($this->session->userdata("login_type")==1) { ?>
								$.post("<?= site_url();?>adminController/outdaybook_record",{uname:uname},function(data){
									$("#show_1").html(data);
								});
							<?php } elseif($this->session->userdata("login_type")==2) { ?>
								$.post("<?= site_url();?>branchController/outdaybook_record",{uname:uname},function(data){
									$("#show_1").html(data);
								});
							<?php } elseif($this->session->userdata("login_type")==4) { ?>
								$.post("<?= site_url();?>shopController/outdaybook_record",{uname:uname},function(data){
									$("#show_1").html(data);
								});
							<?php } ?>
							});
						</script>
					</div>
					<div id="show_1">
					
					</div>
					
				</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
</div>