<section class="panel">
    <header class="panel-heading">
        CampaignGroup Details
    </header>
    <div class="panel-body">
        <form class='form-horizontal tasi-form' method='post' action='<?php echo site_url("site/editCampaignGroupsubmit");?>' enctype='multipart/form-data'>
            <input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
     <input type="hidden" id="normal-field" class="form-control" name="campaign" value='<?php echo set_value(' Timestamp ',$before->campaign);?>'>
<!--
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">timestamp</label>
                <div class="col-sm-4">
                    <input type="text" id="normal-field" class="form-control" name="Timestamp" value='<?php echo set_value(' Timestamp ',$before->Timestamp);?>'>
                </div>
            </div>
-->
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">order</label>
                <div class="col-sm-4">
                <input type="text" id="normal-field" class="form-control" name="order" value='<?php echo set_value(' Timestamp ',$before->order);?>'>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">Status</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "status",$status,set_value( 'status',$before->status),"class='chzn-select form-control'");?>
                </div>
            </div>
            <div class=" form-group">
                <label class="col-sm-2 control-label" for="normal-field">group</label>
                <div class="col-sm-4">
                    <?php echo form_dropdown( "group",$group,set_value( 'group',$before->group),"class='chzn-select form-control'");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="normal-field">&nbsp;</label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href='<?php echo site_url("site/viewpage"); ?>' class='btn btn-secondary'>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
