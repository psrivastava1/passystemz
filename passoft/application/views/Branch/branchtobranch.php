<div class="page-body">
  <div class="row">

    <table class="table table-bodered table-stripped">

      <thead>
        <tr>
          <th>SNO</th>

          <th>Product Name</th>
          <th>Product Code</th>
           <th style="width:8px;">Size</th>
          <th style="width:8px;">Image</th>
          <th>Quantity</th>
        </tr>
      </thead>
      <tbody style="margin-top:2px;">
        <?php        
                  
                   $dt=date('Y-m-d');
                   $this->db->where('DATE(date)',$dt);
                   $this->db->where('branch_id',$reciever);
                  $brwproduct=$this->db->get('branch_wallet')->result();
                  $this->db->where('id',$reciever);
                  $branch=$this->db->get('branch')->row();
                   $i=1;
                  foreach ($brwproduct as $value):

                  $this->db->where('hsn',$value->p_code);
                  $sproduct=$this->db->get('stock_products')->row(); 
                  ?>
        <tr class="text-uppercase">
          <td><?php echo $i;?></td>
          <td><?php echo $sproduct->name;?> </td>
          <td><?php echo $value->p_code;?> </td>
          <td style="width:8px;color:black;"><?php echo $sproduct->size?> </td>
                  <td style="width:8px;color:black;"><img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $sproduct->file1; ?>"
                                                style="height:50px;width:30px;" class="zoom1"> </td>
          <td><?php echo  $value->rec_quantity;?> </td>
        </tr>
        <?php $i++;endforeach;?>
      </tbody>
    </table>
      <a href="<?php echo base_url();?>stockController/generate_invoice/<?php echo $branch->username;?>" class="btn btn-success">Generate Invoice</a>
  </div>
  <?php $this->load->view('footerJs/producttransfer');?>
</div>