<div style="color:red; margin-top:10px;margin-bottom:10px;">
    <h4>Transfer List</h4>
</div>
    <table id="transfer_p" class="table table-bordered">
        <thead>
            <tr>
              <th style="width:8px;">#</th>
              <th style="width:8px;">P.Name</th>
              <th style="width:8px;">P.Code</th>
              <th style="width:8px;">Size</th>
              <!--<th style="width:8px;">Image</th>-->
              <th style="width:8px;">Qt</th>
              <th style="width:8px;">Date</th>
              <th style="width:8px;">Remove</th>
            </tr>
        </thead>
        <tbody>
          <?php
                    $this->db->where('invoice_number','');
                     $this->db->where('date(date)',date('Y-m-d'));
                    $this->db->where('status','0');
                    $this->db->where('sender_usernm',$this->session->userdata('username'));
                    // if($this->session->userdata('login_type')==1)
                    // {
                    //     $this->db->where('sender_usernm',$);
                    // }
                    // elseif($this->session->userdata('login_type')==2)
                    // {}
                    // elseif($this->session->userdata('login_type')==4)
                    // {}
                    $this->db->where('reciver_usernm',$idd);
                    $pd = $this->db->get('product_trans_detail')->result();
                   ?>
                    <?php  $j=1; 
                foreach($pd as $pdt)
                { ?>
                <tr>
                    <td><?php echo $j;?></td>
                    <?php 
                    $this->db->where('id',$pdt->p_code);
                    $pdata = $this->db->get('stock_products');
                    if($pdata->num_rows()>0)
                    { 
                        $p_data = $pdata->row();?>
                        <td><?php echo $p_data->name;?></td>
                        <td><?php echo $p_data->id;?></td>
                        <td><?php echo $p_data->size;?></td>  
                    <?php }
                    else
                    { ?>
                        <td><?php echo "N/A";?></td>
                        <td><?php echo "N/A";?></td>
                        <td><?php echo "N/A";?></td>  
                    <?php
                    }
                    ?>
                    <td><?php echo $pdt->quantity;?></td>
                    <input type="hidden" id="dlt_id<?php echo $j;?>" value="<?php echo $pdt->id;?>"/>
                    <td><?php echo $pdt->date;?></td>
                    <td><input type="button" id="dltt<?php echo $j;?>" class="btn btn-danger" value="Remove"></td>
                </tr>   
                <script>
                    $("#dltt<?php echo $j;?>").click(function(){
                        var dlt_id = $("#dlt_id<?php echo $j;?>").val();
                        // alert(dlt_id);
                        $.post("<?php echo site_url();?>stockController/delete_tranfr_pro",{dlt_id:dlt_id},function(data){
                            alert(data);
                            $("#transfer_p").load(location.href+" #transfer_p>","");
                            // $("#");
                        });
                    });
                </script>
            <?php   $j++; }
                
            ?>
        </tbody>
    </table>
      <a href="<?php echo base_url();?>stockController/generate_invoice/<?php echo $idd;?>" class="btn btn-success" target="_blank">Generate Invoice</a>
 