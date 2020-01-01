                               <div class="page-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!-- Zero config.table start -->
                                            <div class="panel panel-white">
                                   
                                                <div class="panel-heading panel-red">
                                                <center>  <h5 class="text-bold">Pending Order List</h5></center>
                                                </div>
                                                <div class="panel-body">
                   <div class=" table-responsive">
                  <table id="pendingorder" class="table  table-bordered ">
                <thead>
                  <tr style="background-color:#1ba593; color:white;">
                    <th>SNO</th>
                    <th>Order Number</th>
                   <th> Name</th>
                    <th> Username</th>
                    <th>T. Quantity</th>
                    <th>T. Amount</th>
                    <th>Order Date</th>
                    <th>Order Assign</th>
                    <th>Shop status</th>
                     <th>Invoice Detail</th>
                    <th>DI Status</th>
                    <th>Payment</th>
                 
                  </tr>
                </thead>
                <tbody>
                    
                  <?php
                        $subid=$this->session->userdata('id');

                    
                      $this->db->where('sub_branchid',$subid);
                       $this->db->where('ad_rec_pay',0);
                     $dt= $this->db->get("order_serial");
                     if($dt->num_rows()>0){
                        $orderdata=$dt->result(); 

                  $i=1;
                 foreach($orderdata as $row): 
                 
                    $this->db->where('id',$row->cust_id);
                      $custdetail1=$this->db->get('customers')->row();
                  //    $row=$orderdata->row();
                      
                //   print_r($row);
                //      exit();
                  ?>
                  <tr class="text-uppercase text-center">
                    <td><?php echo $i;?></td>
                    
              
                    
                      <td><a href="<?php echo base_url()?>shopController/adminproductdeatil/<?php echo $row->order_no;?>" class="btn btn-danger"><?php echo $row->order_no;?></a></td>
                        <td><?php echo $custdetail1->name;?></td>
                          <td><?php echo $custdetail1->username;?></td>
                      <?php 
                             $this->db->select_sum('quantity');
                             $this->db->select_sum('subtotal');
                             $this->db->where('order_no',$row->order_no);
                             $this->db->where('cust_id',$row->cust_id);
                             $this->db->where('date',$row->order_date);
                             $dt1= $this->db->get("order_detail")->row();
                            // print_r($dt1);
                            // exit();
                           ?>
                      <td><?php echo $dt1->quantity;?></td>
                      <td><?php echo $dt1->subtotal;?></td>
                      <td><?php echo $row->order_date;?></td>
                    <td><?php if($row->status==0 && $row->shop_order==0){?>
                   
                     <button type="sumbit"  class="btn btn-warning"><?php echo "Assign"?><?php } elseif($row->status==0 && $row->shop_order==1){ ?>
                          <input type="hidden" id="orderno<?php echo $i; ?>" value="<?php echo  $row->order_no;?>">
                     <button type="sumbit" id="assign<?php echo $i;?>" class="btn btn-warning"><?php echo "Assign"?></button><select id="delivery<?php echo $i;?>" class="form-control" style="max-height:30px;max-width:150px;margin-left:-12px;"></select>
                    <?php } else{  
                
                   $id= $this->session->userdata("id");
                    $aa= array('sub_branchid'=>$id,
                                'emp_type'=>'5',
                                'status'=>'1');
                      // $this->db->where('sub_branchid',$id);
                      // $this->db->where('emp_type',5);
                      // $this->db->where('status',1);
                      $this->db->where($aa);
                      $deliveryboy=$this->db->get('employee');//->num_rows();
                      // echo $deliveryboy;
                      // exit;
                          
                      ?>
                       <input type="hidden" id="orderno1<?php echo $i; ?>" value="<?php echo  $row->order_no;?>">
         <select class="form-control text-uppercase"  id="selectdelivery<?php echo $i;?>" style="max-height:40px;max-width:120px;margin-left:-12px;color:#01a9ac">
             <option>--select--</option>
           <?php if($deliveryboy->num_rows()>0)
         {
         $boy=$deliveryboy->result(); ?>
      <?php 
       foreach($boy as $row1)
       {            $this->db->where('order_no',$row->order_no);
                     $boy1=$this->db->get('order_serial')->row();
       ?> 
  <option class="text-uppercase" style="color:#01a9ac" value="<?php echo $row1->id;?>" <?php if($boy1->del_boy_id == $row1->id): echo 'selected="selected"'; endif; ?>><?php echo  $row1->name." [ ". $row1->username. " ] ";?></option>     
            
      <?php } ?>
        
    <?php }?></select><?php }?></td>
                      <td><?php if($row->status ==00&& $row->shop_order == 0 ){?><a href="<?php echo base_url()?>shopController/shoporderprocced/<?php echo $row->order_no;?>" class="btn btn-success"><?php echo "Procced";?></a><?php } else if( $row->status ==1 && $row->shop_order==1){ ?><a href="#" class="btn btn-secondary"><?php echo "Confirmed";?></a><?php  } else{ ?> <a href="#" class="btn btn-primary"><?php echo "Waiting";?></a><?php   }?></td>
                      
                        <td><?php if($row->shop_order == 1){?><a href="<?php echo base_url();?>shopController/invoice/<?php echo $row->order_no?>" class="btn btn-primary"><?php echo $row->invoice_no;?></a><?php }else{?><a href="#" class="btn btn-alert"><?php echo $row->invoice_no;?></a><?php }?></td> 
                        
                    <td><?php if($row->order_status==0){?><a href="#" class="btn btn-warning"><?php echo "Not Deliver"?></a><?php } else {?><a href="#" class="btn btn-danger"><?php echo "Delivered";?></a><?php }?></td>
                    
                  <td><?php if($row->ad_rec_pay==0){?><a href="<?php echo base_url();?>shopController/admincash/<?php echo $row->order_no?>" class="btn btn-success"><?php echo "Not Recieve";?></a><?php }else{?><a href="#" class="btn btn-info"><?php echo "Recieve";?></a><?php }?></td>
                  
                  </tr>



                  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

                  <script>
                  $(document).ready(function() {
                      
                 $('#delivery<?php echo $i;?>').hide();    
                 $('#assign<?php echo $i;?>').click(function(){
              
               // alert(orderno);
              $.post("<?php echo site_url('shopController/selectdelivery')?>", {}, function(data){
                $('#assign<?php echo $i;?>').hide();
                 $('#delivery<?php echo $i;?>').show(); 
                 $('#delivery<?php echo $i;?>').html(data);
                      })
                    });
    
    $('#delivery<?php echo $i;?>').change(function(){
      var id = $('#delivery<?php echo $i;?>').val();
      var orderno = $('#orderno<?php echo $i; ?>').val();
      $.post("<?php echo site_url('shopController/assigntodelivery')?>", {id : id,orderno:orderno}, function(data){ 
        //  // alert(data)
        //  $('#selectdelivery<?php echo $i;?>').html(data);
      })
    });
    
     $('#selectdelivery<?php echo $i;?>').change(function(){
      var id = $('#selectdelivery<?php echo $i;?>').val();
    //   alert(id);
      var orderno = $('#orderno1<?php echo $i; ?>').val();
      $.post("<?php echo site_url('shopController/assignagaindelivery')?>", {id : id,orderno:orderno}, function(data){ 
        //  // alert(data)
        //  $('#selectdelivery<?php echo $i;?>').html(data);
      })
    });
    
    
    //   $('#paymentrecive<?php echo $i;?>').hide();
     $('#payment<?php echo $i;?>').click(function(){
       // var id = $('#selectdelivery<?php echo $i;?>').val();
      var orderno = $('#orderno2<?php echo $i; ?>').val();
    // alert(orderno);
      $.post("<?php echo site_url('shopController/shappaymentrecieve')?>", {orderno:orderno}, function(data){ 
         // alert(data);
         $('#show').html(data);
         $('#payment<?php echo $i;?>').hide();
      })
    });
    
    
  });
</script> 

                  <?php  $i++;
              //  endforeach;
                    
       endforeach;  } ?>
                </tbody>

              </table>

            </div>
        </div>
         <center>  <a href="<?php echo base_url();?>shopController/index"  class ="btn btn-info">Done</a></center>
    </div>
    </div>
    </div>
    </div>
</div>

