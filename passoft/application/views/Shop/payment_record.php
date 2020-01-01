<?php $this->db->where('username',$username);
$bq = $this->db->get('bank_qr_details')->result();
foreach($bq as $bq_dta)
{ ?>
    <div class="col-md-2">
        <img src="http://localhost/passystem/a_pass/images/Qr_code/<?php echo $bq_dta->image;?>" style="width:180px; heigth:150px; padding-left:25px;"/>
        <center><a href="<?php echo base_url();?>shopController/pay_to/<?= $bq_dta->id;?>"><h4><?php echo $bq_dta->type; ?></h4></a></center>
    </div> 
<?php } ?>
                        <div class="col-md-12 form-group" style="margin-top:3%; margin-bottom:3%;">
                            <div class="col-md-2"><label style="float:right;">Pay Amount : </label></div>
                            <div class="col-md-2"><input class="form-control" type="text" name="pay_amt" id="pay_amt" placeholder="Enter Paid Amount"  style="float:left;"/></div>
                            <div class="col-md-3"><select id="pay_type" class="form-control">
                                <option selected disabled>Payment Mode</option>
                                <?php foreach($bq as $bq_dta2)
                                    { ?>
                                    <option><?= $bq_dta2->type;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3"><input type="date" id="pay_date" class="form-control"/></div>
                            <div class="col-md-2"><input type="button" id="pay_btn" value="Pay" class="btn btn-success" style="float:left;"/></div>
                        </div>
                        <script>
                            $("#pay_btn").click(function(){
                                // alert("sd");
                                var amt =  $("#pay_amt").val();
                                var pay_type =  $("#pay_type").val();
                                var pay_date =  $("#pay_date").val();
                                var pay_to =  $("#sel_ct").val();
                                // alert(pay_to);
                                $.post("<?php echo site_url();?>shopController/pay_amt_to",{amt:amt,pay_type:pay_type,pay_date:pay_date,pay_to:pay_to},function(data){
                                    if(data==1)
                                    {
                                        alert("Payment Record Submitted.");
                                        $("#dv_pay_tb").load(location.href +"#dv_pay_tb","");
                                    }
                                    else if(data==0)
                                    {
                                        alert("Record Not Submitted");
                                    }

                                });

                            });
                        </script>
                        <div>
                        
						<div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
								<thead>
									<tr style="background-color:#1ba593; color:white;">
                                        <th style=" text-align:center" width="10px">SNO</th>
                                        <th style=" text-align:center" width="10px">Pay To</th>
                                        <th style=" text-align:center" width="10px">Paid By</th>
                                        <th style=" text-align:center" width="10px">Amount</th>
                                        <th style=" text-align:center" width="10px">Date</th>
                                        <th style=" text-align:center" width="10px">Sender Status</th>
                                        <th style=" text-align:center" width="10px">Reciever Status</th>
									</tr>									
								</thead>
                                <tbody id="dv_pay_tb">
                                    <?php  $i=1; $this->db->where('pay_to',$username);
                                            $this->db->where('paid_by',$this->session->userdata('username'));
                                            $pd = $this->db->get('payment_details');
                                            $tt_paid = 0; 
                                            if($pd->num_rows()>0)
                                            {
                                               
                                                foreach($pd->result() as $pdata)
                                                { ?>
                                        <tr class="text-uppercase text-center">
                                            <td width="10px"><?php echo $i; ?></td>
                                            <td width="10px"><?php echo $pdata->pay_to; ?></td>
                                            <td width="10px"><?php echo $pdata->paid_by; ?></td>
                                            <td width="10px"><?php $tt_paid = $tt_paid + $pdata->amount; echo $pdata->amount; ?></td>
                                            <td width="10px"><?php echo $pdata->date; ?></td>
                                            <td width="10px"><?php echo $pdata->sender_status; ?></td>
                                            <td width="10px"><?php echo $pdata->reciever_status; ?></td>                                           												
                                        </tr>
                                        
									<?php 
                                            $i++; } 
                                        } ?>
												
                                </tbody> 
							</table>
						</div>
                        <div class="col-md-12 form-group" style="margin-top:3%; margin-bottom:3%;">
                            <div class="col-md-3"><label style="float:right;">In Balance :</label></div>
                            <div class="col-md-3">
                                    
                                <input class="form-control" type="text" vlaue=""/>
                            </div>
                            <div class="col-md-3"><label style="float:right;">Out Balance :</label></div>
                            
                            <div class="col-md-3">
                                <input class="form-control" type="text" value="<?php echo $tt_paid;?>"/>
                            </div>
                        </div>
					</div>
