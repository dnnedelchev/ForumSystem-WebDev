
<div class="row">
    <div class="col-md-12">
        <div class="well bs-component">
            <form class="form-horizontal" method="post" action="/user/edit">
                <fieldset>
                    <div class="row"><legend>Edit Profile</legend></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="username" name="username" value=<?= $this->currentUser['username']; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="personal_name" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="personal_name" name="personal_name" value=<?= $this->currentUser['personal_name']; ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $this->currentUser['email']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="skype" class="col-lg-2 control-label">Skype</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="skype" name="skype" value="<?= $this->currentUser['skype']; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birthdate" class="col-lg-2 control-label">Birthdate</label>
                                <div class="col-lg-10">
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="birthdate" value="<?= $this->currentUser['birthdate']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-11 col-lg-offset-1">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                    <button type="submit" class="btn btn-primary" value="edit">Submit</button>
                                    <a class="btn btn-info" href="/user/view/<?= $this->currentUser['username']; ?>">View profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>