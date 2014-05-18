<h1>News</h1>
<?php
if (empty($news)) {
    echo "<h3>No news yet</h3>";
} else {
    ?>
    <ul class="timeline">
        <?php
        $i = 0;
        foreach ($news as $new) {
            ?>
            <li <?php if (!( ++$i % 2)) echo 'class="timeline-inverted"'; ?>>
                <div class="timeline-badge primary"><a><i class="glyphicon glyphicon-record" rel="tooltip" title="11 hours ago via Twitter" id=""></i></a></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h2><?php echo $new['name']; ?></h2>

                    </div>
                    <div class="timeline-body">
                        <?php echo $new['text']; ?>
                    </div>

                    <div class="timeline-footer">
                        
                        <a class="pull-right"><?php echo $new['date']; ?></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </li>
        <?php } ?>


        <li class="clearfix" style="float: none;"></li>
    </ul>
    <?php
}        
