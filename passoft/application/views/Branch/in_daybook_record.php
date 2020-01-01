<div class="row">
						<div class="col-md-12 space20">
						    
							<div class="btn-group pull-right">
								<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
									Export <i class="fa fa-angle-down"></i>
								</button>
								
								<ul class="dropdown-menu dropdown-light pull-right">

									<li>
										<a href="#" class="export-excel" data-table="#sample-table-2" >
											Export to Excel
										</a>
									</li>
					            </ul>
								
							</div>
						</div>
					</div>
				
					<div class="table-responsive">
						<div class="table-responsive">
							<table class="table table-striped table-hover" id="sample-table-2">
								<thead>
									<tr style="background-color:#1ba593; color:white;">
                                        <th style=" text-align:center" width="10px">SNO</th>
                                        <th style=" text-align:center" width="10px">Order No</th>
                                        <th style=" text-align:center" width="10px">Amount</th>
                                        <th style=" text-align:center" width="10px">Trnf Qty</th>
                                        <th style=" text-align:center" width="10px">Date</th>
                                        <th style=" text-align:center" width="10px">From</th>
                                        <!-- <th width="10px">Current Balance</th> -->
                                        <!-- <th width="10px">Payment Mode</th> -->
                                        <!-- <th width="10px">Paid Amount</th> -->
                                        <!-- <th width="10px">Transaction ID</th> -->
                                        <!-- <th width="10px">Net Balance Amount</th> -->
                                        <!-- <th width="10px">Status</th> -->
									</tr>									
								</thead>
                                <tbody>
                                    <?php
                                    
                                    $username= $this->session->userdata('username');
                                    $this->session->userdata("username");
                                    $this->db->group_by('invoice_number');
                                    $this->db->where('reciver_usernm',$username);
                                    $this->db->where('sender_usernm',$sender_uname);
                                    $e=$this->db->get('product_trans_detail');
                                     $i=1; $p_tt=0;
                                     foreach($e->result() as $e_data) {
                                         $this->db->where('invoice_no',$e_data->invoice_number);
                                         $this->db->where('receiver_status',1);
                                         $chk = $this->db->get('transfer_product_paydetail');
                                     if($chk->num_rows()>0)
                                      {
                                      
                                      }
                                      
                                      else
                                      {
                                      ?>
							                
												<tr class="text-uppercase text-center">
												    <td width="10px"><?php echo $i; ?></td>
													<td width="10px"><a class="btn btn-primary" href="<?php echo base_url();?>stockController/productinvoice_chk/<?php echo $e_data->invoice_number; ?>/<?= $sender_uname;?>"><?php echo $e_data->invoice_number; ?></a></td>
													<?php $tt=0; 
													    $this->db->where('id',$e_data->p_code);
    												    $pro= $this->db->get('stock_products');
    												    if($pro->num_rows()>0)
    												    {
    												        $t = $pro->row()->selling_price * $e_data->quantity;
    												        $tt= $tt + $t;
                                                        } 
                                                        $p_tt = $p_tt + $tt;
    												    ?>
													 <td width="10px"><input style="width:70px;" type="text" value="<?php echo $tt;?>" name="ordamt<?php echo $i;?>" id= "ordamt<?php echo $i;?>" readonly/></td>
														<?php $this->db->where('invoice_number',$e_data->invoice_number);
													$this->db->select_sum('quantity');
													$qty= $this->db->get('product_trans_detail')->row();
													?>
													<td width="10px"><?php echo $qty->quantity; ?></td>
													<td width="10px"><?php echo $e_data->date; ?></td>
													<td width="10px"><?php echo $e_data->sender_usernm;?></td>										
												</tr>
											<?php }
											$i++; } ?>
												
                                </tbody> 
							</table>
						</div>
						<a style=" margin:10px;" class="btn btn-warning" href="<?php //echo base_url();?>login/index">Back To Dashboard</a>
					</div>
                    <div class="row">
                        <label style="margin-left:30px;">Debit :- </label><input type="text" value="<?= $p_tt; ?>" name="t1"/> <label style="margin-left:30px;">Credit :- </label><input type="text" name="t2"/>
                    </div>