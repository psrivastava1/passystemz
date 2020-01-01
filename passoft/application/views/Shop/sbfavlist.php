<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <!-- Zero config.table start -->
      <div class="panel panel-white">
        <div class="panel-heading panel-red">
        <center><h5 class="text-bold">Demand List By Subscriber</h5></center>
        </div>
         <div class="panel-body">
        <center><p style="color:#01a9ac;font-size:20px;align:justify;">In This Area You Can View All Subscribers Demand List .</br>
        On click View Demand List You Can View Perticular Subscriber Demand List</p></center>
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
                                        <a href="#" class="export-pdf" data-table="#shopfavlist">
                                            Save as PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-png" data-table="#shopfavlist">
                                            Save as PNG
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-csv" data-table="#shopfavlist">
                                            Save as CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-txt" data-table="#shopfavlist">
                                            Save as TXT
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-xml" data-table="#shopfavlist">
                                            Save as XML
                                        </a>
                                    </li>
                                 <li>
                                        <a href="#" class="export-excel" data-table="#shopfavlist">
                                            Export to Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-doc" data-table="#shopfavlist">
                                            Export to Word
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="export-powerpoint" data-table="#shopfavlist">
                                            Export to PowerPoint
                                        </a>
                                    </li>

                            </div>
                        </div>
                    </div>
          <div class=" table-responsive">
            <table id="shopfavlist" class="table table-striped table-bordered nowrap">
              <thead>
                <tr style="background-color:#1ba593; color:white;">
                  <th>S.No.</th>
                  <th>Subscriber Name</th>
                  <th>Branch Name</th>
                  <th>Mobile Number</th>
                  <th>Address</th>
                 <th>view Demand List</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                        $subid=$this->session->userdata('id');
                        $this->db->where('id',$subid);
                        $sub=$this->db->get('sub_branch')->row();
                        $sub1=$sub->district;
                        
                         $this->db->where('sub_branchid',$subid);
                         $this->db->where('district',$sub1);
                         $custdetail=$this->db->get('customers');
                        //  print_r($subid);
                         // print_r($sub1);
                         if($custdetail->num_rows()>0){

                          $i=1;

                       foreach($custdetail->result() as $custdetail1):
                          //   print_r($custdetail1);
                            // exit();
                      $this->db->distinct(); 
                      $this->db->select('customer_id');
                      $this->db->where('customer_id',$custdetail1->id);
                      $dt=$this->db->get("favourite_list");
                      if($dt->num_rows()>0){
                         $dt1= $dt->result();
                      
                  
                  foreach($dt1 as $row):?>
                <tr class="text-uppercase">
                  <td><?php echo $i;?></td>
                  <?php //if($row >0){ }else{}
                          $this->db->where('id',$custdetail1->district);
                          $row2=$this->db->get('branch')->row();
                   ?>
                  <td>
                      
                     
                     <span style="color:#01a9ac;"><?php echo $custdetail1->name. " [ ". $custdetail1->username . " ] ";?></span> 
                          </td>
                  <td><?php echo $row2->b_name;?></td>
                  <td><?php  echo $custdetail1->mobile;?></td>
                  <td><?php echo $custdetail1->address;?></td> 
                    <td><a href="<?php echo base_url();?>shopController/showsbfavlist/<?php echo $custdetail1->username;?>" class="btn btn-info">View Demand List</a></td> 
                </tr>
                <?php  $i++;
                endforeach;
                      }
                       endforeach;
                      }
                    
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