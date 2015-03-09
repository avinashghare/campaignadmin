<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <div class="pull-right">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                CampaignTest Details
            </header>
            <div class="panel-body">
                <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/createCampaignTestsubmit");?>' enctype='multipart/form-data'>
                    <div class="panel-body">
                       <input type="hidden" value="<?php echo  $this->input->get('id');?>" name="campaign"> 
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">group</label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown( "group",$group,set_value('group'), "class='chzn-select form-control'");?>
                            </div>
                        </div>
<!--
                        <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">reports</label>
                            <div class="col-sm-8">
                                <textarea name="reports" id="" cols="20" rows="10" class="form-control tinymce">
                                    <?php echo set_value('reports');?>
                                </textarea>
                            </div>
                        </div>
-->
                        <div class="form-group hidden" >
                        <label class="col-sm-2 control-label" for="normal-field">json</label>
                        <div class="col-sm-4">
                            <textarea name="json" id="" cols="20" rows="10" class="form-control tinymce fieldjsoninput"><?php echo json_encode($fieldjson,true); ?></textarea>

                        </div>
                    </div>
                    <div class="fieldjson"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary jsonsubmit">Save</button>
                                <a href="<?php echo site_url(" site/viewpage "); ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                </form>
                </div>
        </section>
        </div>
    </div>

<script type="text/javascript">
   
    $(document).ready(function () {
//        console.log($(".fieldjsoninput").val());
        filljsoninput(".fieldjsoninput",".fieldjson");
        $(".jsonsubmit").click(function() {
            jsonsubmit(".fieldjsoninput",".fieldjson");
            //return false;
        });
        
    });
</script>
