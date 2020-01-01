               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 
                   <div class="container">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                                <div class="panel-heading panel-red" style="text-align:center;color:#01a9ac;">
                                                  
                                                </div>
                                                
                                                <div class="panel-body">
                                                     <form action="<?= base_url();?>index.php/stockController/directsale" method="post">    
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            
                                                        </div>
                                                         <div class="col-md-3">
                                                            <label >Total</label>
                                                            <?= $number;?>
                                                            <input id="total" name="total" value = "0" class="form-control" style="width:180px;" type="text" required  readonly />
                                                             <input type="hidden" id="comm" name="comm" value = "<?=  $comm;?>" class="form-control" style="width:180px;" type="text" required   />
                                                       <input type="hidden" id="number" name="number" value = "<?=  $number;?>" class="form-control" style="width:180px;" type="text" required   />
                                                       
                                                        </div>
                                                         <div class="col-md-3">
                                                            <label>Paid</label>
                                                          <input id="paid" class="form-control" name="paid" style="width:180px;" type="text" required />
                                                        </div>
                                                        <div class="col-md-4">
                                                             <input type="submit" value="submit"  id="submt" >
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
                                 <input id="itemid<?php echo $i; ?>" type="hidden" name="itemid<?php echo $i; ?>"  style="width:90px;">
                               
                                    <input id="item_no<?php echo $i; ?>" name="item_no<?php echo $i; ?>" value=" " style="width:90px;">
                          

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
                             <input readonly id="item_quantity_r<?php echo $i; ?>" class="text-uppercase" name="item_quantity_r<?php echo $i; ?>" style="width:70px;" type="text"/>
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
                                if(name.length>0){
                            $.post("<?php echo site_url("stockController/checkStock") ?>", {name : name}, function(data){	
                           
                            var d = $.parseJSON(data);	
                            $('#itemid<?php echo $i; ?>').val(d.itemid);
                            $('#item_name<?php echo $i; ?>').val(d.itemName);
                            $('#item_cat<?php echo $i; ?>').val(d.itemCat);
                            $('#item_catid<?php echo $i; ?>').val(d.itemCatid);
                            $('#item_quantity_r<?php echo $i;?>').val(d.qunatity);
                            $('#item_size<?php echo $i; ?>').val(d.itemsize);
                            $('#item_price<?php echo $i; ?>').val(d.price);
                            });
                                }
                                else
                                {
                                    alert("Worng Sec No.");    
                                }
                            });
                            

                           $("#add<?= $i;?>").click(function(){
                               
                              var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
                              var old_qty = Number($("#item_quantity<?php echo $i;?>").val());
                              var prc = parseFloat($("#item_price<?php echo $i;?>").val()); 
                              if(t_qty>old_qty){
                              var new_qty = old_qty + 1;
                              var sub_ttt = new_qty * prc;
                              var cu_tt = parseFloat($('#total').val()) + prc;
                              $("#item_quantity<?php echo $i;?>").val(new_qty);
                              $("#sub_total<?php echo $i;?>").val(sub_ttt);
                              $("#total").val(cu_tt);
                              }
                            // //   alert(sub_ttt);
                           });
                           $("#sub<?= $i;?>").click(function(){
                              var t_qty = Number($("#item_quantity_r<?php echo $i;?>").val());
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
                           
                        //   $('#submt').click(function(){
                        //       var comm= $('#comm').val();
                        //       var total= $('#total').val();
                        //         var number= $('#number').val();
                        //         var paid= $('#paid').val();
                        //         var itemid= $('#itemid<?= $i ;?>').val();
                        //         var item_no= $('#item_no<?= $i ;?>').val();
                        //          var item_name= $('#item_name<?= $i ;?>').val();
                        //          var item_price= $('#item_price<?= $i ;?>').val();
                        //           var item_quantity= $('#item_quantity<?= $i ;?>').val();
                        //           var sub_total= $('#sub_total<?= $i ;?>').val();
                                
                                
                        //         $.post("<?= site_url();?>index.php/stockController/directsale",
                        //         { comm : comm , total : total , paid : paid ,number : number , item_no: item_no , item_price : item_price, item_quantity : item_quantity ,sub_total : sub_total,itemid: itemid , item_name : item_name},
                        //         function(data){
                                    
                        //         });
                        //   });
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
                  </form> 
                                 
                                                    </div>
                                        
                                           </div>
                                    </div>
                            </div>
                    </div>        
                    