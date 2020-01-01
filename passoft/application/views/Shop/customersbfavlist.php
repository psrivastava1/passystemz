<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <!-- Zero config.table start -->
      <div class="panel panel-white">
        <div class="panel-heading panel-red">
        <?php 
                          $this->db->where('username',$username);
                          $row1=$this->db->get('customers')->row();
?>
          <center><h5 class="text-bold"><?php echo $row1->name;?> [Demand List]</h5></center>
        </div>
        <div class="panel-body">
             <div class="row">
                        <div class="col-md-12 space20">
                            <div class="btn-group pull-right">
                                <button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
                                    Export <i class="fa fa-angle-down"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-light pull-right">
                                    <li>
                                        <a href="#" class="export-pdf" data-table="#sbfav">
                                            Save as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-png" data-table="#sbfav">
                                            Save as PNG
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-csv" data-table="#sbfav">
                                            Save as CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-txt" data-table="#sbfav">
                                            Save as TXT
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-xml" data-table="#sbfav">
                                            Save as XML
                                        </a>
                                    </li>
                                 <li>
                                        <a href="#" class="export-excel" data-table="#sbfav">
                                            Export to Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-doc" data-table="#sbfav">
                                            Export to Word
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-powerpoint" data-table="#sbfav">
                                            Export to PowerPoint
                                        </a>
                                    </li>

                            </div>
                        </div>
                    </div>
          <div class="dt-responsive table-responsive">
            <table id="sbfav" class="table table-striped table-bordered nowrap">
              <thead>
                <tr style="background-color:#1ba593; color:white;">
                  <th>S. No.</th>
                   <th>Company</th>
                  <th>Product  Name</th>
                  <th>Category</th>
                  <th>Sub Category</th>
                  <th> Size</th>
                  <th> Image</th>

                </tr>
              </thead>
              <tbody>
                <?php 
                
                     $this->db->where("customer_id",$row1->id);
                 $dt= $this->db->get("favourite_list")->result();
                    $i=1;
                  foreach($dt as $row):?>
                <tr class="text-uppercase">
                  <td><?php echo $i;?></td>
                  <?php 
                          $this->db->where('id',$row->product_code);
                   $stproduct=$this->db->get('stock_products')->row(); 
                 
                         
                       
                   ?>
                  <td><?php echo $stproduct->company;?></td>
                  <td><?php echo $stproduct->name;?></td>
                 <?php  if($stproduct->sub_category==0) { ?>
                  <td>Not Selected</td>
                  <td>Not Selected</td>
                 <?php       }
                     else{
                      $this->db->where('id', $stproduct->sub_category);
                      $subcate=$this->db->get('sub_category')->row();
                      $subcate1=$subcate->name;
                      $this->db->where('id',$subcate->cat_id);
                       $cate=$this->db->get('category')->row();
                      if($cate){$cate1=$cate->name;} ?>
                   
                  <td><?php echo $cate1;?></td>
                     <td><?php echo $subcate1;?></td><?php } ?>

                  <td><?php echo $stproduct->size;?></td>
                
                  <td> <?php  if($stproduct->file1>0){?> <img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stproduct->file1; ?>"
                                                style="height:50px;width:100px;"><?php } else{ ?><img src="<?php echo $this->config->item('asset_url'). '/productimg/' . $stproduct->file2; ?>"
                                                style="height:50px;width:100px;"> <?php } ?>
                      </td>  </tr>
                <?php  $i++;
                endforeach;
                   ?>
              </tbody>
            </table>
          </div>
        </div>
         <center>  <a href="<?php echo base_url();?>shopController/index"  class ="btn btn-info">Done</a></center>
      </div>
    </div>
  </div>
</div>