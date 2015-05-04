<!--<form method="post" action="/user/login">-->
<!---->
<!--    <input type="text" value="username" id="username" name="username">-->
<!--    <input type="password" id="password" name="password">-->
<!--    <input type="submit" value="login" name="login">-->
<!---->
<!--</form>-->
<div class="row">
    <div class="col-md-12">
        <div class="well bs-component">
            <form class="form-horizontal" method="post" action="/user/login">
                <fieldset>

                    <div class="row"><legend>Login</legend></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="col-md-2 control-label">Username *</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="username" required name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-2 control-label">Password *</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" id="inputPassword" required name="password" placeholder="Password">
                                </div>
                            </div>
                        </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-11 col-lg-offset-1">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a class="btn btn-info" href="/user/register">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>