<div class="container">
    <?php if(validation_errors()): ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="alert alert-warning">
                <?php echo validation_errors(); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-xs-12 col-sm-8 col-sm-push-2 col-md-6 col-md-push-3 col-lg-4 col-lg-push-4">
        <form class="form-signin panel" method="post" action="<?php echo base_url('admin/login'); ?>">
            <h2 class="form-signin-heading">Please sign in</h2>
            <input id="user" name="user" type="text" class="form-control" placeholder="Username" >
            <input id="pass" name="pass" type="password" class="form-control" placeholder="Password" >
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</div>