<div class="row" style="padding:1% 0">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" href="<?php echo site_url("site/createCampaignGroup?id=").$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp;
    </div>
</div>

<div class="well">
<b>Selected Groups</b>
</div>
<?php
                            if(!empty($selectedgroup))
                            {
                            ?>
						    <div class="row state-overview">
                              <?php
                                foreach ($selectedgroup as $row)
                                {
                                ?>
                                    <div class="col-lg-6 col-sm-6">
                                        <section class="panel">
                                            <div class="symbol terques">
                                                <i class="icon-user"></i>
                                            </div>
                                <!--            <a href="">-->
                                            <div class="value">
                                               <p>Name</p>
                                                <h1><?php  echo $row->groupname; ?></h1>

                                            </div>
                                <!--            </a>-->
                                        </section>
                                    </div>
<!--                                </div>-->
                                <?php
                                }
                                ?>
                            </div>
                            <?php
                            }
                            ?>

<div class="row">
    <div class="col-lg-12">
                                                                        
      <section class="panel">
            <header class="panel-heading">
                CampaignGroup Details
            </header>
            <div class="drawchintantable">
                <?php $this->chintantable->createsearch("CampaignGroup List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="campaign">campaign</th>
                            <th data-field="Timestamp">timestamp</th>
                            <th data-field="order">order</th>
                            <th data-field="status">Status</th>
                            <th data-field="group">group</th> 
                            <th data-field="Action ">Action</th>
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
                
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.campaign + "</td><td>" + resultrow.Timestamp + "</td><td>" + resultrow.order + "</td><td>" + resultrow.status + "</td><td>" + resultrow.group + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editCampaignGroup?id=');?>" + resultrow.id + "'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteCampaignGroup?campaigntestid='); ?>" + resultrow.id + "&id="+resultrow.campaignid + "'><i class='icon-trash '></i></a></td></tr>";
            }
            generatejquery("<?php echo $base_url;?>");
        </script>
    </div>
</div>
