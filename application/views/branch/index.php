<div class="page-content">
   <div class="breadcrumb-section">
      <ul class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>"> <i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
         <li class="breadcrumb-item"><?php echo isset($meta_title)?$meta_title:'';?></li>
      </ul>
      <div class="clearfix"></div>
   </div>

   <div class="form_section">
      <div class="container-fluid">

         <form action='' method="get">
            <div class="row">
               <div class="form-content">
                  <div class="form-row category-form">
                     <h2>Search</h2>
                     <div class="form-content-inner">
                        <div class="col-md-12 col-sm-12">
                           <div class="form-group form-left">
                              <label for="name"> Search </label>
                              <input  type="text" class="form-control" id="Search-field" name="Search" placeholder="Enter Search Key">
                           </div>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
         
      </div>
   </div>

   <div class="search-result">
      <div class="container-fluid">

         <?php if ($this->session->flashdata('error')!='') { ?>
         <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
         </div>
         <?php } ?>
         <?php if ($this->session->flashdata('success')!='') { ?>
         <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
         </div>
         <?php } ?>

         
         <div class="row">
            <div class="col-md-12">
               <div class="table-responsive">
                  <div class="search-result-table">
                  
                    <div style="text-align: right; padding-bottom: 10px;"> <a href="<?php echo base_url('branch/add');?>" class="btn btn-info"> Add New </a> </div>
                  
                     <table class="table table-bordered table-striped table-datatable">
                        <thead class="thead-inverse">
                           <tr>
                              <th style="width:20px;">SL</th>
                              <th>Branch Name</th>
                              <th>Branch Code</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              if(isset($branch) && !empty($branch))
                              {
                                $i = 0;
                                foreach ($branch as $value) {
									//echo "<pre>";print_r($value);
                                $i++;
                              ?>
                           <tr>
                              <td scope="row"><?php echo $i;?></td>
                              <td><?php echo isset($value['branch'])?$value['branch']:'';?></td>
                              <td><?php echo isset($value['code'])?$value['code']:'';?></td>
                              <td>
                                <a href="<?php echo base_url('branch/edit/');?><?php echo isset($value['_id'])?$value['_id']:'';?>" class="view" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i>   </a>

                                <a href="<?php echo base_url('branch/delete/');?><?php echo isset($value['_id'])?$value['_id']:'';?>" class="delete" onclick="return confirm('Are you sure you want to delete it ?')" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> </a>
                              </td>
                           </tr>
                           <?php
                              }
                           }else{
                           ?>
                           <tr>
                              <td colspan="7" align="center" valign="middle" class="blue-block">No Records Found</td>
                           </tr>
                           <?php } ?> 
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $this->load->view('layouts/includeJS.php'); ?>