<section class="panel">
    <header class="panel-heading">
        CampaignResult Details
    </header>
    <div class="panel-body">
        <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editCampaignResultsubmit");?>' enctype='multipart/form-data'>
            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<!--
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">Timestamp</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="Timestamp" value='<?php echo set_value(' Timestamp ',$before->Timestamp);?>'>
                </div>
            </div>
-->
<!--
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">reports</label>
                <div class="col-sm-8">
                    <textarea name="reports" id="" cols="20" rows="10" class="form-control tinymce">
                        <?php echo set_value( 'reports',$before->reports);?></textarea>
                </div>
            </div>
-->
           <div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Winner Group</label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown( "group",$group,set_value('group',$before->group), "class='chzn-select form-control'");?>
                            </div>
                        </div>
				<div class=" form-group hidden">
				  <label class="col-sm-2 control-label" for="normal-field">json</label>
				  <div class="col-sm-4">
					<textarea name="json" id="" cols="20" rows="10" class="form-control tinymce fieldjsoninput"><?php echo set_value( 'json',$before->reports);?></textarea>
				  </div>
				</div>
				<div class="fieldjson"></div>
            <div class="form-group">
<!--                <label class="col-sm-2 control-label" for="normal-field">campaign</label>-->
                <div class="col-sm-4">
                    <input type="hidden" id="normal-field" class="form-control" name="campaign" value='<?php echo set_value(' campaign ',$before->campaign);?>'>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary jsonsubmit">Save</button>
                    <a href='<?php echo site_url("site/viewpage"); ?>' class='btn btn-secondary'>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
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