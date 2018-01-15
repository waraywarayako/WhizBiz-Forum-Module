    <script type="text/javascript">
        $(document).ready(function(){
            $("#myModal").modal('show');
        });
    </script>
	
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang_key('topic_success'); ?></h4>
            </div>
            <div class="modal-body">
                <p>
                <strong><?php echo lang_key('note'); ?></strong> <?php echo lang_key('topic_successsub'); ?>.
                </p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo $redirect_link; ?>"><?php echo lang_key('okgot_it'); ?></a>
            </div>
        </div>
    </div>
</div>                              		