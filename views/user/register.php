
<div class="row">
    <div class="col-md-12">
        <div class="well bs-component">
            <form class="form-horizontal" method="post" action="/user/register">
                <fieldset>

                    <div class="row"><legend>Register</legend></div>
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
                            <div class="form-group">
                                <label for="repeatPassword" class="col-md-2 control-label">Repeat password *</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" id="repeatPassword" required name="repeatPassword" placeholder="Repeat password">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Personal name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="skype" class="col-lg-2 control-label">Skype</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="skype" name="skype" placeholder="skype">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-11 col-lg-offset-1">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <button type="submit" class="btn btn-primary" value="register">Submit</button>
                                    <a class="btn btn-info" href="/user/login">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>