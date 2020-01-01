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
                                                        <div class="col-md-6">
                                                            <label>Direct Sale</label>
                                                            <input type="radio" name="sale" id="directsale" value="1">
                                                        </div>
                                                     <div class="col-md-6">
                                                             <label>Online Order</label>
                                                            <input type="radio" name="sale" id="online" value="2">
                                                    </div>
                                                  </div>
                                                  <div id="subs">
                                                      <label>Subscriber Username</label>
                                                            <input type="text" name="sale" id="subsnm" value="">
                                                      
                                                  </div>
                                                    <div id="order">
                                                      <label>Enter Order Number</label>
                                                            <input type="text" name="sale" id="orderno" value=" ">
                                                      
                                                  </div>
                                                  <div id="num" >
                                                      <label> Enter Number Of Item</label>
                                                      <input type="number" id="rows"   vale=""> 
                                                  </div>
                                                   <div class="row" id="directrows">
                
                                                     </div>
                                              
                             
                              <script>
                                  $(document).ready(function(data){
                                     
                                      $('#num').hide();
                                       $('#subs').hide();
                                       $('#order').hide();
                                    $('#directrows').hide();
                                  
                                  $('#directsale').click(function(){
                                        $('#order').hide();
                                         $('#num').hide();
                                    var dr= $('#directsale').val();
                                    if(dr==1){
                                          $('#subs').show();
                                    }
                                    else{
                                        $('#subs').hide(); 
                                    }
                                        
                                    
                                  });
                                   $('#online').click(function(){
                                        $('#subs').hide();
                                         $('#num').hide();
                                    var dr= $('#online').val();
                                   
                                    if(dr==2){
                                          $('#order').show();
                                    }
                                    else{
                                        $('#order').hide(); 
                                    }
                                        
                                    
                                  });
                                  $('#subs').change(function(){
                                      var subsnumber =$('#subs').val();
                                      
                                       $.post("<?= site_url();?>index.php/stockController/checkuser" , { subsnumber : subsnumber } , function(data){
                                           alert(data);
                                           if(data=="tt"){
                                           $('#num').show();
                                           }else{
                                               alert("user not exist");
                                           }
                                           
                                      });
                                      
                                  });
                                  
                                   $('#orderno').change(function(){
                                      
                                    var dr= $('#orderno').val();
                                    // alert(dr.length);
                                    if(dr.length>8){
                                       
                                          $('#num').show();
                                    }
                                    else{
                                        $('#num').hide(); 
                                    }
                                        
                                    
                                  });
                                  
                                  $('#rows').change(function(data){
                                     var numrow= $('#rows').val();
                                     if($('#directsale').is(':checked')){
                                         alert("kkk");
                                     }
                                     else{
                                         alert("bbbb");
                                     }
                                     alert(numrow);
                                    
                                      $('#directrows').show();
                                      $.post("<?= site_url();?>index.php/stockController/direct" , { numrow : numrow } , function(data){
                                           $('#directrows').show();
                                            $('#directrows').html(data);
                                      });
                                  });
                                  
                                  });
                              </script>
                              
                              
               
                              
             </div>
         </div>
                     </div>
          </div>
          </div>