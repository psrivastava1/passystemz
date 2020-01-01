               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 
                   <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                                <div class="panel-heading panel-red" style="text-align:center;color:#01a9ac;">
                                                  
                                                </div>
                                                
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            
                                                        </div>
                                                         <div class="col-md-3">
                                                            <label >Total</label>
                                                            <input id="total" name="tt" value = "0" class="form-control" style="width:180px;" type="text" required />
                                                        </div>
                                                         <div class="col-md-3">
                                                            <label>Paid</label>
                                                          <input id="paid" class="form-control" name="paid" style="width:180px;" type="text" required />
                                                        </div>
                                                        <div class="col-md-4">
                                                             <input type="submit" value="submit"  >
                                                             </div>
                                                    </div>
                                                    
                                                     <div class="dt-responsive table-responsive" >
        			<table class="table table-hover">
						<thead>
	                        <tr class="text-uppercase">
	                           <th>SNO</th>
	                            <th class="text-center"><label>P Code</label></th>
	                           <th><label> Name</label></th>
	                           <th><label> Category</label></th>
	                           <th><label>Weight</label></th>
	                           <th><label>Price</label></th>
	                           <th><label> Qty</label></th>
                               <th><label>Pur. Qty</label></th>
	                           
	                           <!-- <th><label>Total Price</label></th> -->
	                           <th><label>Sub Total</label></th>
	                        </tr>
	                    </thead>
	                    <tbody>
                        <?php $i = 1; while($i <= $number){ ?>
                            
                        <tr >
                            <td width="40"   >
                                <strong><?php echo $i; ?></strong>
                             </td>
                             <td>
                               
                                    <input id="item_no<?php echo $i; ?>" name="item_no<?php echo $i; ?>" valur=" " style="width:90px;">
                          

                            </td>

                           
                           
                            <td>
                                  <input id="item_name<?php echo $i; ?>" name="item_name<?php echo $i; ?>" style="width:150px;">
                            </td>
                            <td>
                                  <input readonly id="item_cat<?php echo $i; ?>" class="text-uppercase" name="item_cat<?php echo $i; ?>" style="width:110px;">
                            </td>
                            
                            <td>
                                  <input readonly id="item_size<?php echo $i; ?>" class="text-uppercase" name="item_size<?php echo $i; ?>" style="width:70px;">
                            </td>
                            <td>
                                   <input readonly id="item_price<?php echo $i; ?>" value="" class="text-uppercase" name="item_price<?php echo $i; ?>" style="width:70px;">
                            </td>
                            <td>
                             <input readonly id="item_quantity1<?php echo $i; ?>" class="text-uppercase" name="item_quantity1<?php echo $i; ?>" style="width:70px;" type="text"/>
                             </td>
                            <td>
                            	<button id="add<?= $i;?>">+</button>
                                <input readonly id="item_quantity<?php echo $i; ?>" class="text-uppercase" value="0" name="item_quantity<?php echo $i; ?>" style="width:70px;" type="text"/>
                           	<button id="sub<?= $i;?>">-</button>
                            </td>
                           
                                     
                            <td>
                                <input  readonly id="sub_total<?php echo $i; ?>" value="0" class="text-uppercase" name="sub_total<?php echo $i; ?>" style="width:70px;" type="text"/>
                            </td>
                            <td>
                                  <input type="hidden" readonly id="total_price<?php echo $i; ?>" class="text-uppercase"  name="total_price<?php echo $i; ?>" style="width:70px;" type="text"/>
                            </td>
                            <td>
                            	
                                <input type="hidden" id="username<?php echo $i; ?>" class="text-uppercase" name="username" style="width:70px;" type="text"/>
                            </td>
                            <td>
                                  <input  type="hidden" readonly id="item_catid<?php echo $i; ?>" class="text-uppercase" name="item_catid<?php echo $i; ?>" style="width:70px;">
                            </td>
                       </tr>
                          <script>
                          $('#item_no<?php echo $i; ?>').keyup(function(){
                            var name = $('#item_no<?php echo $i; ?>').val();
                                 // alert(name);
                            $.post("<?php echo site_url("stockController/checkStock") ?>", {name : name}, function(data){	
                             //alert(data);	
                            var d = $.parseJSON(data);				
                            $('#item_name<?php echo $i; ?>').val(d.itemName);
                            $('#item_cat<?php echo $i; ?>').val(d.itemCat);
                            $('#item_catid<?php echo $i; ?>').val(d.itemCatid);
                            $('#item_quantity1<?php echo $i;?>').val(d.qunatity);
                            $('#item_size<?php echo $i; ?>').val(d.itemsize);
                            $('#item_price<?php echo $i; ?>').val(d.price);
                            });
                            });
                            

                           $("#add<?= $i;?>").click(function(){
                              var t_qty = Number($("#item_quantity1<?php echo $i;?>").val());
                              var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                              var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                              var new_qty = old_qty + 1;
                              var sub_ttt = new_qty * prc;
                              var cu_tt = parseFloat($('#total').val()) + prc;
                              $("#item_quantity<?php echo $i;?>").val(new_qty);
                              $("#sub_total<?php echo $i;?>").val(sub_ttt);
                              $("#total").val(cu_tt);
                            // //   alert(sub_ttt);
                           });
                           $("#sub<?= $i;?>").click(function(){
                              var t_qty = Number($("#item_quantity1<?php echo $i;?>").val());
                              var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                              var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                              if(old_qty>0){
                              var new_qty = old_qty - 1;
                              var sub_ttt = new_qty * prc;
                              var cu_tt = parseFloat($('#total').val()) - prc;
                              $("#item_quantity<?php echo $i;?>").val(new_qty);
                              $("#sub_total<?php echo $i;?>").val(sub_ttt);
                              $("#total").val(cu_tt);
                              }
                            // //   alert(sub_ttt);
                           });
                       </script>
                       <?php  $i++; } ?>
                       <tr>
                            	<!-- <td colspan="3"><strong>Previous Balance</strong></td> -->
                                <td colspan="5"><input type="hidden" readonly id="valid_id" name="p_balance" style="width:180px;" type="text"/></td>
                       </tr>
                      
                       <!-- <tr >
                            
                             <td >  <label>Direct Sale &nbsp;&nbsp;&nbsp;</label> <input  id="direct" class="text-uppercase" name="delivery" style="width:70px;" type="radio" value="cash" checked/>
                            </td>
                            <td> <label>Cash On Delivery &nbsp;&nbsp;&nbsp;</label>  <input  id="cash" class="text-uppercase" name="delivery"style="width:70px;" type="radio" />
                            </td>
                        </tr> -->
                       <tr id="unm">
                            
                             <td>  
                              <input  id="username" class="text-uppercase" name="username" style="width:180px;" type="hidden"/>
                                                 
                        </td>
                           </tr>
                       <tr>
                            	<!-- <td colspan="3"><strong>Balance</strong></td> -->
                                <td colspan="5"><input type="hidden" id="balance" name="balance" style="width:180px;" type="text" /></td>
                       </tr>
                      </tbody>
                  </table>
                 
                  </div>
                                 
                                                    </div>
                                        
                                           </div>
                                    </div>
                            </div>
                    </div>        
                    