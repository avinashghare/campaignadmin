<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="<?php echo site_url("site/createCampaignTest?id=").$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                CampaignTest Details
            </header>
            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("CampaignTest List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="campaign">campaign</th>
                            <th data-field="Timestamp">Timestamp</th>
                             <th data-field="group">group</th>
<!--                            <th data-field="reports">reports</th> -->
                            <th data-field="Action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <?php $this->chintantable->createpagination();?>
            </div>
        </section>
        <script>
            function drawtable(resultrow) {
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.campaign + "</td><td>" + resultrow.Timestamp + "</td><td>" + resultrow.group + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editCampaignTest?id=');?>" + resultrow.id + "&campaignid="+resultrow.campaignid +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteCampaignTest?campaigntestid='); ?>" + resultrow.id + "&id="+resultrow.campaignid +"'><i class='icon-trash '></i></a></td></tr>";
            }
            generatejquery("<?php echo $base_url;?>");
        </script>
    </div>
</div>
