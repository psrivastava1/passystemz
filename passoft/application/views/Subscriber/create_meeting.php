
<div class="container">
	<div class="row">
		<div class="col-md-12">
		    <?php if($this->uri->segment(3)==5) { ?>
		    <div style="color:green">
		        <h4>Successfully!!</h4>
		    </div>
		    <?php } ?>
			<!-- start: EXPORT DATA TABLE PANEL  -->
			<div class="panel panel-white">
			<div class="panel-heading panel-red">
					<h4 class="panel-title"> <span class="text-bold">Assign Meeting To AO</span></h4>
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
             <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                          <h3 class="text-center" style=" color: rgb(242, 0, 137); margin-top:5%;">Meeting Details</h3>
                            <div class="theme-card" style="margin-top:40px;">
                              <form method="post" action="<?php echo base_url();?>index.php/adminController/assign_meeting">
                               <div class="row">
                                 <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="name">Sponsor Id</label> 
                                        <input type="text" name="sub_id"  class="form-control" style="text-transform:uppercase"/>
                                          <span class="form-bar" id="valid"></span>
                                    </div>
                       <!--           <div class="form-group">-->
                       <!--                 <label for="name">Place Of Meeting<span style="color:red"> * </span></label> -->
                       <!--                 <input type="text" name="vname" id="vname"   onkeypress="return isalphabate(event)" class="form-control" style="text-transform:uppercase"-->
            			        <!--onkeyup="vName()" required="" >-->
                       <!--                   <span class="form-bar" id="valid"></span>-->
                       <!--             </div>-->
                                    <div class="form-group">
                                        <label for="name">Meeting Date<span style="color:red"> * </span></label> 
                                        <input type="date" name="date"  class="form-control" style="text-transform:uppercase"
            			         required="" >
                                          <span class="form-bar" id="valid"></span>
                                    </div>
                                     <div class="form-group">
                                        <label for="name">Assign AO<span style="color:red"> * </span></label> 
                                        <select name="select_ao">
                                            <option>select</option>
                                            <?php $this->db->where('emp_type','7');
                                            $edata = $this->db->get('employee');
                                            if($edata->num_rows()>0) { 
                                                foreach($edata->result() as $emp) { ?>
                                                    <option value="<?php echo $emp->username;?>"><?php echo $emp->name." [".$emp->username."]";?></option>            
                                            <?php
                                                }
                                            } ?>
                                            
                                        </select>
                                          <span class="form-bar" id="valid"></span>
                                    </div>
                                    
                                    
                                   
                                 </div>
                                 <div class="col-md-6">
                                 <!--<div class="form-group">-->
                                 <!--       <label for="name"> Contact Number <span style="color:red"> * </span></label> -->
                                 <!--       <input type="text" pattern="^[6-9]\d{9}$"  id="contactno" name="contactno" onkeypress="return isNumber(event)" minlength="10" maxlength="10" name="mob_no" class="form-control" required>-->
                                 <!--        <span class="form-bar" id="messageno"></span>-->
                                 <!--   </div>-->
                                    <div class="form-group">
                                        <label for="name">Meeting Timing <span style="color:red"> * </span></label> 
                                        <input type="time" name="time"  class="form-control" style="text-transform:uppercase"
            			         required="" >
                                          <span class="form-bar" id="valid"></span>
                                    </div>
                                   
                                     <div class="form-group">
                                        <label for="name">Place<span style="color:red"> * </span></label> 
                                        <textarea class="form-control" name="address"  onkeypress="return isalphabate(event)" required="" ></textarea>
                                          <span class="form-bar" id="valid"></span>
                                    </div>
                                    
                                 </div>
                              
                                 </div>
                                 <div class="container">
                                 <div class="row">
                                  <div class="col-md-12">
                                    <center> <p>  <button class="btn btn-solid btn-success" id="subbutton" type ="submit">Submit</button> </p></center> 
                                  </div>
                                 </div>
                              
                                 </div>
                            
                               </div>
                              </form>
                            </div>
                           
                        </div>
                    </div>
                </div>


				
				</div>
			</div>
			<!-- end: EXPORT DATA TABLE PANEL -->
		</div>
	</div>
	<!-- end: PAGE CONTENT-->
</div>