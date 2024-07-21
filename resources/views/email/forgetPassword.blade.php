<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border">
                <div class="card-header"><h4 style="text-align: center;">Forget Password Link</h4></div>
                    <div class="card-body">
                        <p>You can reset password from bellow link : </p>
                        <div class="position-btn">
                            <a role="button" class="btn btn-primary" href="{{ route('reset.password.get', $token) }}">Reset Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    p{
        text-align: center;
        text-decoration: none;
    }
    a{
        text-decoration: none;

    }
    .position-btn{
        display: flex;
        position: relative;
        justify-content: center;
    }
</style>