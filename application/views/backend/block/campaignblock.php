<section class="panel">

    <div class="panel-body">
        <ul class="nav nav-stacked">
            <li><a href="<?php echo site_url('site/editcampaign?id=').$before->id; ?>">Campagn Details</a></li>
<!--            <li><a href="<?php echo site_url('site/editaddress?id=').$before->id; ?>">Address</a></li>-->
            <li><a href="<?php echo site_url('site/viewcampaigngroup?id=').$before->id; ?>">Campaign Group</a></li>
            <li><a href="<?php echo site_url('site/viewcampaigntest?id=').$before->id; ?>">Campaign Test</a></li>
             <li><a href="<?php echo site_url('site/viewCampaignResult?id=').$before->id; ?>">Campaign Result</a></li>
        </ul>
    </div>
</section>