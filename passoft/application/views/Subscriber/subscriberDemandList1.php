
       	<div class="row">
						<div class="col-md-12 space20">
							<div class="btn-group pull-right">
								<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
									Export <i class="fa fa-angle-down"></i>
								</button>
								
								<ul class="dropdown-menu dropdown-light pull-right">
									<!--<li>-->
									<!--	<a href="#" class="export-pdf" data-table="#sample-table-2" >-->
									<!--		Save as PDF-->
									<!--	</a>-->
									<!--</li>-->
									<!--<li>-->
									<!--	<a href="#" class="export-png" data-table="#sample-table-2">-->
									<!--		Save as PNG-->
									<!--	</a>-->
									<!--</li>-->
									<!--<li>-->
									<!--	<a href="#" class="export-csv" data-table="#sample-table-2" >-->
									<!--		Save as CSV-->
									<!--	</a>-->
									<!--</li>-->
									<!--<li>-->
									<!--	<a href="#" class="export-txt" data-table="#sample-table-2" >-->
									<!--		Save as TXT-->
									<!--	</a>-->
									<!--</li>-->
									<!--<li>-->
									<!--	<a href="#" class="export-xml" data-table="#sample-table-2" >-->
									<!--		Save as XML-->
									<!--	</a>-->
									<!--</li>-->
									<!--<li>-->
									<!--	<a href="#" class="export-sql" data-table="#sample-table-2" >-->
									<!--	Save as SQL-->
									<!--	</a>-->
									
									
									<!--	<a href="#" class="export-json" data-table="#sample-table-2" >-->
									<!--		Save as JSON-->
									<!--	</a>-->
									<li>
										<a href="#" class="export-excel" data-table="#sample-table-2" >
											Export to Excel
										</a>
									</li>
									<!--<li>-->
									<!--	<a href="#" class="export-doc" data-table="#sample-table-2" >-->
									<!--	Export to Word-->
									<!--</a>-->
									<!--</li>-->
									<!--<li>-->
									<!--	<a href="#" class="export-powerpoint" data-table="#sample-table-2">-->
									<!--		Export to PowerPoint-->
									<!--	</a>-->
									<!--</li>-->
								</ul>
							</div>
						</div>
					</div>
        <table id="sample-table-2" class="table table-bordered nowrap">
             <thead>
                <tr  style="background-color:#1ba593; color:white;">
                  <th >S.N</th>
                   <th >Name of Sub</th>
                   <th>Company</th>
                  <th> Name</th>
                  <th > Code</th>
                  <th>Type</th>
                  <th >Volume</th>
                   <th >Req</th>
                  <th >No.Sub</th>
                  <th >Image</th>
              </thead>
              <tbody>
             
               <?php 
               
                 $stckdt= $this->db->get("stock_products");
                 if($stckdt->num_rows()>0){
                 $i=1;
                 foreach($stckdt->result() as $data):
                    //  print_r($data);
                     
                 
                 $this->db->where("product_code",$data->id);
                 $dt= $this->db->get("favourite_list");
                 $total1=$dt->num_rows();
                 $total=$total1+6;
                 
                 if($dt->num_rows()>0){
                  $val=$dt->row();
                      
                  $this->db->where("id",$val->product_code);
                  $stckdt1= $this->db->get("stock_products");
                 
                  if($stckdt1->num_rows()>0){
                    $totalquantity= $stckdt1->row()->quantity;
                    
                 
                        
                    if($totalquantity<$total){
                            $remainingquantity=$totalquantity- $total;
                        $stckdt2=$stckdt1->row();
                       
                        
                  ?>
                  <tr class="text-uppercase text-center">
                    <td ><?php echo $i;?></td>
                    <td >
                       <?php $j=1; foreach($dt->result() as $cusname): 
                           $this->db->where('id',$cusname->customer_id);
                           $this->db->where('sub_branchid',$view);
                          $row2=$this->db->get('customers');
                          if($row2->num_rows()>0)
                          {
                               echo $j."- " .  $row2->row()->name. " [ " . $row2->row()->username . " ]<br> ";
                          }
                          else
                          {
                              echo "N/A";
                          }
                      
                       $j++; endforeach;
                       ?>
                  </td>
                     <td >
                         <a href="<?php echo base_url();?>subscriberController/nameofperson/<?php echo $val->product_code;?>">
                             <span style="color:#01a9ac;"><?php echo $stckdt2->company;?></span></a>
                    </td>
                  <td ><?php if($totalquantity<=$total){?>
                    <span style="color:red;">
                        <?php echo $stckdt2->name;?>
                    </span>
                 
                  <?php } else{
                  echo $stckdt2->name;
                  }?>
                 </td>
                  <td ><?php echo $stckdt2->hsn;?></td>
                   <td ><?php echo $stckdt2->p_type;?></td>
                    <td ><?php echo $stckdt2->size;?></td>
                     <td >
                         <span style="color:red;font-size:20px;font-weight:1px;"><?php echo $remainingquantity;?></span>
                  </td>
                   
                  <td >
                      <a href="<?php echo base_url();?>customer/nameofperson/<?php echo $val->product_code;?>"><span style="color:#01a9ac;">
                          <?php echo $total1; ?>
                          </span></a>
                   </td>
                   <td ><?php if($stckdt2->file1>0){ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file1; ?>"
                                    style="height:50px;width:100px;"><?php } else{ ?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stckdt2->file2; ?>"
                                                style="height:50px;width:100px;"><?php }?></td>
                    <?php  $i++; } }; ?>
                    </tr>
                   <?php  }  endforeach; } ?>
                
              </tbody>
            </table>
       
           <!-- <?php// $this->load->view("footerJs/daybookJs"); ?> -->
           <script src="<?php echo base_url(); ?>assets/js/table-export.js"></script>
           <script>
           	TableExport.init();
           </script>