<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit movie</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <form action="/main/edit" method="POST" enctype="multipart/form-data">
                        <div class="form-group" class="w-25">
                            <label>Name movie</label>
                            <input type="text" class="form-control w-25" name="title" placeholder="enter name">
                        </div>
                        <div>
                            <?php if (isset($_SESSION['errorStore'][0])) : ?>
                                <span class="text-danger"><?= $_SESSION['errorStore'][0];
                                    unset($_SESSION['errorStore'][0]) ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (isset($_SESSION['errorStore'][1])) : ?>
                                <span class="text-danger"><?= $_SESSION['errorStore'][1];
                                    unset($_SESSION['errorStore'][1]) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group w-50">
                            <label for="InputFile">Add Poster</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="poster_image">
                                    <label class="custom-file-label">Choice image</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" class="w-25">
                            <label>Release date</label>
                            <input type="date" class="form-control w-25" name="date">
                        </div>
                        <div class="mb-3">
                            <?php if (isset($_SESSION['errorStore'][2])) : ?>
                                <span class="text-danger"><?= $_SESSION['errorStore'][2];
                                    unset($_SESSION['errorStore'][2]) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                                <textarea class="w-50" name="conten">
                                </textarea>
                        </div>
                        <div>
                            <?php if (isset($_SESSION['errorStore'][3])) : ?>
                                <span class="text-danger"><?= $_SESSION['errorStore'][3];
                                    unset($_SESSION['errorStore'][3]) ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (isset($_SESSION['errorStore'][4])) : ?>
                                <span class="text-danger"><?= $_SESSION['errorStore'][4];
                                    unset($_SESSION['errorStore'][4]) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Edit">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>