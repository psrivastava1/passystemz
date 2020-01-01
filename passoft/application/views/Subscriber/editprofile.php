<?php //print_r($sub_data);
// exit;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-heading panel-blue border-light">
				<h4 class="panel-title">Subscriber Full Profile</h4>
			</div>
			<div class="panel-body">
			
			 <!--   <div class="col-md-12">-->
			 <!--       <div class="alert alert-info">-->
		  <!--              <button data-dismiss="alert" class="close"></button>-->
		  <!--              <h3 class="media-heading text-center" style="text-align:center">Welcome to Profile View Area</h3>-->
		  <!--              <p style="text-align:center;margin-top:20px;margin-bottom:20px;"></p>-->
    <!--    		    </div>-->

				<!--	<div class="errorHandler alert alert-danger no-display">-->
				<!--		<i class="fa fa-times-sign"></i> You have some form errors. Please check below.-->
				<!--	</div>-->
					
				<!--</div>-->
                <?php if($sub_data->num_rows()>0){
                    $data=$sub_data->row();
                
                ?>
	        	<form action="<?php echo base_url();?>index.php/subscriberController/update_profile"  method ="post" role="form" id="form">
                <div class="row"> 
                
                    <div class="col-md-12 space20">
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="name" value="<?php echo $data->name;?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Father Name 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="father_name" value="<?php echo $data->father_name;?>">
                            
                            </div>
                        </div> 
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Mobile Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="mobile" value="<?php echo $data->mobile;?>">
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Email Id
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="email" value="<?php echo $data->email;?>">
                            
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Address 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="address" value="<?php echo $data->address;?>"/>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Pin Code 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="pin" value="<?php echo $data->pin;?>"/>
                            
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               District 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="district" value="<?php echo $data->district;?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    State 
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="state" value="<?php echo $data->state;?>"/>
                            
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               Aadhar Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="adhar" value="<?php echo $data->adhar;?>"/>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    Pan Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="pan" value="<?php echo $data->pan;?>"/>
                            
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               Gender
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="gender" value="<?php if($data->gender==1){ echo "Male"; } elseif($data->gender==2){ echo "Female";} else {echo "Third Gender";}?>"/>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Registration Fee
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="amount" value="<?php echo $data->amount;?>"/>
                                
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               1 Nominee Name
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="nom1" value="<?php echo $data->nom1;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                1 Nominee Aadhar No.
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_ad1" value=" <?php echo $data->nom_ad1;?>"/>
                               
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               1 Nominee Relation
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_rel1" value="<?php echo $data->nom_rel1;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                    2 Nominee Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom2" value="<?php echo $data->nom2;?>"/>
                                
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               2 Nominee Aadhar No.
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_ad2" value="<?php echo $data->nom_ad2;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                2 Nominee Relation
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="nom_rel2" value="<?php echo $data->nom_rel2;?>"/>
                                
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                               UserName
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="username" value="<?php echo $data->username;?>" readonly/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Password
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="password" value="<?php echo $data->password;?>"/>
                                
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                 Branch Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="branch_name" value="<?php echo $data->branch_name;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                Joiner Id
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="parentID" value=" <?php if($data->parentID==0){ echo "NO JOINER"; } else { echo $data->parentID; }?>"/>
                           
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                            Image
                            </div>
                            <div class="col-md-6">
                            <?php if(strlen($data->image)>0){?> <img class="zoom1" width=50px; height=50px; src="<?php echo $this->config->item('asset_url');?>/images/subscriber/<?php echo $data->image;?>"> <?php } else { ?><img class="zoom1" width=50px; height=50px; src="<?php echo $this->config->item('asset_url');?>/images/userlogo.png"> <?php } ?>
                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                            Bank Name
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="bank_name" value="<?php echo $data->bank_name;?>"/>
                                
                            </div>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <div class="col-md-6">
                            Account Number
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="account_no" value="<?php echo $data->account_no;?>"/>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                IFSC Code
                            </div>
                            <div class="col-md-6">
                            <input type="text" name="ifsc" value="<?php echo $data->ifsc;?>"/>
                            
                            </div>
                        </div>

                <?php } ?>
                    </div>	 
                </div>
                <div><center><input class="btn btn-primary" type="submit" name="update" value="Submit"/></center></div>
            </div>
        </div>
    </div>
</div>